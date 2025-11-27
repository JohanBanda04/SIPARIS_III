<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aph extends CI_Controller {
    public function index()
{
    if (!$this->session->userdata('username')) {
        redirect('web/login');
    }

    $ceks    = $this->session->userdata('username');
    $id_user = $this->session->userdata('id_user');

    $data['judul_web'] = 'Dashboard APH - ' . $this->Mcrud->judul_web();
    $data['user']      = $this->Mcrud->get_users_by_un($ceks);

    // --- KPI: hitung per status ---
    $kpi = [];

    // Draft = status pending
    $this->db->from('tbl_mkn_perkara');
    $this->db->where('id_user_pengaju', $id_user);
    $this->db->where('status', 'pending');
    $kpi['draft'] = $this->db->count_all_results();

    // Dikirim / Belum Ditanggapi = proses & tahapan penyelidikan
    $this->db->from('tbl_mkn_perkara');
    $this->db->where('id_user_pengaju', $id_user);
    $this->db->where('status', 'proses');
    $this->db->where('tahapan', 'penyelidikan');
    $kpi['dikirim'] = $this->db->count_all_results();

    // Diproses = proses & tahapan > penyelidikan (penyidikan/penuntutan/sidang)
    $this->db->from('tbl_mkn_perkara');
    $this->db->where('id_user_pengaju', $id_user);
    $this->db->where('status', 'proses');
    $this->db->where_in('tahapan', ['penyidikan', 'penuntutan', 'sidang']);
    $kpi['diproses'] = $this->db->count_all_results();

    // Selesai
    $this->db->from('tbl_mkn_perkara');
    $this->db->where('id_user_pengaju', $id_user);
    $this->db->where('status', 'selesai');
    $kpi['selesai'] = $this->db->count_all_results();

    $data['kpi'] = $kpi;

    $this->load->view('users/header', $data);
    $this->load->view('users/aph', $data);
    $this->load->view('users/footer');
}
    public function create()
{
    // biar URL aph/create sama saja dengan aph/form_pengajuan
    $this->form_pengajuan();
}
public function __construct()
{
    parent::__construct();

    // WAJIB: session harus ada
    $this->load->library('session');

    // WAJIB: model digunakan di semua fungsi
    $this->load->model('Mcrud');
    $this->load->model('Mkn_model');

    // Cek login
    if (!$this->session->userdata('username')) {
        redirect('web/login');
    }

    // Cek role APH
    $level = $this->session->userdata('level');
    $allowed = ['aph', 'aph_polri', 'superadmin'];
    if (!in_array($level, $allowed)) {
        redirect('web/login');
    }
}

    public function form_pengajuan() {
        $ceks = $this->session->userdata('username');
    
        $data['judul_web'] = 'Form Pengajuan Perkara - ' . $this->Mcrud->judul_web();
        $data['user']      = $this->Mcrud->get_users_by_un($ceks); // untuk header.php
    
        // ambil daftar notaris untuk auto-suggest
        $this->db->select('id_data_notaris, nama, alamat_notaris, tempat_kedudukan');
        $this->db->from('tbl_data_notaris');
        $this->db->order_by('nama', 'ASC');
        $data['list_notaris'] = $this->db->get()->result();
    
        $this->load->view('users/header', $data);
        $this->load->view('aph/form_pengajuan', $data);
        $this->load->view('users/footer');
    }
    public function update_pengajuan($id_perkara = null)
{
    if (!$this->session->userdata('username')) {
        redirect('web/login');
    }
    if ($id_perkara == null) {
        redirect('aph/permohonan?status=draft');
    }

    $id_user = $this->session->userdata('id_user');

    // pastikan masih pending & milik user ini
    $this->db->from('tbl_mkn_perkara');
    $this->db->where('id_perkara', $id_perkara);
    $this->db->where('id_user_pengaju', $id_user);
    $this->db->where('status', 'pending');
    $row = $this->db->get()->row();

    if (!$row) {
        $this->session->set_flashdata('msg',
            '<div class="alert alert-danger">Data tidak bisa diubah.</div>'
        );
        redirect('aph/permohonan?status=draft');
        return;
    }

    $nama_notaris   = $this->input->post('nama_notaris', TRUE);
    $alamat_notaris = $this->input->post('alamat_notaris', TRUE);
    $kronologi      = $this->input->post('kronologi', TRUE);
    $nomor_akta     = $this->input->post('nomor_akta', TRUE);

    $data_update = [
        'nama_notaris'   => $nama_notaris,
        'alamat_notaris' => $alamat_notaris,
        'kronologi'      => $kronologi,
        'nomor_akta'     => $nomor_akta,
        'tgl_update'     => date('Y-m-d H:i:s'),
    ];

    $this->db->where('id_perkara', $id_perkara);
    $this->db->update('tbl_mkn_perkara', $data_update);

    $this->session->set_flashdata('msg',
        '<div class="alert alert-success">Pengajuan berhasil diperbarui.</div>'
    );

    redirect('aph/permohonan?status=draft');
}

    public function simpan_pengajuan()
    {
        // wajib login & role
        if (!$this->session->userdata('username') || $this->session->userdata('level') !== 'aph') {
            redirect('web/login');
        }

        /** =========================
         *  SETUP UPLOAD YANG AMAN
         *  ========================= */
        // Pastikan folder ada
        $baseDir = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'mkn';
        if (!is_dir($baseDir)) {
            @mkdir($baseDir, 0777, true);
        }

        // Normalisasi path absolut & trailing slash (penting di Windows)
        $absPath = realpath($baseDir);                 // contoh: C:\xampp74\htdocs\SIPRANCIS\uploads\mkn
        if ($absPath === false) {                      // jika realpath gagal (folder baru dibuat)
            $absPath = rtrim($baseDir, "\\/");
        }
        $absPath = str_replace('\\', '/', $absPath);   // gunakan forward slash
        $absPath = rtrim($absPath, '/') . '/';         // wajib akhiri dengan '/'

        // Konfigurasi upload
        $config = [
            'upload_path'   => $absPath,               // path absolut ke folder
            'allowed_types' => 'pdf|jpg|jpeg|png',
            'max_size'      => 4096,                   // KB
            'encrypt_name'  => TRUE,
        ];

        $this->load->library('upload');
        $this->upload->initialize($config);

        // Proses upload (opsional)
        $file_name = null;
        if (!empty($_FILES['lampiran']['name'])) {
            if (!$this->upload->do_upload('lampiran')) {
                $this->session->set_flashdata('msg',
                    '<div class="alert alert-danger"><b>Upload gagal.</b><br>'
                    . $this->upload->display_errors('', '') . '<br>'
                    . 'Path yang dipakai: <code>' . html_escape($absPath) . '</code></div>'
                );
                redirect('aph/pengajuan');
            }
            // simpan path relatif untuk dipakai di view (base_url)
            $file_name = 'uploads/mkn/' . $this->upload->data('file_name');
        }

        // Validasi minimal
        $nama_notaris   = $this->input->post('nama_notaris', true);
        $alamat_notaris = $this->input->post('alamat_notaris', true);
        $kronologi      = $this->input->post('kronologi', true);
        $nomor_akta     = $this->input->post('nomor_akta', true);

        if (!$nama_notaris || !$alamat_notaris || !$kronologi) {
            // hapus file kalau sempat ter-upload
            if ($file_name && file_exists(FCPATH.$file_name)) @unlink(FCPATH.$file_name);
            $this->session->set_flashdata('msg',
                '<div class="alert alert-warning">Form belum lengkap.</div>'
            );
            redirect('aph/pengajuan');
        }

        // Simpan ke DB
        $data_insert = [
            'id_user_pengaju' => $this->session->userdata('id_user'),
            'nama_notaris'    => $nama_notaris,
            'alamat_notaris'  => $alamat_notaris,
            'kronologi'       => $kronologi,
            'nomor_akta'      => $nomor_akta,
            'lampiran_surat'  => $file_name,
            'tahapan'         => 'penyelidikan',
            'status'          => 'pending',
            'tgl_pengajuan'   => date('Y-m-d H:i:s'),
        ];

        $this->Mkn_model->insertPerkara($data_insert);

        $this->session->set_flashdata('msg',
            '<div class="alert alert-success">Pengajuan berhasil disimpan.</div>'
        );
        redirect('aph/pengajuan');
    }
    public function permohonan()
{
    if (!$this->session->userdata('username')) {
        redirect('web/login');
    }

    $level = $this->session->userdata('level');
    if (!in_array($level, ['aph', 'aph_polri', 'superadmin'])) {
        redirect('web/login');
    }

    $ceks    = $this->session->userdata('username');
    $id_user = $this->session->userdata('id_user');

    $status = $this->input->get('status', TRUE); // draft/dikirim/diproses/selesai

    $data['judul_web'] = 'Daftar Permohonan APH - ' . $this->Mcrud->judul_web();
    $data['user']      = $this->Mcrud->get_users_by_un($ceks);

    // mapping status URL -> kondisi DB
    $status_map = [
        'draft' => [
            'status' => 'pending',
        ],
        'dikirim' => [
            'status'  => 'proses',
            'tahapan' => 'penyelidikan',
        ],
        'diproses' => [
            'status' => 'proses',
            // tahapan lain bisa difilter nanti kalau mau
        ],
        'selesai' => [
            'status' => 'selesai',
        ],
    ];

    $this->db->from('tbl_mkn_perkara');
    $this->db->where('id_user_pengaju', $id_user);

    if ($status && isset($status_map[$status])) {
        foreach ($status_map[$status] as $field => $value) {
            if (is_array($value)) {
                $this->db->where_in($field, $value);
            } else {
                $this->db->where($field, $value);
            }
        }
    }

    $this->db->order_by('tgl_pengajuan', 'DESC');
    $data['rows']          = $this->db->get()->result();
    $data['status_filter'] = $status;

    $this->load->view('users/header', $data);
    $this->load->view('users/aph_permohonan', $data);
    $this->load->view('users/footer');
}
public function detail($id_perkara = null)
{
    if (!$this->session->userdata('username')) {
        redirect('web/login');
    }

    if ($id_perkara == null) {
        redirect('aph/permohonan');
    }

    $ceks    = $this->session->userdata('username');
    $id_user = $this->session->userdata('id_user');

    $data['judul_web'] = 'Detail Permohonan - ' . $this->Mcrud->judul_web();
    $data['user']      = $this->Mcrud->get_users_by_un($ceks);

    // Ambil data perkara (pastikan milik APH yang login)
    $this->db->from('tbl_mkn_perkara');
    $this->db->where('id_perkara', $id_perkara);
    $this->db->where('id_user_pengaju', $id_user); // APH lain tidak boleh lihat
    $row = $this->db->get()->row();

    if (!$row) {
        show_404();
    }

    $data['d'] = $row;

    // ---- Surat Jawaban Ketua ke APH (tahap penuntutan) ----
    $this->db->from('tbl_mkn_surat');
    $this->db->where('id_perkara', $id_perkara);
    $this->db->where('jenis_surat', 'jawaban_ketua_ke_aph');
    $this->db->order_by('tgl_surat', 'DESC');
    $data['surat_jawaban'] = $this->db->get()->row();

    // ---- Putusan Hasil Pemeriksaan (tahap sidang) ----
    $this->db->from('tbl_mkn_surat');
    $this->db->where('id_perkara', $id_perkara);
    $this->db->where('jenis_surat', 'putusan_hasil_pemeriksaan');
    $this->db->order_by('tgl_surat', 'DESC');
    $data['putusan'] = $this->db->get()->row();

    $this->load->view('users/header', $data);
    $this->load->view('users/aph_detail', $data);
    $this->load->view('users/footer');
}
 public function kirim_ke_sekretariat($id_perkara = null)
{
    if (!$this->session->userdata('username')) {
        redirect('web/login');
    }
    if ($id_perkara == null) {
        redirect('aph/permohonan?status=draft');
    }

    $id_user = $this->session->userdata('id_user');

    // Pastikan data milik APH ini dan masih draft (pending)
    $this->db->from('tbl_mkn_perkara');
    $this->db->where('id_perkara', $id_perkara);
    $this->db->where('id_user_pengaju', $id_user);
    $this->db->where('status', 'pending');
    $row = $this->db->get()->row();

    if (!$row) {
        $this->session->set_flashdata('msg',
            '<div class="alert alert-danger">Data tidak ditemukan atau sudah diproses.</div>'
        );
        redirect('aph/permohonan?status=draft');
        return;
    }

    $data_update = [
        'status'      => 'proses',          // berubah jadi dikirim/proses
        'tahapan'     => 'penyelidikan',    // pastikan di tahap awal
        'tgl_update'  => date('Y-m-d H:i:s')
    ];

    $this->db->where('id_perkara', $id_perkara);
    $this->db->update('tbl_mkn_perkara', $data_update);

    $this->session->set_flashdata('msg',
        '<div class="alert alert-success">Permohonan berhasil dikirim ke Sekretariat MKN.</div>'
    );

    redirect('aph/permohonan?status=dikirim');
}
public function edit($id_perkara = null)
{
    if (!$this->session->userdata('username')) {
        redirect('web/login');
    }
    if ($id_perkara == null) {
        redirect('aph/permohonan?status=draft');
    }

    $ceks    = $this->session->userdata('username');
    $id_user = $this->session->userdata('id_user');

    $data['judul_web'] = 'Edit Pengajuan Perkara - ' . $this->Mcrud->judul_web();
    $data['user']      = $this->Mcrud->get_users_by_un($ceks);

    // ambil data perkara yang masih pending
    $this->db->from('tbl_mkn_perkara');
    $this->db->where('id_perkara', $id_perkara);
    $this->db->where('id_user_pengaju', $id_user);
    $this->db->where('status', 'pending');
    $row = $this->db->get()->row();

    if (!$row) {
        $this->session->set_flashdata('msg',
            '<div class="alert alert-danger">Data tidak ditemukan atau tidak bisa diedit.</div>'
        );
        redirect('aph/permohonan?status=draft');
        return;
    }

    // daftar notaris (buat select2)
    $this->db->select('id_data_notaris, nama, alamat_notaris, tempat_kedudukan');
    $this->db->from('tbl_data_notaris');
    $this->db->order_by('nama', 'ASC');
    $data['list_notaris'] = $this->db->get()->result();

    $data['d']    = $row;
    $data['mode'] = 'edit';

    $this->load->view('users/header', $data);
    $this->load->view('aph/form_pengajuan', $data); // pakai view yang sama
    $this->load->view('users/footer');
}
public function hapus($id_perkara = null)
{
    if (!$this->session->userdata('username')) {
        redirect('web/login');
    }
    if ($id_perkara == null) {
        redirect('aph/permohonan?status=draft');
    }

    $id_user = $this->session->userdata('id_user');

    // hanya boleh hapus yang pending & milik sendiri
    $this->db->from('tbl_mkn_perkara');
    $this->db->where('id_perkara', $id_perkara);
    $this->db->where('id_user_pengaju', $id_user);
    $this->db->where('status', 'pending');
    $row = $this->db->get()->row();

    if (!$row) {
        $this->session->set_flashdata('msg',
            '<div class="alert alert-danger">Data tidak ditemukan atau tidak bisa dihapus.</div>'
        );
        redirect('aph/permohonan?status=draft');
        return;
    }

    // kalau mau, bisa sekalian hapus file lampiran fisik
    if (!empty($row->lampiran_surat) && file_exists(FCPATH.$row->lampiran_surat)) {
        @unlink(FCPATH.$row->lampiran_surat);
    }

    $this->db->where('id_perkara', $id_perkara);
    $this->db->delete('tbl_mkn_perkara');

    $this->session->set_flashdata('msg',
        '<div class="alert alert-success">Permohonan berhasil dihapus.</div>'
    );

    redirect('aph/permohonan?status=draft');
}
}
