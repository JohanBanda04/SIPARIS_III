<?php
if (!function_exists('kpi')) {
    function kpi($key, $kpi) {
        return isset($kpi[$key]) ? number_format((int)$kpi[$key], 0, ",", ".") : "0";
    }
}

$cards = [
    [
        'key'   => 'penyelidikan',
        'title' => 'Penyelidikan',
        'href'  => 'sekretariat_mkn/penyelidikan',
        'cta'   => 'Lihat Perkara',
        'icon'  => 'fa-info',
        'bg'    => 'bg-orange'
    ],
    [
        'key'   => 'penyidikan',
        'title' => 'Penyidikan',
        'href'  => 'sekretariat_mkn/penyidikan',
        'cta'   => 'Lihat Perkara',
        'icon'  => 'fa-bullhorn',
        'bg'    => 'bg-blue'
    ],
    [
        'key'   => 'penuntutan',
        'title' => 'Penuntutan',
        'href'  => 'sekretariat_mkn/penuntutan',
        'cta'   => 'Lihat Perkara',
        'icon'  => 'fa-share-square-o',
        'bg'    => 'bg-warning'
    ],
    [
        'key'   => 'sidang',
        'title' => 'Sidang',
        'href'  => 'sekretariat_mkn/sidang',
        'cta'   => 'Lihat Perkara',
        'icon'  => 'fa-gavel',
        'bg'    => 'bg-green'
    ],
        [
        'key'   => 'catatan_hari_ini',
        'title' => 'Catatan Baru Hari Ini',
        'href'  => 'sekretariat_mkn/catatan_hari_ini',
        'cta'   => 'Lihat',
        'icon'  => 'fa-sticky-note',
        'bg'    => 'bg-grey',
      ],
      
];
?>

<div id="content" class="content">
    <ol class="breadcrumb pull-right">
        <li class="active">Dashboard</li>
    </ol>

    <h1 class="page-header">
        Dashboard Sekretariat MKN
        <small>Tahapan Proses</small>
    </h1>

    <div class="row">
        <?php foreach ($cards as $c): ?>
            <div class="col-sm-6 col-md-4 col-lg-3 m-b-15">
                <div class="widget widget-stats <?= $c['bg']; ?> text-inverse">
                    <div class="stats-icon stats-icon-lg stats-icon-square bg-gradient-yellow">
                        <i class="fa <?= $c['icon']; ?>"></i>
                    </div>
                    <div class="stats-title"><?= html_escape($c['title']); ?></div>
                    <div class="stats-number"><?= kpi($c['key'], $kpi); ?></div>
                    <div class="stats-progress progress">
                        <div class="progress-bar" style="width:70%"></div>
                    </div>
                    <div class="stats-link">
                        <?php if ($c['href'] === '#'): ?>
                            <a href="javascript:void(0);">
                                <?= html_escape($c['cta']); ?>
                            </a>
                        <?php else: ?>
                            <a href="<?= site_url($c['href']); ?>">
                                <?= html_escape($c['cta']); ?>
                                <i class="fa fa-arrow-circle-o-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<!--  -->