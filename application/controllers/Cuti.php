<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cuti extends CI_Controller {

    public function index()
    {
        $this->load->view('cuti/index');
    }

    public function v()
    {
        $data['cuti'] = $this->db->get('tbl_cuti')->result();
        $this->load->view('cuti/view', $data);
    }

    public function aksi()
    {
        $id_cuti = $this->input->post('id_cuti');
        $aksi = $this->input->post('aksi');
        $catatan = $this->input->post('catatan_petugas');
        $tgl = date('Y-m-d H:i:s');
        $lokasi = "lampiran/sk_cuti/";

        $config['upload_path']   = FCPATH . $lokasi;
        $config['allowed_types'] = 'pdf|jpg|jpeg|png';
        $config['max_size']      = 5120;
        $this->load->library('upload', $config);

        if (isset($_POST['btnproses'])) {
            $uploadData = [];

            // 🔹 Proses upload file SK cuti
            if (!empty($_FILES['sk_cuti_bympd']['name'])) {
                $rowLama = $this->db->get_where("tbl_cuti", ['id_cuti' => $id_cuti])->row();
                $fileLama = $rowLama->sk_cuti_bympd ?? '';

                if ($this->upload->do_upload('sk_cuti_bympd')) {
                    $gbr = $this->upload->data();
                    $fileName = preg_replace('/\s+/', '_', $gbr['file_name']);
                    $uploadData['sk_cuti_bympd'] = $lokasi . $fileName;

                    // Hapus file lama jika ada
                    if (!empty($fileLama) && file_exists(FCPATH . $fileLama)) {
                        @unlink(FCPATH . $fileLama);
                    }
                } else {
                    $this->session->set_flashdata('msg',
                        '<div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Perhatian!</strong> File SK Cuti gagal diupload: ' .
                        htmlentities(strip_tags($this->upload->display_errors('', ''))) . '
                        </div><br>'
                    );
                }
            }

            // 🔹 Data update dasar
            $dataUpdate = [
                'status'     => $aksi,
                'catatan'    => $catatan,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Gabungkan data upload (jika ada)
            if (!empty($uploadData)) {
                $dataUpdate = array_merge($dataUpdate, $uploadData);
            }

            // Simpan ke database
            $this->db->where('id_cuti', $id_cuti);
            $this->db->update('tbl_cuti', $dataUpdate);

            $this->session->set_flashdata('msg',
                '<div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Sukses!</strong> Status cuti + catatan' .
                (!empty($uploadData) ? ' + SK Cuti' : '') . ' berhasil diperbarui.
                </div><br>'
            );

            redirect('cuti/v');
        }

        // 🔹 Blok pengiriman laporan (lama)
        if (isset($_POST['btnkirim'])) {
            $id_laporan = htmlentities(strip_tags($this->input->post('id_laporan')));
            $data_lama  = $this->db->get_where('tbl_laporan', ['id_laporan' => $id_laporan])->row();
            $simpan = 'y';
            $pesan = '';
            $level = $this->session->userdata('level');
            $lokasi = "lampiran/laporan";
            $tgl = date('Y-m-d H:i:s');

            if ($level == 'superadmin') {
                $id_petugas = htmlentities(strip_tags($this->input->post('id_petugas')));
                $data = [
                    'petugas'         => $id_petugas,
                    'status'          => 'konfirmasi',
                    'tgl_konfirmasi'  => $tgl
                ];
                $pesan = 'Berhasil dikirim ke petugas';
                $this->Mcrud->kirim_notif('superadmin', $id_petugas, $id_laporan, 'superadmin_ke_petugas');
                $this->Mcrud->kirim_notif('superadmin', $data_lama->user, $id_laporan, 'superadmin_ke_notaris');
            } else {
                $pesan_petugas = htmlentities(strip_tags($this->input->post('pesan_petugas')));
                $status        = htmlentities(strip_tags($this->input->post('status')));
                $file          = $data_lama->file_petugas;
                $pesan         = 'Berhasil disimpan';

                if ($_FILES['file']['error'] <> 4) {
                    if (!$this->upload->do_upload('file')) {
                        $simpan = 'n';
                        $pesan  = htmlentities(strip_tags($this->upload->display_errors('<p>', '</p>')));
                    } else {
                        if ($file != '') {
                            @unlink("$file");
                        }
                        $gbr = $this->upload->data();
                        $filename = "$lokasi/" . $gbr['file_name'];
                        $file = preg_replace('/ /', '_', $filename);
                    }
                }

                $data = [
                    'pesan_petugas' => $pesan_petugas,
                    'status'        => $status,
                    'file_petugas'  => $file,
                    'tgl_selesai'   => $tgl
                ];
                $this->Mcrud->kirim_notif($data_lama->petugas, $data_lama->notaris, $id_laporan, 'petugas_ke_notaris');
            }

            if ($simpan == 'y') {
                $this->db->update('tbl_laporan', $data, ['id_laporan' => $id_laporan]);
                $this->session->set_flashdata('msg',
                    '<div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Sukses!</strong> ' . $pesan . '.
                    </div><br>'
                );
            } else {
                $this->session->set_flashdata('msg',
                    '<div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Gagal!</strong> ' . $pesan . '.
                    </div><br>'
                );
            }
            redirect('laporan/v');
        }
    }

    public function ajax()
    {
        if (isset($_POST['btnkirim'])) {
            $id = $this->input->post('id');
            $data = $this->db->get_where('tbl_laporan', ['id_laporan' => $id])->row();
            echo json_encode([
                'pesan_petugas' => $data->pesan_petugas,
                'status'        => $data->status
            ]);
        } else {
            redirect('404');
        }
    }
}
