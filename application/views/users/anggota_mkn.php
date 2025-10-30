<?php
if (!function_exists('kpi')) {
  function kpi($key, $kpi) { return isset($kpi[$key]) ? number_format((int)$kpi[$key],0,",",".") : "0"; }
}
$cards = [
  ['key'=>'tugas_saya',               'title'=>'Tugas Saya',               'icon'=>'fa-tasks',           'bg'=>'bg-aqua',   'href'=>site_url('anggota_mkn/perkara?scope=saya'),                 'cta'=>'Lihat tugas'],
  ['key'=>'menunggu_telaah',          'title'=>'Menunggu Telaah',          'icon'=>'fa-hourglass-half',  'bg'=>'bg-orange', 'href'=>site_url('anggota_mkn/perkara?status=menunggu_telaah'),      'cta'=>'Proses'],
  ['key'=>'dalam_pemeriksaan',        'title'=>'Dalam Pemeriksaan',        'icon'=>'fa-search',          'bg'=>'bg-blue',   'href'=>site_url('anggota_mkn/perkara?status=proses'),               'cta'=>'Buka'],
  ['key'=>'menunggu_ttd',             'title'=>'Menunggu TTD BAP',         'icon'=>'fa-pencil-square',   'bg'=>'bg-blue',   'href'=>site_url('anggota_mkn/berkas?jenis=bap&status=menunggu_ttd'),'cta'=>'Tinjau'],
  ['key'=>'jatuh_tempo_minggu_ini',   'title'=>'Jatuh Tempo Minggu Ini',   'icon'=>'fa-calendar-check-o','bg'=>'bg-orange', 'href'=>site_url('anggota_mkn/perkara?due=week'),                     'cta'=>'Lihat'],
  ['key'=>'perlu_revisi',             'title'=>'Perlu Revisi',             'icon'=>'fa-undo',            'bg'=>'bg-purple', 'href'=>site_url('anggota_mkn/berkas?status=perlu_revisi'),          'cta'=>'Perbaiki'],
];
?>
<div id="content" class="content">
  <ol class="breadcrumb pull-right"><li class="active">Dashboard</li></ol>
  <h1 class="page-header">Dashboard Anggota MKN <small></small></h1>

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
