<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sekretariat_mkn extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Library & helper
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        $this->load->model('Mcrud');

        // Wajib login
        if (!$this->session->userdata('username')) {
            redirect('web/login');
        }

        // Hanya level tertentu yang boleh akses
        $level   = $this->session->userdata('level');
        $allowed = ['sek_mkn', 'sekretariat_mkn', 'superadmin'];
        if (!in_array($level, $allowed)) {
            redirect('web/login');
        }
    }

    /* ============================================================
     * DASHBOARD
     * ============================================================ */
    public function index()
    {
        $ceks = $this->session->userdata('username');

        $data['judul_web'] = 'Dashboard Sekretariat MKN - ' . $this->Mcrud->judul_web();
        $data['user']      = $this->Mcrud->get_users_by_un($ceks);

        // Inisialisasi KPI dengan 0
        $kpi = [
            'penyelidikan'       => 0,
            'penyidikan'         => 0,
            'penuntutan'         => 0,
            'sidang'             => 0,
            'terkirim'           => 0,
            'penolakan'          => 0,
            'terjadwal'          => 0,
            'catatan_hari_ini'   => 0,
        ];

        // PENYELIDIKAN
        $this->db->from('tbl_mkn_perkara');
        $this->db->where('status', 'proses');
        $this->db->where('tahapan', 'penyelidikan');
        $kpi['penyelidikan'] = $this->db->count_all_results();

        // PENYIDIKAN
        $this->db->from('tbl_mkn_perkara');
        $this->db->where('status', 'proses');
        $this->db->where('tahapan', 'penyidikan');
        $kpi['penyidikan'] = $this->db->count_all_results();

        // PENUNTUTAN
        $this->db->from('tbl_mkn_perkara');
        $this->db->where('status', 'proses');
        $this->db->where('tahapan', 'penuntutan');
        $kpi['penuntutan'] = $this->db->count_all_results();

        // SIDANG
        $this->db->from('tbl_mkn_perkara');
        $this->db->where('status', 'proses');
        $this->db->where('tahapan', 'sidang');
        $kpi['sidang'] = $this->db->count_all_results();

        // KPI: Perkara dengan catatan baru hari ini
        $this->db->from('tbl_mkn_perkara');
        $this->db->where('catatan IS NOT NULL AND catatan <> ""', null, false);
        $this->db->where('DATE(tgl_update) = CURDATE()', null, false);
        $kpi['catatan_hari_ini'] = $this->db->count_all_results();

        // (untuk sekarang, terkirim/penolakan/terjadwal tetap 0)
        $data['kpi'] = $kpi;

        $this->load->view('users/header', $data);
        $this->load->view('users/sekretariat_mkn', $data);
        $this->load->view('users/footer');
    }

    /* ============================================================
     * LIST PERKARA TAHAP PENYELIDIKAN
     * ============================================================ */
    public function penyelidikan()
    {
        $ceks = $this->session->userdata('username');

        $data['judul_web'] = 'Perkara Tahap Penyelidikan - ' . $this->Mcrud->judul_web();
        $data['user']      = $this->Mcrud->get_users_by_un($ceks);

        $this->db->from('tbl_mkn_perkara');
        $this->db->where('status', 'proses');
        $this->db->where('tahapan', 'penyelidikan');
        $this->db->order_by('tgl_pengajuan', 'DESC');
        $data['rows'] = $this->db->get()->result();

        $this->load->view('users/header', $data);
        $this->load->view('users/sekretariat_mkn_penyelidikan', $data);
        $this->load->view('users/footer');
    }

    /* ============================================================
     * LIST PERKARA TAHAP PENYIDIKAN
     * ============================================================ */
    public function penyidikan()
    {
        $ceks = $this->session->userdata('username');

        $data['judul_web'] = 'Perkara Tahap Penyidikan - ' . $this->Mcrud->judul_web();
        $data['user']      = $this->Mcrud->get_users_by_un($ceks);

        $this->db->from('tbl_mkn_perkara');
        $this->db->where('status', 'proses');
        $this->db->where('tahapan', 'penyidikan');
        $this->db->order_by('tgl_pengajuan', 'DESC');
        $data['rows'] = $this->db->get()->result();

        $this->load->view('users/header', $data);
        $this->load->view('users/sekretariat_mkn_penyidikan', $data);
        $this->load->view('users/footer');
    }

    /* ============================================================
     * LIST PERKARA TAHAP PENUNTUTAN
     * ============================================================ */
    public function penuntutan()
    {
        $ceks = $this->session->userdata('username');

        $data['judul_web'] = 'Perkara Tahap Penuntutan - ' . $this->Mcrud->judul_web();
        $data['user']      = $this->Mcrud->get_users_by_un($ceks);

        $this->db->from('tbl_mkn_perkara');
        $this->db->where('status', 'proses');
        $this->db->where('tahapan', 'penuntutan');
        $this->db->order_by('tgl_pengajuan', 'DESC');
        $data['rows'] = $this->db->get()->result();

        $this->load->view('users/header', $data);
        $this->load->view('users/sekretariat_mkn_penuntutan', $data);
        $this->load->view('users/footer');
    }

    public function sidang()
    {
        $ceks = $this->session->userdata('username');

        $data['judul_web'] = 'Perkara Tahap Sidang - ' . $this->Mcrud->judul_web();
        $data['user']      = $this->Mcrud->get_users_by_un($ceks);

        $this->db->from('tbl_mkn_perkara');
        $this->db->where('status', 'proses');
        $this->db->where('tahapan', 'sidang');
        $this->db->order_by('tgl_pengajuan', 'DESC');
        $data['rows'] = $this->db->get()->result();

        $this->load->view('users/header', $data);
        $this->load->view('users/sekretariat_mkn_sidang', $data);
        $this->load->view('users/footer');
    }

    /* ============================================================
     * DETAIL PERKARA + PANEL SURAT
     * ============================================================ */
    public function detail($id_perkara = null)
    {
        if ($id_perkara === null) {
            redirect('sekretariat_mkn');
        }

        $ceks = $this->session->userdata('username');

        $data['judul_web'] = 'Detail Perkara - ' . $this->Mcrud->judul_web();
        $data['user']      = $this->Mcrud->get_users_by_un($ceks);

        // Perkara
        $this->db->from('tbl_mkn_perkara');
        $this->db->where('id_perkara', $id_perkara);
        $row = $this->db->get()->row();
        if (!$row) {
            show_404();
        }
        $data['d'] = $row;

        // Surat terkait perkara ini
        $this->db->from('tbl_mkn_surat');
        $this->db->where('id_perkara', $id_perkara);
        $this->db->order_by('tgl_surat', 'DESC');
        $data['surat'] = $this->db->get()->result();

        $this->load->view('users/header', $data);
        $this->load->view('users/sekretariat_mkn_detail', $data);
        $this->load->view('users/footer');
    }

    /* ============================================================
     * AKSI: NAIK TAHAP
     * ============================================================ */
    public function naik_penyidikan($id_perkara = null)
    {
        if ($id_perkara === null) {
            redirect('sekretariat_mkn/penyelidikan');
        }

        $this->db->from('tbl_mkn_perkara');
        $this->db->where('id_perkara', $id_perkara);
        $this->db->where('status', 'proses');
        $this->db->where('tahapan', 'penyelidikan');
        $row = $this->db->get()->row();

        if (!$row) {
            $this->session->set_flashdata(
                'msg',
                '<div class="alert alert-danger">Perkara tidak ditemukan atau sudah naik tahap.</div>'
            );
            redirect('sekretariat_mkn/penyelidikan');
            return;
        }

        $data_update = [
            'tahapan'    => 'penyidikan',
            'status'     => 'proses',
            'tgl_update' => date('Y-m-d H:i:s'),
        ];

        $this->db->where('id_perkara', $id_perkara);
        $this->db->update('tbl_mkn_perkara', $data_update);

        $this->session->set_flashdata(
            'msg',
            '<div class="alert alert-success">Perkara berhasil dinaikkan ke tahap Penyidikan.</div>'
        );

        redirect('sekretariat_mkn/penyelidikan');
    }

    public function tolak_penyelidikan($id_perkara = null)
    {
        if ($id_perkara === null) {
            redirect('sekretariat_mkn/penyelidikan');
        }

        // Pastikan perkara ada, status masih proses, dan masih di tahap penyelidikan
        $this->db->from('tbl_mkn_perkara');
        $this->db->where('id_perkara', $id_perkara);
        $this->db->where('status', 'proses');
        $this->db->where('tahapan', 'penyelidikan');
        $row = $this->db->get()->row();

        if (!$row) {
            $this->session->set_flashdata(
                'msg',
                '<div class="alert alert-danger">
                Perkara tidak ditemukan atau sudah tidak dalam tahap Penyelidikan / tidak berstatus proses.
            </div>'
            );
            redirect('sekretariat_mkn/penyelidikan');
            return;
        }

        // Ubah status jadi ditolak, tahapan tetap penyelidikan
        $data_update = [
            'status'     => 'ditolak',
            'tgl_update' => date('Y-m-d H:i:s'),
        ];

        $this->db->where('id_perkara', $id_perkara);
        $this->db->update('tbl_mkn_perkara', $data_update);

        $this->session->set_flashdata(
            'msg',
            '<div class="alert alert-warning">
            Perkara telah ditandai sebagai <b>DITOLAK</b> pada tahap Penyelidikan.
        </div>'
        );

        redirect('sekretariat_mkn/penyelidikan');
    }


    public function naik_penuntutan($id_perkara = null)
    {
        if ($id_perkara === null) {
            redirect('sekretariat_mkn/penyidikan');
        }

        $this->db->from('tbl_mkn_perkara');
        $this->db->where('id_perkara', $id_perkara);
        $this->db->where('status', 'proses');
        $this->db->where('tahapan', 'penyidikan');
        $row = $this->db->get()->row();

        if (!$row) {
            $this->session->set_flashdata(
                'msg',
                '<div class="alert alert-danger">Perkara tidak ditemukan atau belum di tahap Penyidikan.</div>'
            );
            redirect('sekretariat_mkn/penyidikan');
            return;
        }

        $data_update = [
            'tahapan'    => 'penuntutan',
            'status'     => 'proses',
            'tgl_update' => date('Y-m-d H:i:s'),
        ];

        $this->db->where('id_perkara', $id_perkara);
        $this->db->update('tbl_mkn_perkara', $data_update);

        $this->session->set_flashdata(
            'msg',
            '<div class="alert alert-success">Perkara berhasil dinaikkan ke tahap Penuntutan.</div>'
        );

        redirect('sekretariat_mkn/penyidikan');
    }

    public function naik_sidang($id_perkara = null)
    {
        if ($id_perkara === null) {
            redirect('sekretariat_mkn/penuntutan');
        }

        $this->db->from('tbl_mkn_perkara');
        $this->db->where('id_perkara', $id_perkara);
        $this->db->where('status', 'proses');
        $this->db->where('tahapan', 'penuntutan');
        $row = $this->db->get()->row();

        if (!$row) {
            $this->session->set_flashdata(
                'msg',
                '<div class="alert alert-danger">Perkara tidak ditemukan atau belum di tahap Penuntutan.</div>'
            );
            redirect('sekretariat_mkn/penuntutan');
            return;
        }

        $data_update = [
            'tahapan'    => 'sidang',
            'status'     => 'proses',
            'tgl_update' => date('Y-m-d H:i:s'),
        ];

        $this->db->where('id_perkara', $id_perkara);
        $this->db->update('tbl_mkn_perkara', $data_update);

        $this->session->set_flashdata(
            'msg',
            '<div class="alert alert-success">Perkara berhasil dinaikkan ke tahap Sidang.</div>'
        );

        redirect('sekretariat_mkn/penuntutan');
    }

    /* ============================================================
     * FORM & SIMPAN SURAT (PENYIDIKAN / PENUNTUTAN / SIDANG)
     * ============================================================ */
    public function buat_surat($id_perkara = null)
    {
        if ($id_perkara === null) {
            redirect('sekretariat_mkn/penyidikan');
        }

        $ceks = $this->session->userdata('username');

        $data['judul_web'] = 'Buat Surat Pemanggilan - ' . $this->Mcrud->judul_web();
        $data['user']      = $this->Mcrud->get_users_by_un($ceks);

        $this->db->from('tbl_mkn_perkara');
        $this->db->where('id_perkara', $id_perkara);
        $this->db->where('tahapan', 'penyidikan');
        $perkara = $this->db->get()->row();

        if (!$perkara) {
            $this->session->set_flashdata(
                'msg',
                '<div class="alert alert-danger">Perkara tidak ditemukan atau belum di tahap Penyidikan.</div>'
            );
            redirect('sekretariat_mkn/penyidikan');
            return;
        }

        $data['perkara'] = $perkara;

        $this->load->view('users/header', $data);
        $this->load->view('users/sekretariat_mkn_buat_surat', $data);
        $this->load->view('users/footer');
    }

    public function simpan_surat()
    {
        if ($this->input->method() !== 'post') {
            redirect('sekretariat_mkn/penyidikan');
        }

        $id_perkara  = (int)$this->input->post('id_perkara');
        $no_surat    = $this->input->post('no_surat', true);
        $perihal     = $this->input->post('perihal', true);
        $tujuan_role = $this->input->post('ditujukan_ke_role', true) ?: 'notaris';

        if (!$id_perkara || !$no_surat) {
            $this->session->set_flashdata(
                'msg',
                '<div class="alert alert-warning">ID perkara dan nomor surat wajib diisi.</div>'
            );
            redirect('sekretariat_mkn/penyidikan');
        }

        $this->db->from('tbl_mkn_perkara');
        $this->db->where('id_perkara', $id_perkara);
        $this->db->where('tahapan', 'penyidikan');
        $perkara = $this->db->get()->row();

        if (!$perkara) {
            $this->session->set_flashdata(
                'msg',
                '<div class="alert alert-danger">Perkara tidak ditemukan atau belum di tahap Penyidikan.</div>'
            );
            redirect('sekretariat_mkn/penyidikan');
            return;
        }

        // Upload lampiran (opsional)
        $lampiran_path = null;
        if (!empty($_FILES['lampiran']['name'])) {
            $baseDir = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'mkn_surat';
            if (!is_dir($baseDir)) {
                @mkdir($baseDir, 0777, true);
            }
            $absPath = realpath($baseDir);
            if ($absPath === false) {
                $absPath = rtrim($baseDir, "\\/");
            }
            $absPath = str_replace('\\', '/', $absPath);
            $absPath = rtrim($absPath, '/') . '/';

            $config = [
                'upload_path'   => $absPath,
                'allowed_types' => 'pdf|jpg|jpeg|png',
                'max_size'      => 4096,
                'encrypt_name'  => TRUE,
            ];
            $this->load->library('upload');
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('lampiran')) {
                $this->session->set_flashdata(
                    'msg',
                    '<div class="alert alert-danger"><b>Upload gagal:</b> ' . $this->upload->display_errors('', '') . '</div>'
                );
                redirect('sekretariat_mkn/buat_surat/' . $id_perkara);
                return;
            }

            $upData        = $this->upload->data();
            $lampiran_path = 'uploads/mkn_surat/' . $upData['file_name'];
        }

        $insert = [
            'id_perkara'        => $id_perkara,
            'jenis_surat'       => 'pemanggilan_pemeriksaan',
            'no_surat'          => $no_surat,
            'perihal'           => $perihal,
            'lampiran_path'     => $lampiran_path,
            'ditujukan_ke_role' => $tujuan_role, // notaris / aph / mpd
            'ditujukan_ke_id'   => null,
            'status_bawa'       => 'belum_dibawa',
            'tgl_surat'         => date('Y-m-d H:i:s'),
            'tgl_update'        => date('Y-m-d H:i:s'),
        ];

        $this->db->insert('tbl_mkn_surat', $insert);

        $this->session->set_flashdata(
            'msg',
            '<div class="alert alert-success">Surat pemanggilan berhasil dibuat.</div>'
        );

        redirect('sekretariat_mkn/penyidikan');
    }

    public function buat_surat_jawaban($id_perkara = null)
    {
        if ($id_perkara === null) {
            redirect('sekretariat_mkn/penuntutan');
        }

        $ceks = $this->session->userdata('username');

        $data['judul_web'] = 'Surat Jawaban Ketua ke APH - ' . $this->Mcrud->judul_web();
        $data['user']      = $this->Mcrud->get_users_by_un($ceks);

        $this->db->from('tbl_mkn_perkara');
        $this->db->where('id_perkara', $id_perkara);
        $this->db->where('tahapan', 'penuntutan');
        $perkara = $this->db->get()->row();

        if (!$perkara) {
            $this->session->set_flashdata(
                'msg',
                '<div class="alert alert-danger">Perkara tidak ditemukan atau belum di tahap Penuntutan.</div>'
            );
            redirect('sekretariat_mkn/penuntutan');
            return;
        }

        $data['perkara'] = $perkara;

        $this->load->view('users/header', $data);
        $this->load->view('users/sekretariat_mkn_buat_surat_jawaban', $data);
        $this->load->view('users/footer');
    }

    public function simpan_surat_jawaban()
    {
        if ($this->input->method() !== 'post') {
            redirect('sekretariat_mkn/penuntutan');
        }

        $id_perkara  = (int)$this->input->post('id_perkara');
        $no_surat    = $this->input->post('no_surat', true);
        $perihal     = $this->input->post('perihal', true);

        if (!$id_perkara || !$no_surat) {
            $this->session->set_flashdata(
                'msg',
                '<div class="alert alert-warning">ID perkara dan nomor surat wajib diisi.</div>'
            );
            redirect('sekretariat_mkn/penuntutan');
        }

        $this->db->from('tbl_mkn_perkara');
        $this->db->where('id_perkara', $id_perkara);
        $this->db->where('tahapan', 'penuntutan');
        $perkara = $this->db->get()->row();

        if (!$perkara) {
            $this->session->set_flashdata(
                'msg',
                '<div class="alert alert-danger">Perkara tidak ditemukan atau belum di tahap Penuntutan.</div>'
            );
            redirect('sekretariat_mkn/penuntutan');
            return;
        }

        // Upload lampiran (opsional)
        $lampiran_path = null;
        if (!empty($_FILES['lampiran']['name'])) {
            $baseDir = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'mkn_surat';
            if (!is_dir($baseDir)) {
                @mkdir($baseDir, 0777, true);
            }
            $absPath = realpath($baseDir);
            if ($absPath === false) {
                $absPath = rtrim($baseDir, "\\/");
            }
            $absPath = str_replace('\\', '/', $absPath);
            $absPath = rtrim($absPath, '/') . '/';

            $config = [
                'upload_path'   => $absPath,
                'allowed_types' => 'pdf|jpg|jpeg|png',
                'max_size'      => 4096,
                'encrypt_name'  => TRUE,
            ];
            $this->load->library('upload');
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('lampiran')) {
                $this->session->set_flashdata(
                    'msg',
                    '<div class="alert alert-danger"><b>Upload gagal:</b> ' . $this->upload->display_errors('', '') . '</div>'
                );
                redirect('sekretariat_mkn/buat_surat_jawaban/' . $id_perkara);
                return;
            }

            $upData        = $this->upload->data();
            $lampiran_path = 'uploads/mkn_surat/' . $upData['file_name'];
        }

        $insert = [
            'id_perkara'        => $id_perkara,
            'jenis_surat'       => 'jawaban_ketua_ke_aph',
            'no_surat'          => $no_surat,
            'perihal'           => $perihal,
            'lampiran_path'     => $lampiran_path,
            'ditujukan_ke_role' => 'aph',
            'ditujukan_ke_id'   => null,
            'status_bawa'       => 'belum_dibawa',
            'tgl_surat'         => date('Y-m-d H:i:s'),
            'tgl_update'        => date('Y-m-d H:i:s'),
        ];

        $this->db->insert('tbl_mkn_surat', $insert);

        $this->session->set_flashdata(
            'msg',
            '<div class="alert alert-success">Surat jawaban Ketua ke APH berhasil dibuat.</div>'
        );

        redirect('sekretariat_mkn/penuntutan');
    }

    public function buat_putusan($id_perkara = null)
    {
        if ($id_perkara === null) {
            redirect('sekretariat_mkn/sidang');
        }

        $ceks = $this->session->userdata('username');

        $data['judul_web'] = 'Putusan Hasil Pemeriksaan - ' . $this->Mcrud->judul_web();
        $data['user']      = $this->Mcrud->get_users_by_un($ceks);

        $this->db->from('tbl_mkn_perkara');
        $this->db->where('id_perkara', $id_perkara);
        $this->db->where('tahapan', 'sidang');
        $perkara = $this->db->get()->row();

        if (!$perkara) {
            $this->session->set_flashdata(
                'msg',
                '<div class="alert alert-danger">Perkara tidak ditemukan atau belum di tahap Sidang.</div>'
            );
            redirect('sekretariat_mkn/sidang');
            return;
        }

        $data['perkara'] = $perkara;

        $this->load->view('users/header', $data);
        $this->load->view('users/sekretariat_mkn_buat_putusan', $data);
        $this->load->view('users/footer');
    }

    public function simpan_putusan()
    {
        if ($this->input->method() !== 'post') {
            redirect('sekretariat_mkn/sidang');
        }

        $id_perkara  = (int)$this->input->post('id_perkara');
        $no_surat    = $this->input->post('no_surat', true);
        $perihal     = $this->input->post('perihal', true);

        if (!$id_perkara || !$no_surat) {
            $this->session->set_flashdata(
                'msg',
                '<div class="alert alert-warning">ID perkara dan nomor surat wajib diisi.</div>'
            );
            redirect('sekretariat_mkn/sidang');
        }

        $this->db->from('tbl_mkn_perkara');
        $this->db->where('id_perkara', $id_perkara);
        $this->db->where('tahapan', 'sidang');
        $perkara = $this->db->get()->row();

        if (!$perkara) {
            $this->session->set_flashdata(
                'msg',
                '<div class="alert alert-danger">Perkara tidak ditemukan atau belum di tahap Sidang.</div>'
            );
            redirect('sekretariat_mkn/sidang');
            return;
        }

        // Upload lampiran (opsional)
        $lampiran_path = null;
        if (!empty($_FILES['lampiran']['name'])) {
            $baseDir = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'mkn_surat';
            if (!is_dir($baseDir)) {
                @mkdir($baseDir, 0777, true);
            }
            $absPath = realpath($baseDir);
            if ($absPath === false) {
                $absPath = rtrim($baseDir, "\\/");
            }
            $absPath = str_replace('\\', '/', $absPath);
            $absPath = rtrim($absPath, '/') . '/';

            $config = [
                'upload_path'   => $absPath,
                'allowed_types' => 'pdf|jpg|jpeg|png',
                'max_size'      => 4096,
                'encrypt_name'  => TRUE,
            ];
            $this->load->library('upload');
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('lampiran')) {
                $this->session->set_flashdata(
                    'msg',
                    '<div class="alert alert-danger"><b>Upload gagal:</b> ' . $this->upload->display_errors('', '') . '</div>'
                );
                redirect('sekretariat_mkn/buat_putusan/' . $id_perkara);
                return;
            }

            $upData        = $this->upload->data();
            $lampiran_path = 'uploads/mkn_surat/' . $upData['file_name'];
        }

        $insert = [
            'id_perkara'        => $id_perkara,
            'jenis_surat'       => 'putusan_hasil_pemeriksaan',
            'no_surat'          => $no_surat,
            'perihal'           => $perihal,
            'lampiran_path'     => $lampiran_path,
            'ditujukan_ke_role' => 'mpd', // boleh diganti
            'ditujukan_ke_id'   => null,
            'status_bawa'       => 'belum_dibawa',
            'tgl_surat'         => date('Y-m-d H:i:s'),
            'tgl_update'        => date('Y-m-d H:i:s'),
        ];

        $this->db->insert('tbl_mkn_surat', $insert);

        // Tandai perkara selesai
        $this->db->where('id_perkara', $id_perkara);
        $this->db->update('tbl_mkn_perkara', [
            'status'     => 'selesai',
            'tgl_update' => date('Y-m-d H:i:s'),
        ]);

        $this->session->set_flashdata(
            'msg',
            '<div class="alert alert-success">Putusan hasil pemeriksaan berhasil dibuat. Perkara ditandai selesai.</div>'
        );

        redirect('sekretariat_mkn/sidang');
    }

    /* ============================================================
     * CATATAN PERKARA
     * ============================================================ */
    public function simpan_catatan($id_perkara = null)
    {
        if (!$this->session->userdata('username')) {
            redirect('web/login');
        }

        if ($id_perkara === null) {
            redirect('sekretariat_mkn');
        }

        if ($this->input->method() !== 'post') {
            redirect('sekretariat_mkn/detail/' . $id_perkara);
        }

        $id_user       = $this->session->userdata('id_user');
        $catatan_baru  = trim($this->input->post('catatan', TRUE));

        if ($catatan_baru === '') {
            $this->session->set_flashdata('msg', '<div class="alert alert-warning">Catatan masih kosong.</div>');
            redirect('sekretariat_mkn/detail/' . $id_perkara);
        }

        // Ambil data perkara
        $this->db->from('tbl_mkn_perkara');
        $this->db->where('id_perkara', $id_perkara);
        $row = $this->db->get()->row();

        if (!$row) {
            $this->session->set_flashdata('msg', '<div class="alert alert-warning">Perkara tidak ditemukan.</div>');
            redirect('sekretariat_mkn');
        }

        // Susun catatan dengan timestamp & user
        $prefix = '[' . date('d/m/Y H:i') . ' oleh Sekretariat#' . $id_user . '] ';
        $gabung = $prefix . $catatan_baru;

        if (!empty($row->catatan)) {
            $gabung = $row->catatan . "\n\n" . $gabung;
        }

        $this->db->where('id_perkara', $id_perkara);
        $ok = $this->db->update('tbl_mkn_perkara', [
            'catatan'    => $gabung,
            'tgl_update' => date('Y-m-d H:i:s'),
        ]);

        $this->session->set_flashdata(
            'msg',
            $ok
                ? '<div class="alert alert-success">Catatan pemeriksaan tersimpan.</div>'
                : '<div class="alert alert-danger">Gagal menyimpan catatan pemeriksaan.</div>'
        );

        redirect('sekretariat_mkn/detail/' . $id_perkara);
    }

    public function catatan_hari_ini()
    {
        if (!$this->session->userdata('username')) {
            redirect('web/login');
        }

        $ceks = $this->session->userdata('username');

        $data['judul_web'] = 'Perkara dengan Catatan Baru Hari Ini - ' . $this->Mcrud->judul_web();
        $data['user']      = $this->Mcrud->get_users_by_un($ceks);

        // Ambil perkara yang catatannya diupdate hari ini
        $this->db->from('tbl_mkn_perkara');
        $this->db->where('catatan IS NOT NULL AND catatan <> ""', null, false);
        $this->db->where('DATE(tgl_update) = CURDATE()', null, false);
        $this->db->order_by('tgl_update', 'DESC');
        $data['rows'] = $this->db->get()->result();

        $this->load->view('users/header', $data);
        $this->load->view('users/sekretariat_mkn_catatan_hari_ini', $data);
        $this->load->view('users/footer');
    }

    /* ============================================================
     * KELOLA AKUN APH
     * ============================================================ */
    public function kelola_aph()
    {
        // Pastikan yang boleh akses hanya Sekretariat / Superadmin
        if (!$this->session->userdata('username')) {
            redirect('web/login');
        }

        $level  = $this->session->userdata('level');
        $allowed = ['sekretariat_mkn', 'sek_mkn', 'superadmin'];
        if (!in_array($level, $allowed)) {
            redirect('web/login');
        }

        $ceks = $this->session->userdata('username');

        $data['judul_web'] = 'Kelola Akun APH - ' . $this->Mcrud->judul_web();
        $data['user']      = $this->Mcrud->get_users_by_un($ceks);

        // ========= HANDLE FORM SIMPAN AKUN BARU =========
        if ($this->input->post('btnsimpan')) {
            $nama_lengkap = trim($this->input->post('nama_lengkap', TRUE));
            $username     = trim($this->input->post('username', TRUE));
            $pass         = trim($this->input->post('password', TRUE));
            $pass2        = trim($this->input->post('password2', TRUE));
            $level_aph    = $this->input->post('level_aph', TRUE); // aph / aph_polri

            $err = '';

            if ($nama_lengkap === '' || $username === '' || $pass === '' || $pass2 === '') {
                $err = 'Semua field bertanda * wajib diisi.';
            } elseif ($pass !== $pass2) {
                $err = 'Konfirmasi password tidak sama.';
            } elseif (!in_array($level_aph, ['aph', 'aph_polri'])) {
                $err = 'Level APH tidak valid.';
            } else {
                // Cek username sudah dipakai atau belum
                $cek_un = $this->db->get_where('tbl_user', ['username' => $username, 'dihapus' => 'tidak']);
                if ($cek_un->num_rows() > 0) {
                    $err = 'Username sudah digunakan.';
                }
            }

            if ($err !== '') {
                $this->session->set_flashdata(
                    'msg',
                    '<div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>'
                        . $err .
                        '</div>'
                );
                redirect('sekretariat_mkn/kelola_aph');
            }

            // Kalau lolos validasi, simpan ke tbl_user
            date_default_timezone_set('Asia/Jakarta');
            $tgl = date('Y-m-d H:i:s');

            $data_insert = [
                'nama_lengkap' => htmlentities(strip_tags($nama_lengkap)),
                'username'     => htmlentities(strip_tags($username)),
                // mengikuti pola lama: password disimpan apa adanya (login cek plaintext / md5)
                'password'     => $pass,
                'level'        => $level_aph, // aph atau aph_polri
                'tgl_daftar'   => $tgl,
                'aktif'        => '1',
                'dihapus'      => 'tidak',
            ];

            $this->db->insert('tbl_user', $data_insert);

            $this->session->set_flashdata(
                'msg',
                '<div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    Akun APH berhasil dibuat.
                </div>'
            );
            redirect('sekretariat_mkn/kelola_aph');
        }

        // ========= LIST AKUN APH YANG SUDAH ADA =========
        $this->db->from('tbl_user');
        $this->db->where_in('level', ['aph', 'aph_polri']);
        $this->db->where('dihapus', 'tidak');
        $this->db->order_by('tgl_daftar', 'DESC');
        $data['rows'] = $this->db->get()->result();

        $this->load->view('users/header', $data);
        $this->load->view('users/sekretariat_mkn_aph', $data);
        $this->load->view('users/footer');
    }

    public function toggle_aph($id_user = null)
    {
        if (!$this->session->userdata('username')) {
            redirect('web/login');
        }

        if (!$id_user) {
            redirect('sekretariat_mkn/kelola_aph');
        }

        // Ambil user APH (boleh aph / aph_polri)
        $user = $this->db->get_where('tbl_user', [
            'id_user' => $id_user
        ])->row();

        if (!$user || !in_array($user->level, ['aph', 'aph_polri'])) {
            $this->session->set_flashdata(
                'msg',
                '<div class="alert alert-danger">User APH tidak ditemukan.</div>'
            );
            redirect('sekretariat_mkn/kelola_aph');
        }

        // Kolom aktif: 1 = aktif, 0 = nonaktif
        $newStatus = ($user->aktif == 1) ? 0 : 1;

        $this->db->where('id_user', $id_user)
            ->update('tbl_user', ['aktif' => $newStatus]);

        $text = ($newStatus == 1) ? 'diaktifkan' : 'dinonaktifkan';

        $this->session->set_flashdata(
            'msg',
            '<div class="alert alert-success">Akun APH berhasil ' . $text . '.</div>'
        );

        redirect('sekretariat_mkn/kelola_aph');
    }

    public function reset_password_aph($id_user = null)
    {
        if (!$this->session->userdata('username')) {
            redirect('web/login');
        }

        if (!$id_user) {
            redirect('sekretariat_mkn/kelola_aph');
        }

        $user = $this->db->get_where('tbl_user', [
            'id_user' => $id_user
        ])->row();

        if (!$user || !in_array($user->level, ['aph', 'aph_polri'])) {
            $this->session->set_flashdata(
                'msg',
                '<div class="alert alert-danger">User APH tidak ditemukan.</div>'
            );
            redirect('sekretariat_mkn/kelola_aph');
        }

        // Password baru (silakan ganti kalau mau pola lain)
        $newPass = 'APH12345';

        // Ikuti pola lama: simpan apa adanya
        $this->db->where('id_user', $id_user)
            ->update('tbl_user', ['password' => $newPass]);

        $this->session->set_flashdata(
            'msg',
            '<div class="alert alert-success">
                Password akun <b>' . htmlspecialchars($user->username) . '</b> berhasil direset.<br>
                Password baru: <b>' . $newPass . '</b>
            </div>'
        );

        redirect('sekretariat_mkn/kelola_aph');
    }
}
