<?php $items = isset($items) ? $items : []; ?>
<div id="content" class="content">
  <ol class="breadcrumb pull-right">
    <li><a href="<?= site_url('sekretariat_mkn') ?>">Dashboard</a></li>
    <li class="active">Verifikasi</li>
  </ol>
  <h1 class="page-header">Verifikasi Permohonan <small>Tab: <?= html_escape($tab) ?></small></h1>
  <?= $this->session->flashdata('msg') ?>

  <div class="panel panel-inverse">
    <div class="panel-heading"><h4 class="panel-title">Daftar Permohonan</h4></div>
    <div class="panel-body">
      <form class="form-inline m-b-10" method="get">
        <label>Filter:</label>
        <select name="tab" class="form-control input-sm" onchange="this.form.submit()">
          <?php $opt = ['baru'=>'Baru','penyelidikan'=>'Penyelidikan','semua'=>'Semua','ditolak'=>'Ditolak']; ?>
          <?php foreach ($opt as $v=>$l): ?>
            <option value="<?= $v ?>" <?= $tab==$v?'selected':'' ?>><?= $l ?></option>
          <?php endforeach; ?>
        </select>
      </form>

      <div class="table-responsive">
        <table class="table table-bordered table-striped" id="tbl-verifikasi">
          <thead>
            <tr>
              <th>No</th><th>Nama Notaris</th><th>Nomor Akta</th><th>Kronologi</th><th>Lampiran</th><th>Status</th><th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if(empty($items)): ?>
              <tr><td colspan="7" class="text-center text-muted">Belum ada data.</td></tr>
            <?php else: $no=1; foreach($items as $r): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= html_escape($r['nama_notaris']) ?></td>
                <td><?= html_escape($r['no_akta']) ?></td>
                <td><?= html_escape(mb_strimwidth($r['kronologi'],0,80,'...')) ?></td>
                <td>
                  <?php if(!empty($r['lampiran'])): ?>
                    <a class="btn btn-xs btn-default" href="<?= base_url($r['lampiran']) ?>" target="_blank">
                      <i class="fa fa-file-pdf-o"></i> PDF
                    </a>
                  <?php else: ?><span class="text-muted">-</span><?php endif; ?>
                </td>
                <td><span class="label label-info"><?= strtoupper($r['status']) ?></span></td>
                <td>
                  <a href="<?= site_url('sekretariat_mkn/detail/'.$r['id']) ?>" class="btn btn-xs btn-info">
                    <i class="fa fa-eye"></i> Detail
                  </a>
                </td>
              </tr>
            <?php endforeach; endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
$(function(){
  $('#tbl-verifikasi').DataTable({
    pageLength: 10,
    order:[[0,'asc']],
    language:{url:"assets/panel/plugins/DataTables/i18n/Indonesian.json"}
  });
});
</script>
