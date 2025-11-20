<div id="content" class="content">

    <ol class="breadcrumb pull-right">
        <li><a href="aph.html">Dashboard APH</a></li>
        <li><a href="<?= site_url('aph/permohonan'); ?>">Daftar Permohonan</a></li>
        <li class="active">Detail</li>
    </ol>

    <h1 class="page-header">Detail Permohonan</h1>

    <?php if ($this->session->flashdata('msg')): ?>
        <?= $this->session->flashdata('msg'); ?>
    <?php endif; ?>

    <!-- ================== INFO PERKARA ================== -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>Informasi Perkara</strong>
        </div>
        <div class="panel-body">
            <table class="table table-striped">
                <tr>
                    <th width="25%">Nama Notaris</th>
                    <td><?= htmlspecialchars($d->nama_notaris); ?></td>
                </tr>
                <tr>
                    <th>Nomor Akta</th>
                    <td><?= htmlspecialchars($d->nomor_akta); ?></td>
                </tr>
                <tr>
                    <th>Alamat Notaris</th>
                    <td><?= nl2br(htmlspecialchars($d->alamat_notaris)); ?></td>
                </tr>
                <tr>
                    <th>Kronologi</th>
                    <td><?= nl2br(htmlspecialchars($d->kronologi)); ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td><span class="label label-primary"><?= ucfirst(htmlspecialchars($d->status)); ?></span></td>
                </tr>
                <tr>
                    <th>Tahapan di MKN</th>
                    <td><span class="label label-info"><?= ucfirst(htmlspecialchars($d->tahapan)); ?></span></td>
                </tr>
                <tr>
                    <th>Tanggal Pengajuan</th>
                    <td><?= htmlspecialchars($d->tgl_pengajuan); ?></td>
                </tr>
                <tr>
                    <th>Lampiran Permohonan</th>
                    <td>
                        <?php if (!empty($d->lampiran_surat)): ?>
                            <a href="<?= base_url($d->lampiran_surat); ?>" target="_blank" class="btn btn-default btn-xs">
                                <i class="fa fa-download"></i> Unduh Lampiran
                            </a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
            </table>

            <a href="<?= site_url('aph/permohonan?status=draft'); ?>" class="btn btn-default">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>

            <?php if ($d->status == 'pending'): ?>
                <a href="<?= site_url('aph/kirim_ke_sekretariat/'.$d->id_perkara); ?>"
                   class="btn btn-primary"
                   onclick="return confirm('Kirim permohonan ini ke Sekretariat MKN?');">
                    Kirim ke Sekretariat
                </a>
            <?php else: ?>
                <button class="btn btn-primary" disabled>
                    Sudah dikirim / diproses
                </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- ================== SURAT JAWABAN KETUA KE APH ================== -->
    <div class="panel panel-success">
        <div class="panel-heading">
            <strong>Surat Jawaban Ketua MKN kepada APH</strong>
        </div>
        <div class="panel-body">
            <?php if (!empty($surat_jawaban)): ?>
                <p><b>Nomor Surat:</b> <?= htmlspecialchars($surat_jawaban->no_surat); ?></p>
                <p><b>Perihal:</b> <?= htmlspecialchars($surat_jawaban->perihal); ?></p>
                <p><b>Tanggal Surat:</b> <?= htmlspecialchars($surat_jawaban->tgl_surat); ?></p>

                <?php if (!empty($surat_jawaban->lampiran_path)): ?>
                    <a href="<?= base_url($surat_jawaban->lampiran_path); ?>"
                       target="_blank"
                       class="btn btn-success">
                        <i class="fa fa-download"></i> Download Surat Jawaban
                    </a>
                <?php else: ?>
                    <span class="text-muted">File surat belum diunggah.</span>
                <?php endif; ?>
            <?php else: ?>
                <span class="text-muted">
                    Surat jawaban dari Ketua MKN ke APH belum tersedia. Permohonan masih diproses internal MKN.
                </span>
            <?php endif; ?>
        </div>
    </div>

    <!-- ================== PUTUSAN HASIL PEMERIKSAAN ================== -->
    <div class="panel panel-info">
        <div class="panel-heading">
            <strong>Putusan Hasil Pemeriksaan (Tahap Sidang)</strong>
        </div>
        <div class="panel-body">
            <?php if (!empty($putusan)): ?>
                <p><b>Nomor Surat:</b> <?= htmlspecialchars($putusan->no_surat); ?></p>
                <p><b>Perihal:</b> <?= htmlspecialchars($putusan->perihal); ?></p>
                <p><b>Tanggal Surat:</b> <?= htmlspecialchars($putusan->tgl_surat); ?></p>

                <?php if (!empty($putusan->lampiran_path)): ?>
                    <a href="<?= base_url($putusan->lampiran_path); ?>"
                       target="_blank"
                       class="btn btn-info">
                        <i class="fa fa-download"></i> Download Putusan
                    </a>
                <?php else: ?>
                    <span class="text-muted">File putusan belum diunggah.</span>
                <?php endif; ?>
            <?php else: ?>
                <span class="text-muted">
                    Putusan hasil pemeriksaan belum tersedia atau perkara belum sampai tahap sidang.
                </span>
            <?php endif; ?>
        </div>
    </div>

</div>
