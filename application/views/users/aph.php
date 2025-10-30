<?php
if (!function_exists('kpi')) {
  function kpi($key, $kpi) { return isset($kpi[$key]) ? number_format((int)$kpi[$key],0,",",".") : "0"; }
}
$cards = [
  ['key'=>'draft',     'title'=>'Draft',              'icon'=>'fa-pencil-square-o', 'bg'=>'bg-aqua',   'href'=>site_url('aph/pengajuan?status=draft'),     'cta'=>'Buka'],
  ['key'=>'menunggu',  'title'=>'Belum Ditanggapi',   'icon'=>'fa-clock-o',         'bg'=>'bg-orange', 'href'=>site_url('aph/pengajuan?status=menunggu'),  'cta'=>'Buka'],
  ['key'=>'diproses',  'title'=>'Diproses',           'icon'=>'fa-spinner',         'bg'=>'bg-blue',   'href'=>site_url('aph/pengajuan?status=proses'),    'cta'=>'Lihat'],
  ['key'=>'ditolak',   'title'=>'Ditolak',            'icon'=>'fa-times-circle',    'bg'=>'bg-red',    'href'=>site_url('aph/pengajuan?status=ditolak'),   'cta'=>'Detail'],
  ['key'=>'selesai',   'title'=>'Selesai',            'icon'=>'fa-check',           'bg'=>'bg-green',  'href'=>site_url('aph/pengajuan?status=selesai'),   'cta'=>'Lihat'],
];
?>
<div id="content" class="content">
  <ol class="breadcrumb pull-right"><li class="active">Dashboard</li></ol>
  <h1 class="page-header">Dashboard APH <small></small></h1>

  <div class="row">
    <?php foreach ($cards as $c): ?>
      <div class="col-md-3">
        <div class="widget widget-stats <?= $c['bg'] ?> text-inverse">
          <div class="stats-icon stats-icon-lg stats-icon-square bg-gradient-yellow"><i class="fa <?= $c['icon'] ?>"></i></div>
          <div class="stats-title"><?= html_escape($c['title']) ?></div>
          <div class="stats-number"><?= kpi($c['key'], $kpi) ?></div>
          <div class="stats-progress progress"><div class="progress-bar" style="width:70%"></div></div>
          <div class="stats-link"><a href="<?= $c['href'] ?>"><?= $c['cta'] ?> <i class="fa fa-arrow-circle-o-right"></i></a></div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
