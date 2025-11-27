<div id="content" class="content">
    <ol class="breadcrumb pull-right">
        <li><a href="<?= site_url('sekretariat_mkn'); ?>">Dashboard Sekretariat</a></li>
        <li><a href="<?= site_url('sekretariat_mkn/sidang'); ?>">Sidang</a></li>
        <li class="active">Putusan Hasil Pemeriksaan</li>
    </ol>

    <h1 class="page-header">Putusan Hasil Pemeriksaan</h1>

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
            <strong>Form Putusan</strong>
        </div>
        <div class="panel-body">
            <form action="<?= site_url('sekretariat_mkn/simpan_putusan'); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_perkara" value="<?= (int)$perkara->id_perkara; ?>">

                <div class="form-group">
                    <label>Nomor Surat Putusan <span class="text-danger">*</span></label>
                    <input type="text" name="no_surat" class="form-control" required
                           placeholder="Contoh: W.20.MKN.01.03-789/2025">
                </div>

                <div class="form-group">
                    <label>Perihal</label>
                    <input type="text" name="perihal" class="form-control"
                           placeholder="Putusan hasil pemeriksaan terhadap Notaris ...">
                </div>

                <div class="form-group">
                    <label>Lampiran (PDF/JPG/PNG, maks 4MB)</label>
                    <input type="file" name="lampiran" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                    <p class="help-block">Opsional — upload dokumen putusan jika sudah ada.</p>
                </div>

                <div class="text-right">
                    <a href="<?= site_url('sekretariat_mkn/sidang'); ?>" class="btn btn-default">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Simpan Putusan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
