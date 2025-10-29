<!DOCTYPE html>
<?php
$cek      = $user->row();
$nama     = $cek->nama_lengkap;
$username = $cek->username;
$level    = $cek->level;
$foto     = "img/user/user-default.jpg";

if ($level == 'user') {
    $d_k = $this->db->get_where('tbl_data_user', ['id_user' => $cek->id_user])->row();
    if (!empty($d_k->foto) && file_exists($d_k->foto)) {
        $foto = $d_k->foto;
    }
}

$menu      = strtolower($this->uri->segment(1));
$sub_menu  = strtolower($this->uri->segment(2));
$sub_menu3 = strtolower($this->uri->segment(3));
?>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <title><?= $judul_web; ?></title>
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport"/>
  <meta content="<?= $this->Mcrud->judul_web(); ?>" name="description"/>
  <meta content="CV. Esotechno" name="author"/>
  <meta name="keywords" content="CV. Esotechno, <?= $this->Mcrud->judul_web(); ?>">
  <base href="<?= base_url(); ?>"/>
  <link rel="shortcut icon" href="assets/favicon.png" type="image/x-icon"/>

  <!-- BASE CSS -->
  <link href="assets/panel/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet"/>
  <link href="assets/panel/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="assets/panel/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
  <link href="assets/panel/plugins/ionicons/css/ionicons.min.css" rel="stylesheet"/>
  <link href="assets/panel/css/animate.min.css" rel="stylesheet"/>
  <link href="assets/panel/css/style.min.css" rel="stylesheet"/>
  <link href="assets/panel/css/style-responsive.min.css" rel="stylesheet"/>
  <link href="assets/panel/css/theme/default.css" rel="stylesheet" id="theme"/>
  <link href="assets/panel/css/style-gue.css" rel="stylesheet"/>

  <!-- PAGE LEVEL CSS -->
  <link href="assets/panel/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet"/>
  <link href="assets/panel/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet"/>
  <link href="assets/panel/plugins/parsley/src/parsley.css" rel="stylesheet"/>
  <link href="assets/panel/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.css" rel="stylesheet"/>
  <link href="assets/panel/plugins/select2/dist/css/select2.min.css" rel="stylesheet"/>
  <link href="assets/panel/plugins/bootstrap-eonasdan-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet"/>

  <!-- PLUGINS -->
  <script src="assets/panel/plugins/pace/pace.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="assets/fancybox/jquery.fancybox.css">
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/fancybox/jquery.fancybox.js"></script>

  <!-- Small-Box Styling -->
  <style>
    .small-box {
      border-radius:10px; position:relative; display:block; margin-bottom:20px;
      overflow:hidden; color:#fff; box-shadow:0 8px 22px rgba(0,0,0,.08);
      transition:transform .15s, box-shadow .2s;
    }
    .small-box:hover { transform:translateY(-2px); box-shadow:0 10px 26px rgba(0,0,0,.12); }
    .small-box>.inner { padding:16px; position:relative; z-index:2; }
    .small-box h3 { font-size:34px; font-weight:800; margin:0 0 8px; }
    .small-box p { font-size:15px; margin:0; opacity:.95; }
    .small-box .icon { position:absolute; right:12px; top:-6px; font-size:74px; opacity:.18; }
    .small-box .small-box-footer {
      display:block; background:rgba(0,0,0,.08); color:#fff; padding:7px 10px; text-align:center;
      font-weight:600; border-top:1px solid rgba(255,255,255,.08);
    }
    .bg-aqua{background:linear-gradient(135deg,#00c0ef 0%,#00a0c8 100%)!important;}
    .bg-green{background:linear-gradient(135deg,#00a65a 0%,#028a4b 100%)!important;}
    .bg-yellow{background:linear-gradient(135deg,#f39c12 0%,#d58512 100%)!important;}
    .bg-red{background:linear-gradient(135deg,#dd4b39 0%,#c14132 100%)!important;}
    .bg-blue{background:linear-gradient(135deg,#0073b7 0%,#005e97 100%)!important;}
  </style>
</head>

<body>
<div id="page-loader" class="fade in"><span class="spinner"></span></div>
<div id="page-container" class="fade page-sidebar-fixed page-header-fixed in">

  <!-- HEADER -->
  <div id="header" class="header navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
      <div class="navbar-header">
        <a href="" class="navbar-brand">
          <span class="navbar-logo"><i class="fa fa-vcard"></i></span> &nbsp;<b>Panel</b> <?= ucwords($level); ?>
        </a>
        <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
          <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
        </button>
      </div>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle icon"><i class="ion-ios-bell"></i>
            <span class="label" id="jml_notif_bell">0</span></a>
          <ul class="dropdown-menu media-list pull-right animated fadeInDown" id="notif_bell"></ul>
        </li>
        <li class="dropdown navbar-user">
          <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
            <span class="user-image online"><img src="<?= $foto; ?>" alt=""/></span>
            <span class="hidden-xs"><?= ucwords($nama); ?></span> <b class="caret"></b>
          </a>
          <ul class="dropdown-menu animated fadeInLeft">
            <li class="arrow"></li>
            <li <?= ($menu=='profile')?"class='active'":""; ?>><a href="profile.html"><?= ($level=='user'?'Lengkapi ':''); ?>Profile</a></li>
            <li <?= ($menu=='ubah_pass')?"class='active'":""; ?>><a href="ubah_pass.html">Ubah Password</a></li>
            <?php if ($level=="notaris"): ?>
              <li <?= ($menu=='dossier_pribadi')?"class='active'":""; ?>><a href="users/dossier_pribadi.html">Dossier Pribadi</a></li>
            <?php endif; ?>
            <li class="divider"></li>
            <li><a href="web/logout.html">Keluar</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>

  <!-- SIDEBAR -->
  <div id="sidebar" class="sidebar">
    <div data-scrollbar="true" data-height="100%">
      <ul class="nav">
        <li class="nav-profile">
          <div class="image"><a href="profile"><img src="<?= $foto; ?>" alt=""/></a></div>
          <div class="info"><?= ucwords($nama); ?><small>@<?= strtolower($username); ?></small></div>
        </li>
      </ul>

      <ul class="nav">
        <li class="nav-header">MENU NAVIGASI</li>
        <li class="<?= ($menu=='dashboard')?'active':''; ?>">
          <a href="dashboard.html"><i class="ion-ios-pulse-strong"></i><span>Dashboard</span></a>
        </li>

        <!-- Contoh tambahan menu sesuai level -->
        <?php if ($level=='superadmin'): ?>
          <li><a href="petugas/v.html"><i class="fa fa-users bg-blue"></i><span>Data Operator</span></a></li>
        <?php elseif ($level=='user'): ?>
          <li><a href="notaris/v.html"><i class="fa fa-info-circle bg-purple"></i><span>Daftar Notaris</span></a></li>
        <?php endif; ?>

        <li><a href="web/logout.html"><i class="fa fa-sign-out bg-red"></i><span>Keluar</span></a></li>
        <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="ion-ios-arrow-left"></i></a></li>
      </ul>
    </div>
  </div>
</div>
