<div id="content" class="content">
    <ol class="breadcrumb pull-right">
        <li><a href="<?= site_url('sekretariat_mkn'); ?>">Dashboard</a></li>
        <li class="active">Kelola Akun APH</li>
    </ol>
    <h1 class="page-header">
        Kelola Akun APH
        <small>daftar akun + kontrol status</small>
    </h1>

    <?php if ($this->session->flashdata('msg')): ?>
        <?= $this->session->flashdata('msg'); ?>
    <?php endif; ?>

    <!-- Tombol untuk menampilkan form -->
    <div class="m-b-10 text-right">
        <button type="button" class="btn btn-primary btn-sm" id="btn-tambah-aph">
            <i class="fa fa-plus"></i> Tambah Akun APH Baru
        </button>
    </div>

    <!-- PANEL FORM (DISEMBUNYIKAN DEFAULT) -->
    <div id="panel-form-aph" class="panel panel-inverse" style="display:none;">
        <div class="panel-heading">
            <h4 class="panel-title">Form Tambah Akun APH</h4>
        </div>
        <div class="panel-body">
            <form method="post" action="<?= site_url('sekretariat_mkn/kelola_aph'); ?>">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Lengkap / Instansi <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lengkap" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Ulangi Password <span class="text-danger">*</span></label>
                            <input type="password" name="password2" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Level APH <span class="text-danger">*</span></label>
                            <select name="level_aph" class="form-control" required>
                                <option value="aph">APH – Kepolisian</option>
                                <option value="aph_polri">APH – Polri (opsional)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" name="btnsimpan" class="btn btn-primary">
                    <i class="fa fa-save"></i> Simpan Akun
                </button>
                <button type="button" class="btn btn-default" id="btn-batal-form-aph">
                    Batal
                </button>
            </form>
        </div>
    </div>
    <!-- END PANEL FORM -->

    <!-- PANEL TABEL DAFTAR AKUN -->
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">Daftar Akun APH</h4>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th style="width:40px;">#</th>
                        <th>Nama Lengkap / Instansi</th>
                        <th>Username</th>
                        <th>Level</th>
                        <th>Status</th>
                        <th>Tgl Daftar</th>
                        <th style="width:160px;">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($rows)): ?>
                        <?php $no = 1; foreach ($rows as $r): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= html_escape($r->nama_lengkap); ?></td>
                                <td><?= html_escape($r->username); ?></td>
                                <td><?= html_escape($r->level); ?></td>
                                <td>
                                    <?php if ((int)$r->aktif === 1): ?>
                                        <span class="label label-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="label label-default">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= html_escape($r->tgl_daftar); ?></td>
                                <td>
                                    <!-- Toggle Aktif/Nonaktif -->
                                    <a href="<?= site_url('sekretariat_mkn/toggle_aph/'.$r->id_user); ?>"
                                       class="btn btn-xs <?= ($r->aktif==1?'btn-warning':'btn-success'); ?>"
                                       onclick="return confirm('Yakin ingin mengubah status akun ini?');">
                                        <?= ($r->aktif==1 ? 'Nonaktifkan' : 'Aktifkan'); ?>
                                    </a>

                                    <!-- Reset Password -->
                                    <a href="<?= site_url('sekretariat_mkn/reset_password_aph/'.$r->id_user); ?>"
                                       class="btn btn-xs btn-danger"
                                       onclick="return confirm('Reset password akun <?= html_escape($r->username); ?> ke default?');">
                                        Reset Pass
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Belum ada akun APH.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END PANEL TABEL -->
</div>

<script>
$(function () {
    $('#btn-tambah-aph').on('click', function (e) {
        e.preventDefault();
        $('#panel-form-aph').slideToggle('fast');
    });
    $('#btn-batal-form-aph').on('click', function (e) {
        e.preventDefault();
        $('#panel-form-aph').slideUp('fast');
    });
});
</script>
