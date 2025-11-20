<?php
// Expect: $jadwal = array of agenda sidang/pemeriksaan
$jadwal = isset($jadwal) && is_array($jadwal) ? $jadwal : [];
?>
<div id="content" class="content">
  <ol class="breadcrumb pull-right">
    <li><a href="<?= site_url('sekretariat_mkn') ?>">Dashboard</a></li>
    <li class="active">Penjadwalan</li>
  </ol>
  <h1 class="page-header">Penjadwalan</h1>

  <div class="panel panel-inverse">
    <div class="panel-heading">
      <h4 class="panel-title">Agenda / Kalender</h4>
    </div>
    <div class="panel-body">
      <div class="row m-b-10">
        <div class="col-md-12">
          <form class="form-inline" method="get" action="">
            <label class="m-r-10">Rentang tanggal:</label>
            <input type="text" name="start" class="form-control input-sm" placeholder="dd-mm-yyyy"
                   value="<?= html_escape($this->input->get('start')) ?>">
            <span class="m-l-5 m-r-5">s.d.</span>
            <input type="text" name="end" class="form-control input-sm" placeholder="dd-mm-yyyy"
                   value="<?= html_escape($this->input->get('end')) ?>">
            <button class="btn btn-sm btn-primary m-l-10"><i class="fa fa-filter"></i> Terapkan</button>
          </form>
        </div>
      </div>

      <div class="table-responsive">
        <table id="tbl-jadwal" class="table table-striped table-bordered">
          <thead>
          <tr>
            <th width="45">No</th>
            <th>Tanggal</th>
            <th>Agenda</th>
            <th>Lokasi</th>
            <th>Penanggung Jawab</th>
            <th width="130">Aksi</th>
          </tr>
          </thead>
          <tbody>
          <?php if (empty($jadwal)): ?>
            <tr><td colspan="6" class="text-center text-muted">Tidak ada jadwal.</td></tr>
          <?php else: $no=1; foreach ($jadwal as $row): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= !empty($row['tanggal']) ? date('d-m-Y H:i', strtotime($row['tanggal'])) : '-' ?></td>
              <td><?= html_escape($row['agenda'] ?? '-') ?></td>
              <td><?= html_escape($row['lokasi'] ?? '-') ?></td>
              <td><?= html_escape($row['pic'] ?? '-') ?></td>
              <td class="text-center">
                <a class="btn btn-xs btn-info" href="<?= site_url('sekretariat_mkn/detail/'.($row['id_perkara']??0)) ?>"><i class="fa fa-eye"></i> Detail</a>
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
$(function() {
  $('#tbl-jadwal').DataTable({
    pageLength: 10,
    order: [[1,'asc']],
    language: { url: "assets/panel/plugins/DataTables/i18n/Indonesian.json" }
  });
  // Jika mau, aktifkan datepicker bootstrap sesuai assets header kamu
  $('.form-inline input[name=start], .form-inline input[name=end]').datepicker({format:'dd-mm-yyyy', autoclose:true});
});
</script>
