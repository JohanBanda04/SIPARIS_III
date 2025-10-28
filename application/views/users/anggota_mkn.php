<?php
// View: Dashboard Anggota MKN
// $kpi keys: ditugaskan, menunggu_telaah, dalam_pemeriksaan, butuh_rekomendasi, menunggu_ttd, jatuh_tempo_minggu_ini, selesai, perlu_revisi
function kpi($key, $kpi) { return isset($kpi[$key]) ? number_format($kpi[$key]) : "0"; }
?>
<section class="content-header">
  <h1>Dashboard <small>Anggota MKN</small></h1>
</section>

<section class="content">
  <div class="row">
    <!-- Baris 1 -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3><?= kpi('ditugaskan', $kpi); ?></h3>
          <p>Perkara Ditugaskan</p>
        </div>
        <div class="icon"><i class="fa fa-briefcase"></i></div>
        <a href="<?= site_url('anggota_mkn/perkara?scope=saya'); ?>" class="small-box-footer">Lihat tugas <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3><?= kpi('menunggu_telaah', $kpi); ?></h3>
          <p>Menunggu Telaah</p>
        </div>
        <div class="icon"><i class="fa fa-hourglass-half"></i></div>
        <a href="<?= site_url('anggota_mkn/perkara?status=menunggu_telaah'); ?>" class="small-box-footer">Proses <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-blue">
        <div class="inner">
          <h3><?= kpi('dalam_pemeriksaan', $kpi); ?></h3>
          <p>Dalam Pemeriksaan</p>
        </div>
        <div class="icon"><i class="fa fa-search"></i></div>
        <a href="<?= site_url('anggota_mkn/perkara?status=dalam_pemeriksaan'); ?>" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-purple">
        <div class="inner">
          <h3><?= kpi('butuh_rekomendasi', $kpi); ?></h3>
          <p>Butuh Rekomendasi</p>
        </div>
        <div class="icon"><i class="fa fa-thumb-tack"></i></div>
        <a href="<?= site_url('anggota_mkn/perkara?status=butuh_rekomendasi'); ?>" class="small-box-footer">Beri rekomendasi <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <!-- Baris 2 -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-light-blue">
        <div class="inner">
          <h3><?= kpi('menunggu_ttd', $kpi); ?></h3>
          <p>Menunggu TTD BAP</p>
        </div>
        <div class="icon"><i class="fa fa-pencil-square"></i></div>
        <a href="<?= site_url('anggota_mkn/berkas?jenis=bap&status=menunggu_ttd'); ?>" class="small-box-footer">Tinjau <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-orange">
        <div class="inner">
          <h3><?= kpi('jatuh_tempo_minggu_ini', $kpi); ?></h3>
          <p>Jatuh Tempo Minggu Ini</p>
        </div>
        <div class="icon"><i class="fa fa-bell-o"></i></div>
        <a href="<?= site_url('anggota_mkn/perkara?due=minggu_ini'); ?>" class="small-box-footer">Lihat deadline <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-green">
        <div class="inner">
          <h3><?= kpi('selesai', $kpi); ?></h3>
          <p>Selesai</p>
        </div>
        <div class="icon"><i class="fa fa-check"></i></div>
        <a href="<?= site_url('anggota_mkn/perkara?status=selesai'); ?>" class="small-box-footer">Riwayat <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-red">
        <div class="inner">
          <h3><?= kpi('perlu_revisi', $kpi); ?></h3>
          <p>Dikembalikan / Perlu Revisi</p>
        </div>
        <div class="icon"><i class="fa fa-undo"></i></div>
        <a href="<?= site_url('anggota_mkn/berkas?status=perlu_revisi'); ?>" class="small-box-footer">Perbaiki <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
  </div>

  <!-- Placeholder tabel ringkas (diisi di langkah 3) -->
</section>
