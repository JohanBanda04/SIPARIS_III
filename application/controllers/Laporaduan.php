<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporaduan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();
        $this->load->model('Mcrud');
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->library('upload');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function v()
    {
        if (isset($_POST['btnupdate_aduan'])) {
            $id_pengaduan = $this->input->post('id_pengaduan');
            $dataPengaduan = $this->db->get_where('tbl_pengaduan', ['id_pengaduan' => $id_pengaduan])->row();
            if (empty($id_pengaduan)) {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger">ID pengaduan tidak ditemukan!</div>');
                redirect("laporaduan/v");
            }

            $petugasIdUser = $this->input->post('petugas');
            $idSubCategoryOnly = $this->input->post('id_sub_kategori');
            $isi_pengaduan = $this->input->post('isi_pengaduan');
            $ket_pengaduan = $this->input->post('ket_pengaduan');

            $updateData = [
                'petugas' => $petugasIdUser,
                'id_sub_kategori' => $idSubCategoryOnly,
                'isi_pengaduan' => $isi_pengaduan,
                'ket_pengaduan' => $ket_pengaduan
            ];

            if (isset($_FILES['daduk_aduan']) && $_FILES['daduk_aduan']['name'] != '') {
                $config['upload_path'] = './file/aduan_files/';
                $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                $config['max_size'] = 5120;
                $config['file_name'] = time() . '_' . $_FILES['daduk_aduan']['name'];

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('daduk_aduan')) {
                    $uploadData = $this->upload->data();
                    $updateData['bukti'] = 'file/aduan_files/' . $uploadData['file_name'];

                    $oldFile = $dataPengaduan->bukti ?? '';
                    if (!empty($oldFile) && file_exists(FCPATH . $oldFile)) {
                        unlink(FCPATH . $oldFile);
                    }
                } else {
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger">Upload file gagal: ' . $this->upload->display_errors() . '</div>');
                    redirect("laporaduan/v");
                }
            }

            $this->db->where('id_pengaduan', $id_pengaduan);
            $this->db->update('tbl_pengaduan', $updateData);

            $this->session->set_flashdata('msg', '<div class="alert alert-success">Data aduan berhasil diperbarui.</div>');
            redirect("laporaduan/v");
        }

        if (isset($_POST['btnupdate_aduan_bypetugas'])) {
            $id_pengaduan = $this->input->post('id_pengaduan');
            $dataPengaduan = $this->db->get_where('tbl_pengaduan', ['id_pengaduan' => $id_pengaduan])->row();
            if (empty($id_pengaduan)) {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger">ID pengaduan tidak ditemukan!</div>');
                redirect("laporaduan/v");
            }

            $mpd_area_id   = $this->input->post('mpd_area_id');
            $id_data_notaris = $this->input->post('id_data_notaris');
            $isi_pengaduan = $this->input->post('isi_pengaduan');
            $ket_pengaduan = $this->input->post('ket_pengaduan');

            $petugasIdUser = $this->db->get_where('tbl_petugas', ['id_petugas' => $mpd_area_id])->row()->id_user ?? "";

            $getNamaKategori = $this->db->get_where('tbl_data_notaris', ['id_data_notaris' => $id_data_notaris])->row()->nama ?? "";
            $namaUtama = trim(explode(',', $getNamaKategori)[0]);

            $this->db->like('nama_sub_kategori', $namaUtama, 'after');
            $getIdSubCategory = $this->db->get('tbl_sub_kategori', 1)->row();
            $idSubCategoryOnly = $getIdSubCategory->id_sub_kategori ?? "";

            $updateData = [
                'petugas'         => $petugasIdUser,
                'id_sub_kategori' => $idSubCategoryOnly,
                'isi_pengaduan'   => $isi_pengaduan,
                'ket_pengaduan'   => $ket_pengaduan
            ];

            $config = [
                'upload_path'   => './file/aduan_files/',
                'allowed_types' => 'jpg|jpeg|png|pdf',
                'max_size'      => 5120,
            ];

            if (isset($_FILES['daduk_aduan']) && $_FILES['daduk_aduan']['name'] != '') {
                $config['file_name'] = time() . '_' . $_FILES['daduk_aduan']['name'];
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('daduk_aduan')) {
                    $uploadData = $this->upload->data();
                    $updateData['bukti'] = 'file/aduan_files/' . $uploadData['file_name'];

                    $oldFile = $dataPengaduan->bukti ?? '';
                    if (!empty($oldFile) && strpos($oldFile, 'file/aduan_files/') === 0 && file_exists(FCPATH . $oldFile)) {
                        unlink(FCPATH . $oldFile);
                    }
                } else {
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger">Upload file bukti gagal: ' . $this->upload->display_errors() . '</div>');
                    redirect("laporaduan/v/ep/" . hashids_encrypt($id_pengaduan));
                }
            }

            $this->db->where('id_pengaduan', $id_pengaduan);
            $this->db->update('tbl_pengaduan', $updateData);

            $fileFields = [
                'surat_pemberitahuan'      => 'Surat Pemberitahuan',
                'surat_undangan'           => 'Surat Undangan',
                'surat_pemanggilan'        => 'Surat Pemanggilan',
                'undangan_ttd_bap'         => 'Undangan TTD BAP',
                'bap_pemeriksaan_has_ttd'  => 'BAP Pemeriksaan Has TTD',
                'surat_laporan_ke_mpw'     => 'Surat Laporan ke MPW',
                'surat_penolakan'          => 'Surat Penolakan'
            ];

            $this->load->library('upload', $config);
            foreach ($fileFields as $fieldName => $label) {
                if (isset($_FILES[$fieldName]) && $_FILES[$fieldName]['name'] != '') {
                    $config['file_name'] = time() . '_' . uniqid() . '_' . $_FILES[$fieldName]['name'];
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload($fieldName)) {
                        $uploadData = $this->upload->data();
                        $newFilePath = 'file/aduan_files/' . $uploadData['file_name'];

                        $existing = $this->db->get_where('tbl_aduan_hasfile', [
                            'pengaduan_id' => $id_pengaduan
                        ])->row();

                        $oldFile = '';
                        if ($existing && isset($existing->$fieldName)) {
                            $oldFile = $existing->$fieldName;
                        }

                        if (!empty($oldFile) && file_exists(FCPATH . $oldFile)) {
                            unlink(FCPATH . $oldFile);
                        }

                        if ($existing) {
                            $this->db->where('pengaduan_id', $id_pengaduan);
                            $this->db->update('tbl_aduan_hasfile', [
                                $fieldName => $newFilePath
                            ]);
                        } else {
                            $insertData = ['pengaduan_id' => $id_pengaduan];
                            foreach (array_keys($fileFields) as $ff) {
                                $insertData[$ff] = null;
                            }
                            $insertData[$fieldName] = $newFilePath;
                            $this->db->insert('tbl_aduan_hasfile', $insertData);
                        }
                    } else {
                        $this->session->set_flashdata('msg', '<div class="alert alert-danger">Upload ' . $label . ' gagal: ' . $this->upload->display_errors() . '</div>');
                        redirect("laporaduan/v/ep/" . hashids_encrypt($id_pengaduan));
                    }
                }
            }

            $this->session->set_flashdata('msg', '<div class="alert alert-success">Data aduan berhasil diperbarui.</div>');
            redirect("laporaduan/v");
        }
    }

    public function ajax()
    {
        if (isset($_POST['btnkirim'])) {
            $id = $this->input->post('id');
            $data = $this->db->get_where('tbl_laporan', array('id_laporan' => $id))->row();
            $pesan_petugas = $data->pesan_petugas;
            $status = $data->status;
            echo json_encode(array('pesan_petugas' => $pesan_petugas, 'status' => $status));
        } else {
            redirect('404');
        }
    }
}
