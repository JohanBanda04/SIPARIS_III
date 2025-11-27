<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permohonan_model extends CI_Model {

    private $table = 'permohonan'; // sesuaikan kalau di DB namanya beda

    public function list_for_verifikasi($tab = 'semua') {
        $this->db->from($this->table);

        if ($tab === 'baru') {
            $this->db->where_in('status', ['baru','dikirim','menunggu_verifikasi']);
        } elseif ($tab === 'penyelidikan') {
            $this->db->where('tahapan', 'penyelidikan');
        } elseif ($tab === 'ditolak') {
            $this->db->where('status', 'ditolak');
        }

        $this->db->order_by('created_at','DESC');
        return $this->db->get()->result_array();
    }

    public function update_status($id, $data) {
        $this->db->where('id', (int)$id);
        return $this->db->update($this->table, $data);
    }

    public function get_by_id($id) {
        return $this->db->get_where($this->table, ['id' => (int)$id])->row_array();
    }
}
