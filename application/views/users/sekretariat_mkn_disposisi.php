<?php
// Expect: $rows = array of disposisi ke anggota
$rows = isset($rows) && is_array($rows) ? $rows : [];
?>
<div id="content" class="content">
  <ol class="breadcrumb pull-right">
    <li><a href="<?= site_url('sekretariat_mkn') ?>">Dashboard</a></li>
    <li class="active">Disposisi ke Anggota</li>
  </ol>
  <h1 class="page-header">Disposisi ke Anggota</h1>

  <div class="panel panel-inverse">
    <div class="panel-heading">
      <h4 class="panel-title">Daftar Disposisi</h4>
    </div>
    <div class="panel-body">
      <div class="row m-b-10">
        <div class="col-md-12">
          <form class="form-inline" method="get" action="">
            <label class="m-r-10">Status:</label>
            <select name="status" class="form-control input-sm" onchange="this.form.submit()">
              <?php
              $opt = [''=>'Semua','dikirim'=>'Dikirim','diterima'=>'Diterima','diproses'=>'Diproses','selesai'=>'Selesai'];
              $cur = $this->input->get('status') ?? '';
              foreach ($opt as $val=>$label):
              ?>
                <option value="<?= $val ?>" <?= $cur===$val?'selected':'' ?>><?= $label ?></option>
              <?php endforeach; ?>
            </select>
          </form>
        </div>
      </div>

      <div class="table-responsive">
        <table id="tbl-disposisi" class="table table-striped table-bordered">
          <thead>
          <tr>
            <th width="45">No</th>
            <th>No. Perkara</th>
            <th>Perkara</th>
            <th>Anggota Tujuan</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th width="130">Aksi</th>
          </tr>
          </thead>
          <tbody>
          <?php if (empty($rows)): ?>
            <tr><td colspan="7" class="text-center text-muted">Belum ada disposisi.</td></tr>
          <?php else: $no=1; foreach ($rows as $row): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= html_escape($row['no_perkara'] ?? '-') ?></td>
              <td><?= html_escape($row['judul_perkara'] ?? '-') ?></td>
              <td><?= html_escape($row['anggota_nama'] ?? '-') ?></td>
              <td><?= !empty($row['tgl_disposisi']) ? date('d-m-Y', strtotime($row['tgl_disposisi'])) : '-' ?></td>
              <td>
                <?php $st = strtolower($row['status'] ?? 'dikirim'); ?>
                <span class="label label-<?= $st==='selesai'?'success':($st==='diproses'?'warning':'info') ?>">
                  <?= strtoupper(html_escape($st)) ?>
                </span>
              </td>
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
  $('#tbl-disposisi').DataTable({
    pageLength: 10,
    order: [[4,'desc']],
    language: { url: "assets/panel/plugins/DataTables/i18n/Indonesian.json" }
  });
});
</script>
