<div id="content" class="content">
    <ol class="breadcrumb pull-right">
        <li><a href="sekretariat_mkn.html">Dashboard Sekretariat</a></li>
        <li><a href="<?= site_url('sekretariat_mkn/penyidikan'); ?>">Penyidikan</a></li>
        <li class="active">Buat Surat Pemanggilan</li>
    </ol>

    <h1 class="page-header">Buat Surat Pemanggilan Pemeriksaan</h1>

    <?php if ($this->session->flashdata('msg')): ?>
        <?= $this->session->flashdata('msg'); ?>
    <?php endif; ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>Data Perkara</strong>
        </div>
        <div class="panel-body">
            <table class="table table-bordered">
                <tr>
                    <th width="25%">Nama Notaris</th>
                    <td><?= htmlspecialchars($perkara->nama_notaris); ?></td>
                </tr>
                <tr>
                    <th>Nomor Akta</th>
                    <td><?= htmlspecialchars($perkara->nomor_akta); ?></td>
                </tr>
                <tr>
                    <th>Kronologi Singkat</th>
                    <td><?= nl2br(htmlspecialchars($perkara->kronologi)); ?></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>Form Surat Pemanggilan</strong>
        </div>
        <div class="panel-body">
            <form action="<?= site_url('sekretariat_mkn/simpan_surat'); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_perkara" value="<?= (int)$perkara->id_perkara; ?>">

                <div class="form-group">
                    <label>Nomor Surat <span class="text-danger">*</span></label>
                    <input type="text" name="no_surat" class="form-control" required
                           placeholder="Contoh: W.20.MKN.01.01-123/2025">
                </div>

                <div class="form-group">
                    <label>Perihal</label>
                    <input type="text" name="perihal" class="form-control"
                           placeholder="Pemanggilan pemeriksaan terhadap Notaris ...">
                </div>

                <div class="form-group">
                    <label>Ditujukan ke</label>
                    <select name="ditujukan_ke_role" class="form-control">
                        <option value="notaris">Notaris</option>
                        <option value="anggota_mkn">Anggota MKN</option>
                        <option value="aph">APH</option>
                        <option value="mpd">MPD</option>
                    </select>
                    <p class="help-block">Untuk saat ini cukup pilih <b>Notaris</b>.</p>
                </div>

                <div class="form-group">
                    <label>Lampiran (PDF/JPG/PNG, maks 4MB)</label>
                    <input type="file" name="lampiran" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                    <p class="help-block">Opsional — upload surat resmi jika sudah ada draft-nya.</p>
                </div>

                <div class="text-right">
                    <a href="<?= site_url('sekretariat_mkn/penyidikan'); ?>" class="btn btn-default">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Simpan Surat Pemanggilan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
