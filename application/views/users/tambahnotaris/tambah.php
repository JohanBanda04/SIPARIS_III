<?php
$link1 = strtolower($this->uri->segment(1));
$link2 = strtolower($this->uri->segment(2));
$link3 = strtolower($this->uri->segment(3));
$link4 = strtolower($this->uri->segment(4));
?>
<!-- Main content -->
<div class="content-wrapper">
  <!-- Content area -->
  <div class="content">

    <!-- Dashboard content -->
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title"><?php echo $judul_web; ?></h4>
            </div>
            <div class="panel-body">

                <?php
                echo $this->session->flashdata('msg');
                ?>
                <form class="form-horizontal" action="" data-parsley-validate="true" method="post" enctype="multipart/form-data">
					<div class="form-group">
						<label class="control-label col-lg-3">No. IDN</label>
						<div class="col-lg-9">
						  <input type="text" name="no_idn" class="form-control" value="<?php echo $idn; ?>"
                                 placeholder="ID Registrasi Notaris"
                                 onkeypress="return hanyaAngka(event)" required autofocus onfocus="this.value = this.value;"
                                 readonly>
						</div>
					</div>
                  <div class="form-group">
                    <label class="control-label col-lg-3">Nama</label>
                    <div class="col-lg-9">
                      <input type="text" name="nama" class="form-control" value="" placeholder="Nama" required autofocus onfocus="this.value = this.value;">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-lg-3">No.SK</label>
                    <div class="col-lg-9">
                      <input type="text" name="no_sk" class="form-control" value="" placeholder="No SK/ Tanggal Pengukuhan" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-lg-3">Alamat</label>
                    <div class="col-lg-9">
                      <input type="text" name="alamat_notaris" class="form-control" value="" placeholder="Alamat" required>
                    </div>
                  </div>
                    <div class="form-group">
                        <label class="control-label col-lg-3">Tempat Kedudukan</label>
                        <div class="col-lg-9">
                            <select name="tempat_kedudukan_new" id="tempat_kedudukan_new"
                                    class="form-control default-select2" required>
                                <option value="">-Pilih Tempat Kedudukan-</option>
                                <?php
                                foreach ($getTempatKedudukan->result() as $key=>$tempat) {
                                    ?>
                                    <option >
                                        <?= $tempat->tempat_kedudukan; ?>
                                    </option>
                                    <?php
                                }

                                ?>
                                <option value=""></option>
                            </select>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-3">MPD Penanggung Jawab</label>
                        <div class="col-lg-9">
                            <select name="mpd_penanggung_jawab" id="mpd_penanggung_jawab"
                                    class="form-control default-select2" required>
                                <option value="">-Pilih MPD-</option>
                                <?php
                                foreach ($getMpdAreas->result() as $key=>$mpd) {
                                    $getNamaMpd = $this->db->get_where('tbl_petugas',array('id_petugas'=>$mpd->id_petugas))->row()->nama;
                                    ?>
                                    <option value="<?= $mpd->id_petugas; ?>">
                                        <?= $getNamaMpd; ?>
                                    </option>
                                    <?php
                                }

                                ?>
                                <option value=""></option>
                            </select>

                        </div>
                    </div>
<!--				  <div hidden class="form-group">-->
<!--                    <label class="control-label col-lg-3">Tempat Kedudukan</label>-->
<!--                    <div class="col-lg-9">-->
<!--                      <input type="text" name="tempat_kedudukan" class="form-control" value="" placeholder="Tempat Kedudukan" required>-->
<!--                    </div>-->
<!--                  </div>-->
                  <div class="form-group">
                    <label class="control-label col-lg-3">No. Telp</label>
                    <div class="col-lg-9">
                      <input type="text" name="telpon" class="form-control" value="" placeholder="No. Telepon" onkeypress="return hanyaAngka(event);" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-lg-3">Email</label>
                    <div class="col-lg-9">
                      <input type="email" name="email_notaris" class="form-control" value="" placeholder="Email" required>
                    </div>
                  </div>
                    <div class="form-group">
                        <label class="control-label col-lg-3">Google Drive</label>
                        <div class="col-lg-9">
                            <input type="text" name="google_drive" class="form-control" value="" placeholder="Google Drive Link" >
                        </div>
                    </div>
                  <div class="form-group">
                    <label class="control-label col-lg-3">Username</label>
                    <div class="col-lg-9">
                      <input type="text" name="username" class="form-control" value="" placeholder="Username" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-lg-3">Password</label>
                    <div class="col-lg-9">
                      <input type="password" name="password" class="form-control" value="" placeholder="Password" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-lg-3">Re-Password</label>
                    <div class="col-lg-9">
                      <input type="password" name="password2" class="form-control" value="" placeholder="Konfirmasi Password" required>
                    </div>
                  </div>
                  <hr>
                  <a href="<?php echo $link1; ?>/<?php echo $link2; ?>.html" class="btn btn-default"><< Kembali</a>
                  <button type="submit" name="btnsimpan" class="btn btn-primary" style="float:right;">Simpan</button>
                </form>
            </div>

        </div>
      </div>
    </div>
    <!-- /dashboard content -->
