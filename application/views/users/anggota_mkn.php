<?php
if (!function_exists('kpi')) {
  function kpi($key, $kpi) { return isset($kpi[$key]) ? number_format((int)$kpi[$key],0,",",".") : "0"; }
}

/*
 * Dashboard Anggota MKN — versi ringkas:
 * - Undangan Pemeriksaan (baru)
 * - Tugas Saya / Disposisi
 * - Dalam Pemeriksaan
 * - BAP menunggu TTD
 * - Jatuh Tempo Minggu Ini
 */
$cards = [
  ['key'=>'undangan_baru',   'title'=>'Undangan Pemeriksaan (Baru)', 'href'=>'anggota_mkn/perkara?scope=undangan_baru', 'cta'=>'Buka',    'icon'=>'fa-envelope-open',   'bg'=>'bg-purple'],
  ['key'=>'tugas_saya',      'title'=>'Tugas Saya / Disposisi',      'href'=>'anggota_mkn/perkara?scope=saya',         'cta'=>'Lihat tugas','icon'=>'fa-briefcase',     'bg'=>'bg-blue'],
  ['key'=>'proses',          'title'=>'Dalam Pemeriksaan',           'href'=>'anggota_mkn/perkara?status=proses',      'cta'=>'Buka',    'icon'=>'fa-search',         'bg'=>'bg-primary'],
  ['key'=>'menunggu_ttd',    'title'=>'BAP Menunggu TTD',            'href'=>'anggota_mkn/berkas?jenis=bap&status=menunggu_ttd','cta'=>'Tinjau','icon'=>'fa-pencil-square-o','bg'=>'bg-green'],
  ['key'=>'jatuh_tempo_minggu_ini','title'=>'Jatuh Tempo Minggu Ini','href'=>'anggota_mkn/perkara?due=week',          'cta'=>'Lihat',   'icon'=>'fa-clock-o',        'bg'=>'bg-orange'],
];
?>
<div id="content" class="content">
  <ol class="breadcrumb pull-right"><li class="active">Dashboard</li></ol>
  <h1 class="page-header">Dashboard Anggota MKN <small>Tugas inti</small></h1>

  <div class="row">
    <?php foreach ($cards as $c): ?>
      <div class="col-sm-6 col-md-4 col-lg-3 m-b-15">
        <div class="widget widget-stats <?= $c['bg'] ?> text-inverse">
          <div class="stats-icon stats-icon-lg stats-icon-square bg-gradient-yellow">
            <i class="fa <?= $c['icon'] ?>"></i>
          </div>
          <div class="stats-title"><?= html_escape($c['title']) ?></div>
          <div class="stats-number"><?= kpi($c['key'], $kpi) ?></div>
          <div class="stats-progress progress"><div class="progress-bar" style="width:70%"></div></div>
          <div class="stats-link">
            <a href="<?= site_url($c['href']) ?>"><?= html_escape($c['cta']) ?> <i class="fa fa-arrow-circle-o-right"></i></a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
