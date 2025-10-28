<?php
// View: Dashboard Sekretariat MKN
// $kpi keys: masuk_baru, perlu_verifikasi, perlu_surat, surat_terkirim, terjadwal, disposisi, arsip_selesai, penolakan
function kpi($key, $kpi) { return isset($kpi[$key]) ? number_format($kpi[$key]) : "0"; }
?>
<section class="content-header">
  <h1>Dashboard <small>Sekretariat MKN</small></h1>
</section>

<section class="content">
  <div class="row">
    <!-- Baris 1 -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3><?= kpi('masuk_baru', $kpi); ?></h3>
          <p>Masuk dari APH (Baru)</p>
        </div>
        <div class="icon"><i class="fa fa-download"></i></div>
        <a href="<?= site_url('sekretariat_mkn/verifikasi?tab=baru'); ?>" class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-orange">
        <div class="inner">
          <h3><?= kpi('perlu_verifikasi', $kpi); ?></h3>
          <p>Perlu Verifikasi</p>
        </div>
        <div class="icon"><i class="fa fa-check-square"></i></div>
        <a href="<?= site_url('sekretariat_mkn/verifikasi'); ?>" class="small-box-footer">Proses <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3><?= kpi('perlu_surat', $kpi); ?></h3>
          <p>Perlu Surat</p>
        </div>
        <div class="icon"><i class="fa fa-file-text-o"></i></div>
        <a href="<?= site_url('sekretariat_mkn/manajemen_surat'); ?>" class="small-box-footer">Buat Surat <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-green">
        <div class="inner">
          <h3><?= kpi('surat_terkirim', $kpi); ?></h3>
          <p>Surat Terkirim</p>
        </div>
        <div class="icon"><i class="fa fa-send"></i></div>
        <a href="<?= site_url('sekretariat_mkn/manajemen_surat?status=terkirim'); ?>" class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <!-- Baris 2 -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-light-blue">
        <div class="inner">
          <h3><?= kpi('terjadwal', $kpi); ?></h3>
          <p>Terjadwal</p>
        </div>
        <div class="icon"><i class="fa fa-calendar"></i></div>
        <a href="<?= site_url('sekretariat_mkn/penjadwalan'); ?>" class="small-box-footer">Kelola Jadwal <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-purple">
        <div class="inner">
          <h3><?= kpi('disposisi', $kpi); ?></h3>
          <p>Disposisi ke Anggota</p>
        </div>
        <div class="icon"><i class="fa fa-share-square-o"></i></div>
        <a href="<?= site_url('sekretariat_mkn/disposisi'); ?>" class="small-box-footer">Kelola <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-red-active">
        <div class="inner">
          <h3><?= kpi('arsip_selesai', $kpi); ?></h3>
          <p>Selesai / Arsip</p>
        </div>
        <div class="icon"><i class="fa fa-archive"></i></div>
        <a href="<?= site_url('sekretariat_mkn/arsip'); ?>" class="small-box-footer">Buka Arsip <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-red">
        <div class="inner">
          <h3><?= kpi('penolakan', $kpi); ?></h3>
          <p>Penolakan</p>
        </div>
        <div class="icon"><i class="fa fa-ban"></i></div>
        <a href="<?= site_url('sekretariat_mkn/manajemen_surat?jenis=penolakan'); ?>" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
  </div>

  <!-- Placeholder tabel ringkas (diisi di langkah 3) -->
</section>
