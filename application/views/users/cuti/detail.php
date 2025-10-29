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
              $level = $this->session->userdata('level');
            ?>

            <div class="table-responsive">
              <table class="table table-bordered table-striped" width="100%">
                <tbody>
                  <tr>
                    <th width="160">Nama Pemohon</th>
                    <th width="1">:</th>
                    <td>
                      <?php
                        $getNamaNotaris = $this->db->get_where('tbl_user', ['id_user' => $query->user_id])->row()->nama_lengkap;
                        echo $getNamaNotaris;
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <th>Alasan</th>
                    <th>:</th>
                    <td><?php echo $query->alasan; ?></td>
                  </tr>
                  <tr>
                    <th>Keterangan</th>
                    <th>:</th>
                    <td><?php echo $query->keterangan; ?></td>
                  </tr>
                  <tr>
                    <th>Tgl Pengajuan</th>
                    <th>:</th>
                    <td>
                      <?php
                        $DateAndTime = $this->Mcrud->tgl_id(date('d-m-Y H:i:s', strtotime($query->created_at)), 'full');
                        $dateOnly = explode(" ", $DateAndTime);
                        echo $dateOnly[0] . " " . $dateOnly[1] . " " . $dateOnly[2];
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <th>Tgl Awal Cuti</th>
                    <th>:</th>
                    <td>
                      <?php
                        $DateAndTime = $this->Mcrud->tgl_id(date('d-m-Y H:i:s', strtotime($query->tgl_awal)), 'full');
                        $dateOnly = explode(" ", $DateAndTime);
                        echo $dateOnly[0] . " " . $dateOnly[1] . " " . $dateOnly[2];
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <th>Tgl Akhir Cuti</th>
                    <th>:</th>
                    <td>
                      <?php
                        $DateAndTime = $this->Mcrud->tgl_id(date('d-m-Y H:i:s', strtotime($query->tgl_akhir)), 'full');
                        $dateOnly = explode(" ", $DateAndTime);
                        echo $dateOnly[0] . " " . $dateOnly[1] . " " . $dateOnly[2];
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <th>Jumlah Cuti (hari)</th>
                    <th>:</th>
                    <td><?php echo $query->jml_hari_cuti . " hari"; ?></td>
                  </tr>

                  <tr>
                    <th>Surat Permohonan Cuti</th>
                    <th>:</th>
                    <td>
                      <?php if (!empty($query->surat_permohonan_cuti)) { ?>
                        <a href="<?php echo base_url($query->surat_permohonan_cuti); ?>" target="_blank" class="btn btn-xs btn-info">
                          <i class="fa fa-download"></i> Lihat File
                        </a>
                      <?php } else { echo "-"; } ?>
                    </td>
                  </tr>

                  <tr>
                    <th>SK Pengangkatan Notaris</th>
                    <th>:</th>
                    <td>
                      <?php if (!empty($query->sk_pengangkatan_notaris)) { ?>
                        <a href="<?php echo base_url($query->sk_pengangkatan_notaris); ?>" target="_blank" class="btn btn-xs btn-info">
                          <i class="fa fa-download"></i> Lihat File
                        </a>
                      <?php } else { echo "-"; } ?>
                    </td>
                  </tr>

                  <tr>
                    <th>Berita Acara Sumpah</th>
                    <th>:</th>
                    <td>
                      <?php if (!empty($query->berita_acara_sumpah)) { ?>
                        <a href="<?php echo base_url($query->berita_acara_sumpah); ?>" target="_blank" class="btn btn-xs btn-info">
                          <i class="fa fa-download"></i> Lihat File
                        </a>
                      <?php } else { echo "-"; } ?>
                    </td>
                  </tr>

                  <tr>
                    <th>Sertifikat Cuti Asli</th>
                    <th>:</th>
                    <td>
                      <?php if (!empty($query->sertifikat_cuti_asli)) { ?>
                        <a href="<?php echo base_url($query->sertifikat_cuti_asli); ?>" target="_blank" class="btn btn-xs btn-info">
                          <i class="fa fa-download"></i> Lihat File
                        </a>
                      <?php } else { echo "-"; } ?>
                    </td>
                  </tr>

                  <tr>
                    <th>Surat Penunjukan Notaris Pengganti</th>
                    <th>:</th>
                    <td>
                      <?php if (!empty($query->surat_penunjukan_notaris_pengganti)) { ?>
                        <a href="<?php echo base_url($query->surat_penunjukan_notaris_pengganti); ?>" target="_blank" class="btn btn-xs btn-info">
                          <i class="fa fa-download"></i> Lihat File
                        </a>
                      <?php } else { echo "-"; } ?>
                    </td>
                  </tr>

                  <!-- Tambahan dari HEAD -->
                  <tr>
                    <th>SK Cuti oleh MPD</th>
                    <th>:</th>
                    <td>
                      <?php if (!empty($query->sk_cuti_bympd)) { ?>
                        <a href="<?php echo base_url($query->sk_cuti_bympd); ?>" target="_blank" class="btn btn-xs btn-info">
                          <i class="fa fa-download"></i> Lihat File
                        </a>
                      <?php } else { echo "-"; } ?>
                    </td>
                  </tr>

                  <tr>
                    <th>Dokumen Pendukung : Voucher Pemesanan, Bukti Bayar PNBP Permohonan Cuti</th>
                    <th>:</th>
                    <td>
                      <?php if (!empty($query->lamp_syarat_cuti)) { ?>
                        <a href="<?php echo base_url($query->lamp_syarat_cuti); ?>" target="_blank" class="btn btn-xs btn-info">
                          <i class="fa fa-download"></i> Lihat File
                        </a>
                      <?php } else { echo "-"; } ?>
                    </td>
                  </tr>

                  <tr>
                    <th>Dokumen Pendukung : Voucher Pemesanan, Bukti Bayar PNBP Notaris Pengganti</th>
                    <th>:</th>
                    <td>
                      <?php if (!empty($query->pnbp_notaris_pengganti)) { ?>
                        <a href="<?php echo base_url($query->pnbp_notaris_pengganti); ?>" target="_blank" class="btn btn-xs btn-info">
                          <i class="fa fa-download"></i> Lihat File
                        </a>
                      <?php } else { echo "Belum diupload"; } ?>
                    </td>
                  </tr>

                </tbody>
              </table>
            </div>

            <hr style="margin-top:0px;">
            <a href="<?php echo strtolower($this->uri->segment(1)); ?>/<?php echo strtolower($this->uri->segment(2)); ?>.html" class="btn btn-default">
              << Kembali
            </a>

            <?php if ($level == 'superadmin') { ?>
              <?php if ($query->status == 'proses') { ?>
                <a href="javascript:;" class="btn btn-primary" title="Konfirmasi" data-toggle="modal" onclick="modal_show(<?php echo $query->id_laporan; ?>);" style="float:right;">
                  <i class="fa fa-file"></i> Konfirmasi
                </a>
              <?php } else { ?>
                <a href="javascript:;" class="btn btn-success" title="Terkonfirmasi" disabled style="float:right;">
                  <i class="fa fa-check"></i> Konfirmasi
                </a>
              <?php } ?>
            <?php } elseif ($level == 'petugas') { ?>
              <a class="btn btn-success" title="Edit" data-toggle="modal" onclick="modal_show(<?php echo $query->id_laporan; ?>);" style="float:right; display:none;">
                <i class="fa fa-pencil"></i> Edit
              </a>
            <?php } ?>

          </div>
        </div>
      </div>
    </div>
    <!-- /dashboard content -->

    <?php $this->load->view('users/laporan/modal_konfirm'); ?>

  </div>
</div>
