<?php
// View: Dashboard APH
// Variabel yang dipakai: $kpi (array angka), opsional $username
// Contoh $kpi keys: total, draft, menunggu, perlu_kelengkapan, diproses, terjadwal, selesai, ditolak
function kpi($key, $kpi) { return isset($kpi[$key]) ? number_format($kpi[$key]) : "0"; }
?>
<section class="content-header">
  <h1>Dashboard <small>APH</small></h1>
</section>

<section class="content">
  <div class="row">
    <!-- Baris 1 -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3><?= kpi('total', $kpi); ?></h3>
          <p>Pengajuan Saya (Total)</p>
        </div>
        <div class="icon"><i class="fa fa-folder-open"></i></div>
        <a href="<?= site_url('aph/pengajuan_saya'); ?>" class="small-box-footer">Lihat semua <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3><?= kpi('draft', $kpi); ?></h3>
          <p>Draft</p>
        </div>
        <div class="icon"><i class="fa fa-pencil-square-o"></i></div>
        <a href="<?= site_url('aph/pengajuan?status=draft'); ?>" class="small-box-footer">Buka <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-orange">
        <div class="inner">
          <h3><?= kpi('menunggu', $kpi); ?></h3>
          <p>Belum Ditanggapi</p>
        </div>
        <div class="icon"><i class="fa fa-clock-o"></i></div>
        <a href="<?= site_url('aph/pengajuan?status=menunggu'); ?>" class="small-box-footer">Buka <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-red">
        <div class="inner">
          <h3><?= kpi('perlu_kelengkapan', $kpi); ?></h3>
          <p>Perlu Kelengkapan</p>
        </div>
        <div class="icon"><i class="fa fa-paperclip"></i></div>
        <a href="<?= site_url('aph/pengajuan?status=perlu_kelengkapan'); ?>" class="small-box-footer">Lengkapi <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <!-- Baris 2 -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-blue">
        <div class="inner">
          <h3><?= kpi('diproses', $kpi); ?></h3>
          <p>Sedang Diproses</p>
        </div>
        <div class="icon"><i class="fa fa-cogs"></i></div>
        <a href="<?= site_url('aph/pengajuan?status=diproses'); ?>" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-light-blue">
        <div class="inner">
          <h3><?= kpi('terjadwal', $kpi); ?></h3>
          <p>Terjadwal</p>
        </div>
        <div class="icon"><i class="fa fa-calendar-check-o"></i></div>
        <a href="<?= site_url('aph/pengajuan?status=terjadwal'); ?>" class="small-box-footer">Lihat jadwal <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-green">
        <div class="inner">
          <h3><?= kpi('selesai', $kpi); ?></h3>
          <p>Selesai</p>
        </div>
        <div class="icon"><i class="fa fa-check-square-o"></i></div>
        <a href="<?= site_url('aph/pengajuan?status=selesai'); ?>" class="small-box-footer">Riwayat <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-maroon">
        <div class="inner">
          <h3><?= kpi('ditolak', $kpi); ?></h3>
          <p>Ditolak</p>
        </div>
        <div class="icon"><i class="fa fa-times-circle"></i></div>
        <a href="<?= site_url('aph/pengajuan?status=ditolak'); ?>" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
  </div>

  <!-- Placeholder tabel ringkas (akan diisi di langkah 3) -->
  <!--
  <div class="box">
    <div class="box-header with-border"><h3 class="box-title">Pengajuan Terbaru Saya</h3></div>
    <div class="box-body table-responsive no-padding">
      <table class="table table-hover">
        <thead><tr><th>No Perkara</th><th>Tanggal</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
          <?php // foreach ($latest as $r): ?>
          <tr>
            <td><?php // echo $r->nomor; ?></td>
            <td><?php // echo $r->tgl; ?></td>
            <td><?php // echo $r->status; ?></td>
            <td><a class="btn btn-xs btn-primary" href="#">Detail</a></td>
          </tr>
          <?php // endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
  -->
</section>
