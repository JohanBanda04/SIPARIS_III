<!DOCTYPE html>
<?php
$cek = $user->row();
$nama = $cek->nama_lengkap;
$username = $cek->username;

$level = $cek->level;
$foto = "img/user/user-default.jpg";
if ($level == 'user') {
    $d_k = $this->db->get_where('tbl_data_user', array('id_user' => $cek->id_user))->row();
    $foto_k = $d_k->foto;
    if ($foto_k != '' && file_exists("$foto_k")) {
        $foto = $foto_k;
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
    <meta content="<?php echo $this->Mcrud->judul_web(); ?>" name="description"/>
    <meta content="CV. Esotechno" name="author"/>
    <meta name="keywords" content="CV. Esotechno, <?php echo $this->Mcrud->judul_web(); ?>">
    <base href="<?php echo base_url(); ?>"/>
    <link rel="shortcut icon" href="assets/favicon.png" type="image/x-icon"/>

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="assets/panel/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet"/>
    <link href="assets/panel/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="assets/panel/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
    <link href="assets/panel/plugins/ionicons/css/ionicons.min.css" rel="stylesheet"/>
    <link href="assets/panel/css/animate.min.css" rel="stylesheet"/>
    <link href="assets/panel/css/style.min.css" rel="stylesheet"/>
    <link href="assets/panel/css/style-responsive.min.css" rel="stylesheet"/>
    <link href="assets/panel/css/theme/default.css" rel="stylesheet" id="theme"/>
    <link href="assets/panel/css/style-gue.css" rel="stylesheet">
    <!-- ================== END BASE CSS STYLE ================== -->

    <!-- ================== BEGIN PAGE LEVEL CSS STYLE ================== -->
    <link href="assets/panel/plugins/jquery-jvectormap/jquery-jvectormap.css" rel="stylesheet"/>
    <link href="assets/panel/plugins/bootstrap-calendar/css/bootstrap_calendar.css" rel="stylesheet"/>
    <link href="assets/panel/plugins/gritter/css/jquery.gritter.css" rel="stylesheet"/>
    <link href="assets/panel/plugins/morris/morris.css" rel="stylesheet"/>
    <!-- ================== END PAGE LEVEL CSS STYLE ================== -->

    <!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
    <link href="assets/panel/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet"/>
    <link href="assets/panel/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet"/>
    <link href="assets/panel/plugins/parsley/src/parsley.css" rel="stylesheet"/>
    <!-- ================== END PAGE LEVEL STYLE ================== -->

    <!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
    <link href="assets/panel/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet"/>
    <link href="assets/panel/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.css" rel="stylesheet"/>
    <link href="assets/panel/plugins/ionRangeSlider/css/ion.rangeSlider.css" rel="stylesheet"/>
    <link href="assets/panel/plugins/ionRangeSlider/css/ion.rangeSlider.skinNice.css" rel="stylesheet"/>
    <link href="assets/panel/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet"/>
    <link href="assets/panel/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet"/>
    <link href="assets/panel/plugins/password-indicator/css/password-indicator.css" rel="stylesheet"/>
    <link href="assets/panel/plugins/bootstrap-combobox/css/bootstrap-combobox.css" rel="stylesheet"/>
    <link href="assets/panel/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet"/>
    <link href="assets/panel/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet"/>
    <link href="assets/panel/plugins/jquery-tag-it/css/jquery.tagit.css" rel="stylesheet"/>
    <link href="assets/panel/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet"/>
    <link href="assets/panel/plugins/select2/dist/css/select2.min.css" rel="stylesheet"/>
    <link href="assets/panel/plugins/bootstrap-eonasdan-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet"/>
    <link href="assets/panel/plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css" rel="stylesheet"/>
    <link href="assets/panel/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker.css" rel="stylesheet"/>
    <link href="assets/panel/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker-fontawesome.css" rel="stylesheet"/>
    <link href="assets/panel/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker-glyphicons.css" rel="stylesheet"/>
    <!-- ================== END PAGE LEVEL STYLE ================== -->

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="assets/panel/plugins/pace/pace.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- ================== END BASE JS ================== -->

    <link rel="stylesheet" type="text/css" href="assets/fancybox/jquery.fancybox.css">
    <link rel="stylesheet" type="text/css" href="assets/mycss/custom-tabs.css">
    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/fancybox/jquery.fancybox.js"></script>

    <!-- ====== Small-Box styling (mimic AdminLTE, tidak ganggu Color Admin) ====== -->
    <style>
      .small-box{
        border-radius:10px; position:relative; display:block; margin-bottom:20px; overflow:hidden; color:#fff;
        box-shadow:0 8px 22px rgba(0,0,0,.08), 0 4px 8px rgba(0,0,0,.06); transition:transform .15s, box-shadow .2s;
      }
      .small-box:hover{ transform:translateY(-2px); box-shadow:0 10px 26px rgba(0,0,0,.12), 0 6px 12px rgba(0,0,0,.08); }
      .small-box>.inner{ padding:16px 16px 14px 16px; position:relative; z-index:2; }
      .small-box h3{ font-size:34px; font-weight:800; margin:0 0 8px; letter-spacing:.2px; line-height:1; text-shadow:0 1px 0 rgba(0,0,0,.08); }
      .small-box p{ font-size:15px; margin:0; opacity:.95; }
      .small-box .icon{ position:absolute; right:12px; top:-6px; z-index:1; font-size:74px; opacity:.18; transition:opacity .2s, transform .2s; }
      .small-box:hover .icon{ opacity:.22; transform:scale(1.04); }
      .small-box .small-box-footer{
        display:block; background:rgba(0,0,0,.08); color:rgba(255,255,255,.95); padding:7px 10px; text-align:center;
        text-decoration:none; font-weight:600; letter-spacing:.2px; border-top:1px solid rgba(255,255,255,.08); position:relative; z-index:2;
      }
      .small-box .small-box-footer:hover{ background:rgba(0,0,0,.12); color:#fff; }

      /* Palet warna glossy */
      .bg-aqua{        background:linear-gradient(135deg,#00c0ef 0%,#00a0c8 100%)!important; }
      .bg-green{       background:linear-gradient(135deg,#00a65a 0%,#028a4b 100%)!important; }
      .bg-yellow{      background:linear-gradient(135deg,#f39c12 0%,#d58512 100%)!important; }
      .bg-red{         background:linear-gradient(135deg,#dd4b39 0%,#c14132 100%)!important; }
      .bg-blue{        background:linear-gradient(135deg,#0073b7 0%,#005e97 100%)!important; }
      .bg-light-blue{  background:linear-gradient(135deg,#3c8dbc 0%,#2d6f97 100%)!important; }
      .bg-orange{      background:linear-gradient(135deg,#ff851b 0%,#e26b0a 100%)!important; }
      .bg-purple{      background:linear-gradient(135deg,#605ca8 0%,#4d4891 100%)!important; }
      .bg-maroon{      background:linear-gradient(135deg,#d81b60 0%,#b81651 100%)!important; }

      /* Khusus: hijau aktif (sebelumnya abu-abu di tema) */
      .bg-green-active,
      .small-box.bg-green-active{
        background:linear-gradient(135deg,#00b86b 0%,#009c56 50%,#007d44 100%)!important;
        color:#fff!important; box-shadow:0 6px 18px rgba(0,128,64,.25);
      }
      .small-box.bg-green-active:hover{
        background:linear-gradient(135deg,#00c878 0%,#00a65a 60%,#008a4b 100%)!important;
        box-shadow:0 8px 22px rgba(0,128,64,.35);
      }

      @media (max-width:991px){ .small-box h3{font-size:30px;} .small-box .icon{font-size:64px; right:10px; top:-2px;} }
      @media (max-width:767px){ .small-box h3{font-size:28px;} .small-box .icon{font-size:58px; right:8px; top:0;} }
    </style>
</head>
<body>

<!-- begin #page-loader -->
<div id="page-loader" class="fade in"><span class="spinner"></span></div>
<!-- end #page-loader -->

<!-- begin #page-container -->
<div id="page-container" class="fade page-sidebar-fixed page-header-fixed in">
    <!-- begin #header -->
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
                    <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle icon" aria-expanded="false">
                        <i class="ion-ios-bell"></i>
                        <span class="label" id="jml_notif_bell">0</span>
                    </a>
                    <ul class="dropdown-menu media-list pull-right animated fadeInDown" id="notif_bell"></ul>
                </li>
                <li class="dropdown navbar-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="user-image online"><img src="<?= $foto; ?>" alt=""/></span>
                        <span class="hidden-xs"><?= ucwords($nama); ?></span> <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu animated fadeInLeft">
                        <li class="arrow"></li>
                        <li<?= ($menu=='profile' ? " class='active'" : ""); ?>><a href="profile.html"><?= ($level=='user' ? "Lengkapi " : ""); ?>Profile</a></li>
                        <li<?= ($menu=='ubah_pass' ? " class='active'" : ""); ?>><a href="ubah_pass.html">Ubah Password</a></li>
                        <?php if ($this->session->userdata('level') == "notaris"): ?>
                          <li<?= ($menu=='dossier_pribadi' ? " class='active'" : ""); ?>><a href="users/dossier_pribadi.html">Dossier Pribadi</a></li>
                        <?php endif; ?>
                        <li class="divider"></li>
                        <li><a href="web/logout.html">Keluar</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <!-- end #header -->

    <!-- begin #sidebar -->
    <div id="sidebar" class="sidebar">
        <div data-scrollbar="true" data-height="100%">
            <!-- begin sidebar user -->
            <ul class="nav">
                <li class="nav-profile">
                    <div class="image"><a href="profile"><img src="<?= $foto; ?>" alt=""/></a></div>
                    <div class="info"><?= ucwords($nama); ?><small>@<?= strtolower($username); ?></small></div>
                </li>
            </ul>
            <!-- end sidebar user -->

            <!-- begin sidebar nav -->
            <ul class="nav">
                <li class="nav-header">MENU NAVIGASI</li>

                <?php
                // Tentukan link dashboard sesuai level pengguna (tanpa query ulang)
                switch ($level) {
                    case 'sekretariat_mkn':
                        $dashboard_link = base_url('sekretariat_mkn');
                        break;
                    case 'anggota_mkn':
                        $dashboard_link = base_url('anggota_mkn');
                        break;
                    case 'aph':
                        $dashboard_link = base_url('aph');
                        break;
                    default:
                        $dashboard_link = base_url('dashboard.html');
                        break;
                }
                ?>
                <li class="<?= (($menu=='users' && $sub_menu=='') || $menu=='dashboard') ? 'active' : ''; ?>">
                    <a href="<?= $dashboard_link; ?>">
                        <i class="ion-ios-pulse-strong"></i> <span>Dashboard</span>
                    </a>
                </li>

                <!-- MENU KHUSUS APH -->
                <?php if ($level == 'aph'): ?>
                  <li <?= ($menu=='aph' && $sub_menu=='tambah_permohonan') ? "class='active'" : ""; ?>>
                    <a href="<?= base_url('aph/tambah_permohonan.html'); ?>">
                      <div class="icon-img"><i class="fa fa-plus-circle bg-blue"></i></div>
                      <span>Tambah Permohonan</span>
                    </a>
                  </li>
                <?php endif; ?>
                <!-- AKHIR MENU KHUSUS APH -->

                <!-- ===== MENU SUPERADMIN (biarkan seperti semula) ===== -->
                <?php if ($level == 'superadmin'): ?>
                  <li <?= ($menu=='petugas') ? "class='active'" : ""; ?>>
                    <a href="petugas/v.html"><div class="icon-img"><i class="fa fa-balance-scale bg-blue"></i></div><span>Operator</span></a>
                  </li>
                  <li <?= ($menu=='tambahnotaris') ? "class='active'" : ""; ?>>
                    <a href="tambahnotaris/v.html"><div class="icon-img"><i class="fa fa-user-plus bg-purple"></i></div><span>Reg. Notaris</span></a>
                  </li>
                  <li <?= ($menu=='users' && $sub_menu=='v') ? "class='active'" : ""; ?>>
                    <a href="users/v.html"><div class="icon-img"><i class="fa fa-users bg-orange"></i></div><span>Masyarakat Terdaftar</span></a>
                  </li>
                  <li <?= ($menu=='pengaduan' && $sub_menu=='v') ? "class='active'" : ""; ?>>
                    <a href="pengaduan/v.html"><div class="icon-img"><i class="fa fa-comments bg-blue"></i></div><span>Aduan Masyarakat</span></a>
                  </li>
                  <li <?= ($menu=='notaris') ? "class='active'" : ""; ?>>
                    <a href="notaris/v.html"><div class="icon-img"><i class="fa fa-user-circle bg-purple"></i></div><span>Daftar Notaris</span></a>
                  </li>
                  <li <?= ($menu=='laporan' && $sub_menu=='v') ? "class='active'" : ""; ?>>
                    <a href="laporan/v.html"><div class="icon-img"><i class="fa fa-file-text bg-green"></i></div><span>SLaporan Notaris</span></a>
                  </li>
                  <li <?= ($menu=='cuti' && $sub_menu=='v') ? "class='active'" : ""; ?>>
                    <a href="cuti/v.html"><div class="icon-img"><i class="fa fa-umbrella bg-blue"></i></div><span>Permohonan Cutis</span></a>
                  </li>
                  <li <?= ($menu=='persuratan' && $sub_menu=='v') ? "class='active'" : ""; ?>>
                    <a href="persuratan/v.html"><div class="icon-img"><i class="fa fa-envelope bg-green" style="background-color:red!important;"></i></div><span>PPengaduan</span></a>
                  </li>
                  <li <?= ($menu=='laporaduan' && $sub_menu=='v') ? "class='active'" : ""; ?>>
                    <a href="laporaduan/v.html"><div class="icon-img"><i class="fa fa-bullhorn bg-red" style="background-color:#e509ff!important;"></i></div><span>Laporan Aduanm</span></a>
                  </li>
                  <li class="nav-header"></li>
                  <li <?= ($menu=='slide') ? "class='active'" : ""; ?>>
                    <a href="slide/v.html"><div class="icon-img"><i class="fa fa-newspaper-o bg-yellow"></i></div><span>Atur Informasi Publik</span></a>
                  </li>
                  <li class="has-sub <?= ($menu=='kategori') ? 'active' : ''; ?>">
                    <a href="javascript:;"><b class="caret pull-right"></b><i class="fa fa-cogs bg-gray"></i><span>Atur Kategori Aduan</span></a>
                    <ul class="sub-menu">
                      <li <?= ($menu=='kategori' && $sub_menu=='v') ? "class='active'" : ""; ?>><a href="kategori/v.html">Kategori Aduan</a></li>
                      <li <?= ($menu=='kategori' && $sub_menu=='sub') ? "class='active'" : ""; ?>><a href="kategori/sub.html">Sub Kategori</a></li>
                    </ul>
                  </li>
                  <li class="has-sub <?= ($menu=='kategori_lap') ? 'active' : ''; ?>">
                    <a href="javascript:;"><b class="caret pull-right"></b><i class="fa fa-cogs bg-gray"></i><span>Atur Kategori Laporan</span></a>
                    <ul class="sub-menu">
                      <li <?= ($menu=='kategori_lap' && $sub_menu=='v') ? "class='active'" : ""; ?>><a href="kategori_lap/v.html">Kategori Laporan</a></li>
                      <li <?= ($menu=='kategori_lap' && $sub_menu=='sub') ? "class='active'" : ""; ?>><a href="kategori_lap/sub.html">Sub Kategori</a></li>
                    </ul>
                  </li>
                <?php endif; ?>
                <!-- ===== akhir superadmin ===== -->

                <!-- MENU PETUGAS -->
                <?php if ($level == 'petugas'): ?>
                  <li <?= ($menu=='users' && $sub_menu=='v') ? "class='active'" : ""; ?>>
                    <a href="users/v.html"><div class="icon-img"><i class="fa fa-users bg-orange"></i></div><span>Data Masyarakat</span></a>
                  </li>
                  <li <?= ($menu=='pengaduan' && $sub_menu=='v') ? "class='active'" : ""; ?>>
                    <a href="pengaduan/v.html"><div class="icon-img"><i class="fa fa-comments bg-blue"></i></div><span>Aduan Masyarakat</span></a>
                  </li>
                  <li <?= ($menu=='notaris') ? "class='active'" : ""; ?>>
                    <a href="notaris/v.html"><div class="icon-img"><i class="fa fa-user-circle bg-purple"></i></div><span>Data Notaris</span></a>
                  </li>
                  <li <?= ($menu=='laporan' && $sub_menu=='v') ? "class='active'" : ""; ?>>
                    <a href="laporan/v.html"><div class="icon-img"><i class="fa fa-file-text bg-yellow"></i></div><span>Laporan Notaris</span></a>
                  </li>
                <?php endif; ?>
                <!-- akhir PETUGAS -->

                <!-- MENU USER -->
                <?php if ($level == 'user'): ?>
                  <li <?= ($menu=='pengaduan' && $sub_menu=='v') ? "class='active'" : ""; ?>>
                    <a href="pengaduan/v.html"><div class="icon-img"><i class="fa fa-comments bg-blue"></i></div><span>Pengaduan</span></a>
                  </li>
                  <li class="nav-header"></li>
                  <li <?= ($menu=='notaris') ? "class='active'" : ""; ?>>
                    <a href="notaris/v.html"><div class="icon-img"><i class="fa fa-info-circle bg-purple"></i></div><span>Daftar Notaris-NTB</span></a>
                  </li>
                <?php endif; ?>
                <!-- akhir USER -->

                <!-- Menu umum -->
                <li <?= ($menu=='laporaduan' && $sub_menu=='v') ? "class='active'" : ""; ?>>
                  <a href="laporaduan/v.html"><div class="icon-img"><i class="fa fa-bullhorn bg-red" style="background-color:#e509ff!important;"></i></div><span>Laporan Aduanm</span></a>
                </li>

                <li <?= ($menu=='cuti' && $sub_menu=='v') ? "class='active'" : ""; ?>>
                  <?php $display = ($level=="aph" || $level=="user") ? 'display: none;' : ''; ?>
                  <a style="<?= $display; ?>" href="cuti/v.html"><div class="icon-img"><i class="fa fa-umbrella bg-blue"></i></div><span>Permohonan Cuti</span></a>
                </li>
                <!-- akhir umum -->

                <!-- AKHIR MENU NOTARIS -->
                <?php if ($level == 'notaris'): ?>
                  <li <?= ($menu=='laporan' && $sub_menu=='v') ? "class='active'" : ""; ?>>
                    <a href="laporan/v.html"><div class="icon-img"><i class="fa fa-file-text bg-blue"></i></div><span>LAPORANnn</span></a>
                  </li>
                  <li>
                    <?php
                      $id_user = $this->session->userdata('id_user');
                      $row = $this->db->get_where('tbl_gdrive', array('user_id' => $id_user))->row();
                      $getLinkGdrive = $row ? $row->link_gdrive : null;
                      $href = !empty($getLinkGdrive) ? $getLinkGdrive : '#';
                      $target = !empty($getLinkGdrive) ? 'target="_blank"' : '';
                      $class  = !empty($getLinkGdrive) ? '' : 'disabled';
                    ?>
                    <style>.disabled{pointer-events:none;opacity:.5;cursor:not-allowed;}</style>
                    <a href="<?= $href; ?>" <?= $target; ?> class="<?= $class; ?>">
                      <div class="icon-img"><i class="fa fa-google bg-orange"></i></div><span>Penyimpanan</span>
                    </a>
                  </li>
                <?php endif; ?>
                <!-- akhir NOTARIS -->

                <li class="nav-header"></li>
                <li>
                  <a href="web/logout.html"><div class="icon-img"><i class="fa fa-sign-out bg-red"></i></div><span>Keluar</span></a>
                </li>

                <!-- begin sidebar minify button -->
                <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="ion-ios-arrow-left"></i> <span>Kecilkan</span></a></li>
                <!-- end sidebar minify button -->
            </ul>
            <!-- end sidebar nav -->
        </div>
    </div>
    <div class="sidebar-bg"></div>
    <!-- end #sidebar -->
