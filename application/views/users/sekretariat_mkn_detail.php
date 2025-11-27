<div id="content" class="content">

    <ol class="breadcrumb pull-right">
        <li><a href="<?= site_url('sekretariat_mkn'); ?>">Dashboard Sekretariat</a></li>

        <?php if ($d->tahapan == 'penyelidikan'): ?>
            <li><a href="<?= site_url('sekretariat_mkn/penyelidikan'); ?>">Penyelidikan</a></li>
        <?php elseif ($d->tahapan == 'penyidikan'): ?>
            <li><a href="<?= site_url('sekretariat_mkn/penyidikan'); ?>">Penyidikan</a></li>
        <?php elseif ($d->tahapan == 'penuntutan'): ?>
            <li><a href="<?= site_url('sekretariat_mkn/penuntutan'); ?>">Penuntutan</a></li>
        <?php else: ?>
            <li><a href="javascript:void(0)">Perkara</a></li>
        <?php endif; ?>

        <li class="active">Detail Perkara</li>
    </ol>

    <h1 class="page-header">Detail Perkara</h1>

    <?php if ($this->session->flashdata('msg')): ?>
        <?= $this->session->flashdata('msg'); ?>
    <?php endif; ?>

    <!-- ==========================
         PANEL INFO PERKARA
    ============================== -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>Informasi Perkara</strong>
        </div>

        <div class="panel-body">
            <table class="table table-bordered">
                <tr>
                    <th width="25%">Nama Notaris</th>
                    <td><?= htmlspecialchars($d->nama_notaris); ?></td>
                </tr>
                <tr>
                    <th>Alamat Notaris</th>
                    <td><?= nl2br(htmlspecialchars($d->alamat_notaris)); ?></td>
                </tr>
                <tr>
                    <th>Nomor Akta</th>
                    <td><?= htmlspecialchars($d->nomor_akta); ?></td>
                </tr>
                <tr>
                    <th>Kronologi</th>
                    <td><?= nl2br(htmlspecialchars($d->kronologi)); ?></td>
                </tr>
                <tr>
                    <th>Tahapan</th>
                    <td>
                        <span class="label label-info">
                            <?= ucfirst($d->tahapan); ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <span class="label label-primary">
                            <?= ucfirst($d->status); ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Tanggal Pengajuan</th>
                    <td><?= htmlspecialchars($d->tgl_pengajuan); ?></td>
                </tr>
                <tr>
                    <th>Lampiran Pengajuan</th>
                    <td>
                        <?php if (!empty($d->lampiran_surat)): ?>
                            <a href="<?= base_url($d->lampiran_surat); ?>" target="_blank"
                               class="btn btn-xs btn-success">
                                <i class="fa fa-download"></i> Download Lampiran
                            </a>
                        <?php else: ?>
                            <span class="text-muted">Tidak ada lampiran</span>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>

            <!-- ==========================
                 TOMBOL AKSI SESUAI TAHAPAN
            ============================== -->
            <div class="m-t-10">
                <?php if ($d->tahapan == 'penyelidikan' && $d->status == 'proses'): ?>

                    <a href="<?= site_url('sekretariat_mkn/penyelidikan'); ?>" class="btn btn-default">
                        <i class="fa fa-arrow-left"></i> Kembali ke Penyelidikan
                    </a>

                    <a href="<?= site_url('sekretariat_mkn/naik_penyidikan/'.$d->id_perkara); ?>"
                       class="btn btn-success"
                       onclick="return confirm('Naikkan perkara ini ke tahap Penyidikan?');">
                        Naik ke Penyidikan
                    </a>

                <?php elseif ($d->tahapan == 'penyidikan' && $d->status == 'proses'): ?>

                    <a href="<?= site_url('sekretariat_mkn/penyidikan'); ?>" class="btn btn-default">
                        <i class="fa fa-arrow-left"></i> Kembali ke Penyidikan
                    </a>

                    <a href="<?= site_url('sekretariat_mkn/buat_surat/'.$d->id_perkara); ?>"
                       class="btn btn-primary">
                        Buat Surat Pemanggilan Notaris
                    </a>

                    <a href="<?= site_url('sekretariat_mkn/naik_penuntutan/'.$d->id_perkara); ?>"
                       class="btn btn-warning"
                       onclick="return confirm('Naikkan perkara ini ke tahap Penuntutan?');">
                        Naik ke Penuntutan
                    </a>

                <?php elseif ($d->tahapan == 'penuntutan' && $d->status == 'proses'): ?>

                    <a href="<?= site_url('sekretariat_mkn/penuntutan'); ?>" class="btn btn-default">
                        <i class="fa fa-arrow-left"></i> Kembali ke Penuntutan
                    </a>

                    <a href="<?= site_url('sekretariat_mkn/buat_surat_jawaban/'.$d->id_perkara); ?>"
                       class="btn btn-success">
                        Buat Surat Jawaban ke APH
                    </a>

                    <a href="<?= site_url('sekretariat_mkn/naik_sidang/'.$d->id_perkara); ?>"
                       class="btn btn-danger"
                       onclick="return confirm('Naikkan perkara ini ke tahap Sidang?');">
                        Naik ke Sidang
                    </a>

                <?php elseif ($d->tahapan == 'sidang' && $d->status == 'proses'): ?>

                    <a href="<?= site_url('sekretariat_mkn/sidang'); ?>" class="btn btn-default">
                        <i class="fa fa-arrow-left"></i> Kembali ke Sidang
                    </a>

                    <a href="<?= site_url('sekretariat_mkn/buat_putusan/'.$d->id_perkara); ?>"
                       class="btn btn-success">
                        Buat Putusan Hasil Pemeriksaan
                    </a>

                <?php else: ?>

                    <a href="<?= site_url('sekretariat_mkn'); ?>" class="btn btn-default">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>

                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- ==========================
         PANEL SURAT TERKAIT
    ============================== -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>Surat Terkait Perkara Ini</strong>
        </div>

        <div class="panel-body">

            <?php
            $labelJenis = function($jenis) {
                $map = [
                    'pemanggilan_pemeriksaan'      => 'Pemanggilan Pemeriksaan',
                    'undangan_pemeriksaan_anggota' => 'Undangan Pemeriksaan Anggota',
                    'putusan_hasil_pemeriksaan'    => 'Putusan Hasil Pemeriksaan',
                    'jawaban_ketua_ke_aph'         => 'Jawaban Ketua MKN ke APH',
                    'putusan_pengadilan_ke_mpd'    => 'Putusan Pengadilan ke MPD',
                    'keterangan_penjelidikan'      => 'Keterangan Penyelidikan',
                ];
                return $map[$jenis] ?? $jenis;
            };

            $labelRole = function($role) {
                $map = [
                    'notaris'     => 'Notaris',
                    'anggota_mkn' => 'Anggota MKN',
                    'aph'         => 'APH',
                    'mpd'         => 'MPD',
                ];
                return $map[$role] ?? $role;
            };
            ?>

            <?php if (empty($surat)): ?>

                <div class="alert alert-info">
                    Belum ada surat yang tercatat untuk perkara ini.
                </div>

            <?php else: ?>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Jenis Surat</th>
                            <th>No. Surat</th>
                            <th>Perihal</th>
                            <th>Ditujukan Ke</th>
                            <th>Tanggal Surat</th>
                            <th width="15%">Lampiran</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php $no = 1; foreach ($surat as $s): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($labelJenis($s->jenis_surat)); ?></td>
                                <td><?= htmlspecialchars($s->no_surat); ?></td>
                                <td><?= htmlspecialchars($s->perihal); ?></td>
                                <td><?= htmlspecialchars($labelRole($s->ditujukan_ke_role)); ?></td>
                                <td><?= htmlspecialchars($s->tgl_surat); ?></td>
                                <td>
                                    <?php if (!empty($s->lampiran_path)): ?>
                                        <a href="<?= base_url($s->lampiran_path); ?>"
                                           target="_blank"
                                           class="btn btn-xs btn-default">
                                            <i class="fa fa-file-pdf-o"></i> Lihat
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">Tidak ada lampiran</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>

            <?php endif; ?>

        </div>
    </div>
    <div class="panel panel-default">
    <div class="panel-heading">
        <strong>Catatan Pemeriksaan / Hasil Sidang</strong>
    </div>
    <div class="panel-body">
        <form action="<?= site_url('sekretariat_mkn/simpan_catatan/'.$perkara->id_perkara); ?>" method="post">
            <div class="form-group">
                <label>Riwayat Catatan</label>
                <div style="white-space:pre-wrap; border:1px solid #eee; padding:10px; border-radius:4px; background:#fafafa; max-height:250px; overflow-y:auto;">
                    <?= !empty($perkara->catatan) ? nl2br(htmlspecialchars($perkara->catatan)) : '<span class="text-muted">Belum ada catatan.</span>'; ?>
                </div>
            </div>

            <div class="form-group">
                <label>Catatan Baru</label>
                <textarea name="catatan" class="form-control" rows="3"
                          placeholder="Tulis ringkasan hasil pemeriksaan anggota / kesimpulan sidang..."></textarea>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-primary">
                    Simpan Catatan
                </button>
            </div>
        </form>
    </div>
</div>

</div>
