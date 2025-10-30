<?php
if (!function_exists('kpi')) {
  function kpi($key, $kpi) { return isset($kpi[$key]) ? number_format((int)$kpi[$key],0,",",".") : "0"; }
}
$cards = [
  ['key'=>'masuk_baru',          'title'=>'Masuk dari APH (Baru)', 'icon'=>'fa-download',     'bg'=>'bg-aqua',   'href'=>site_url('sekretariat_mkn/verifikasi?tab=baru'),     'cta'=>'Lihat'],
  ['key'=>'perlu_verifikasi',    'title'=>'Perlu Verifikasi',      'icon'=>'fa-info',         'bg'=>'bg-orange', 'href'=>site_url('sekretariat_mkn/verifikasi'),               'cta'=>'Proses'],
  ['key'=>'buat_surat',          'title'=>'Perlu Surat',           'icon'=>'fa-file-text-o',  'bg'=>'bg-orange', 'href'=>site_url('sekretariat_mkn/manajemen_surat?jenis=baru'),'cta'=>'Buat Surat'],
  ['key'=>'terkirim',            'title'=>'Surat Terkirim',        'icon'=>'fa-send',         'bg'=>'bg-green',  'href'=>site_url('sekretariat_mkn/manajemen_surat?status=terkirim'),'cta'=>'Lihat'],
  ['key'=>'terjadwal',           'title'=>'Terjadwal',             'icon'=>'fa-calendar',     'bg'=>'bg-blue',   'href'=>site_url('sekretariat_mkn/penjadwalan'),              'cta'=>'Kelola Jadwal'],
  ['key'=>'disposisi_ke_anggota','title'=>'Disposisi ke Anggota',  'icon'=>'fa-share-square-o','bg'=>'bg-purple','href'=>site_url('sekretariat_mkn/disposisi'),               'cta'=>'Kelola'],
  ['key'=>'penolakan',           'title'=>'Penolakan',             'icon'=>'fa-ban',          'bg'=>'bg-red',    'href'=>site_url('sekretariat_mkn/manajemen_surat?jenis=penolakan'),'cta'=>'Detail'],
];
?>
<div id="content" class="content">
  <ol class="breadcrumb pull-right"><li class="active">Dashboard</li></ol>
  <h1 class="page-header">Dashboard Sekretariat MKN <small></small></h1>

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
