<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="dashboard.html">Dashboard</a></li>
        <li class="active"><?= $judul_web; ?></li>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header">Data <small><?= $judul_web; ?></small></h1>
    <!-- end page-header -->

    <!-- begin row -->
    <div class="row">
        <div class="col-md-12">
            <?php
            echo $this->session->flashdata('msg');
            $level = $this->session->userdata('level');
            $link3 = strtolower($this->uri->segment(3));
            ?>

            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default"
                           data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success"
                           data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning"
                           data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger"
                           data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title"><?= $tableName; ?></h4>
                </div>

                <div class="panel-body">
                    <div class="row align-items-center mb-2">
                        <div class="col-md-3">
                            <b>Filter Cuti</b>
                            <select class="form-control default-select2" id="stt">
                                <option value="">- Semua -</option>
                                <option value="pengajuan" <?= $link3 == 'pengajuan' ? 'selected' : ''; ?>>Pengajuan</option>
                                <option value="dispo_mpd" <?= $link3 == 'dispo_mpd' ? 'selected' : ''; ?>>Disposisi MPD</option>
                                <option value="approve" <?= $link3 == 'approve' ? 'selected' : ''; ?>>Disetujui</option>
                                <option value="decline" <?= $link3 == 'decline' ? 'selected' : ''; ?>>Ditolak</option>
                            </select>
                        </div>

                        <div class="col-md-9 text-right" style="margin-top: 20px;">
                            <?php if ($level == 'notaris'): ?>
                                <a href="<?= strtolower($this->uri->segment(1)).'/'.strtolower($this->uri->segment(2)); ?>/t.html"
                                   class="btn btn-primary">Permohonan Cuti</a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <hr>

                    <div class="table-responsive">
                        <table id="data-table" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Alasan</th>
                                <th>Jml Hari</th>
                                <th>Nama Pemohon</th>
                                <th>Status</th>
                                <th style="text-align:center;">Opsi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $no = 1; foreach ($query->result() as $baris): ?>
                                <tr>
                                    <td><b><?= $no++; ?>.</b></td>
                                    <td><?= date('d-m-Y', strtotime($baris->created_at)); ?></td>
                                    <td><?= $baris->alasan; ?></td>
                                    <td><?= $baris->jml_hari_cuti; ?> hari</td>
                                    <td><?= $this->db->get_where('tbl_user', ["id_user" => $baris->user_id])->row()->nama_lengkap; ?></td>
                                    <td>
                                        <?php
                                        $warna = [
                                            'pengajuan' => 'blue',
                                            'dispo_mpd' => 'purple',
                                            'decline'   => 'red',
                                            'approve'   => 'green'
                                        ];
                                        $warna_bg = $warna[$baris->status] ?? 'gray';
                                        ?>
                                        <span class="badge" style="background-color:<?= $warna_bg; ?>; color:white;">
                                            <?= ucfirst($baris->status); ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= strtolower($this->uri->segment(1)).'/'.strtolower($this->uri->segment(2)).'/d/'.hashids_encrypt($baris->id_cuti); ?>"
                                           class="btn btn-info btn-xs" title="Detail Cuti">
                                            <i class="fa fa-search"></i>
                                        </a>

                                        <?php if (in_array($level, ['petugas','superadmin'])):
                                            $display = (($baris->status == "approve" || $baris->status == "decline") && $level == 'superadmin') ? 'display:none;' : '';
                                        ?>
                                            <a href="javascript:;" class="btn btn-success btn-xs btn-tindak"
                                               data-id="<?= $baris->id_cuti; ?>"
                                               data-status="<?= $baris->status; ?>"
                                               data-catatan="<?= htmlspecialchars($baris->catatan, ENT_QUOTES); ?>"
                                               style="<?= $display; ?>" title="Tindak Lanjut">
                                                <i class="fa fa-forward"></i>
                                            </a>
                                        <?php endif; ?>

                                        <?php
                                        $boleh_edit = in_array($level, ['notaris','petugas']) && $baris->status != 'pengajuan';
                                        if ($boleh_edit): ?>
                                            <a href="<?= strtolower($this->uri->segment(1)).'/'.strtolower($this->uri->segment(2)).'/e/'.hashids_encrypt($baris->id_cuti); ?>"
                                               class="btn btn-warning btn-xs" title="Edit Cuti">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        <?php endif; ?>

                                        <?php
                                        $boleh_hapus =
                                            ($level == 'notaris' && $baris->status == 'pengajuan') ||
                                            (in_array($level, ['superadmin','petugas']) && $baris->status != 'pengajuan');
                                        if ($boleh_hapus): ?>
                                            <a href="javascript:;" class="btn btn-danger btn-xs btn-hapus"
                                               data-url="<?= strtolower($this->uri->segment(1)).'/'.strtolower($this->uri->segment(2)).'/h/'.hashids_encrypt($baris->id_cuti); ?>"
                                               title="Hapus Data Cuti">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <?php $this->load->view('users/cuti/modal_tindak_lanjut'); ?>
    <?php $this->load->view('users/cuti/modal_upload_pnbp_notarispengganti'); ?>
</div>

<!-- JS Section -->
<script>
$(document).ready(function () {
    // SweetAlert Hapus
    $('.btn-hapus').on('click', function (e) {
        e.preventDefault();
        const url = $(this).data('url');
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) window.location.href = url;
        });
    });

    // Modal Tindak Lanjut
    $('.btn-tindak').on('click', function () {
        $('#id_cuti').val($(this).data('id'));
        $('#catatan_petugas').val($(this).data('catatan') || '');
        $('#aksi').val($(this).data('status')).trigger('change');
        $('#modalTindakLanjut').modal('show');
    });

    // DataTable + filter
    var table = $('#data-table').DataTable();
    $('#stt').on('change', function () {
        table.column(5).search($(this).val() || '', true, false).draw();
    });
});
</script>

<?php $this->load->view('users/laporan/modal_konfirm'); ?>
<!-- end #content -->
