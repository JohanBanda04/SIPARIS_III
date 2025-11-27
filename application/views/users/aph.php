<?php
if (!function_exists('kpi')) {
  function kpi($key, $kpi) { return isset($kpi[$key]) ? number_format((int)$kpi[$key],0,",",".") : "0"; }
}

/*
 * Dashboard APH — versi ringkas:
 * - Draft
 * - Dikirim / Belum Ditanggapi (oleh Sekretariat)
 * - Diproses (tahapan MKN berjalan)
 * - Selesai
 * (opsional: Ditolak)
 */
$cards = [
  [
    'key'   => 'buat',
    'title' => 'Buat Permohonan',
    'href'  => 'aph/create',
    'cta'   => 'Buat',
    'icon'  => 'fa-paper-plane',
    'bg'    => 'bg-green',
  ],
  ['key'=>'draft',          'title'=>'Draft',                      'href'=>'aph/permohonan?status=draft',     'cta'=>'Buka',   'icon'=>'fa-pencil-square-o', 'bg'=>'bg-blue'],
  ['key'=>'dikirim',        'title'=>'Dikirim / Belum Ditanggapi', 'href'=>'aph/permohonan?status=dikirim',   'cta'=>'Buka',   'icon'=>'fa-clock-o',          'bg'=>'bg-orange'],
  ['key'=>'diproses',       'title'=>'Diproses',                   'href'=>'aph/permohonan?status=diproses',  'cta'=>'Lihat',  'icon'=>'fa-cogs',             'bg'=>'bg-primary'],
  ['key'=>'selesai',        'title'=>'Selesai',                    'href'=>'aph/permohonan?status=selesai',   'cta'=>'Lihat',  'icon'=>'fa-check',            'bg'=>'bg-green'],
  ['key'=>'ditolak',  'title'=>'Ditolak',                     'href'=>'aph/permohonan?status=ditolak',  'cta'=>'Lihat', 'icon'=>'fa-times-circle',     'bg'=>'bg-red'],
  // aktifkan kalau klien ingin ditampilkan juga:
  // ['key'=>'ditolak',     'title'=>'Ditolak',                    'href'=>'aph/permohonan?status=ditolak',   'cta'=>'Detail', 'icon'=>'fa-times-circle',     'bg'=>'bg-red'],
];
?>
<div id="content" class="content">
  <ol class="breadcrumb pull-right"><li class="active">Dashboard</li></ol>
  <h1 class="page-header">Dashboard APH <small>Status permohonan</small></h1>

  <div class="row">
    <?php foreach ($cards as $c): ?>
      <div class="col-sm-6 col-md-4 col-lg-3 m-b-15">
        <div class="widget widget-stats <?= $c['bg'] ?> text-inverse">
          <div class="stats-icon stats-icon-lg stats-icon-square bg-gradient-yellow">
            <i class="fa <?= $c['icon'] ?>"></i>
          </div>
          <div class="stats-title"><?= html_escape($c['title']) ?></div>

          <?php if ($c['key'] !== 'buat'): ?>
            <div class="stats-number"><?= kpi($c['key'], $kpi) ?></div>
          <?php else: ?>
            <!-- kosongin angka biar nggak tampil 0 -->
            <div class="stats-number">&nbsp;</div>
          <?php endif; ?>

          <div class="stats-progress progress">
            <div class="progress-bar" style="width:70%"></div>
          </div>
          <div class="stats-link">
            <a href="<?= site_url($c['href']) ?>">
              <?= html_escape($c['cta']) ?> <i class="fa fa-arrow-circle-o-right"></i>
            </a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
