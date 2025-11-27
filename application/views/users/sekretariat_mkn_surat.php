<?php
// Expect: $list = array of surat; $jenis, $status (filter)
$list = isset($list) && is_array($list) ? $list : [];
$jenis  = $jenis  ?? '';
$status = $status ?? '';
?>
<div id="content" class="content">
  <ol class="breadcrumb pull-right">
    <li><a href="<?= site_url('sekretariat_mkn') ?>">Dashboard</a></li>
    <li class="active">Manajemen Surat</li>
  </ol>
  <h1 class="page-header">Manajemen Surat</h1>

  <div class="row m-b-10">
    <div class="col-md-12">
      <form class="form-inline" method="get" action="">
        <label class="m-r-10">Jenis:</label>
        <select name="jenis" class="form-control input-sm">
          <option value="">Semua</option>
          <?php
          $optJenis = [
            'baru'=>'Baru',
            'penolakan'=>'Penolakan',
            'pemanggilan_pemeriksaan'=>'Pemanggilan Pemeriksaan',
            'undangan_pemeriksaan_anggota'=>'Undangan Pemeriksaan Anggota',
            'putusan_hasil_pemeriksaan'=>'Putusan Hasil Pemeriksaan',
            'jawaban_ketua_ke_aph'=>'Jawaban Ketua ke APH',
            'putusan_pengadilan_ke_mpd'=>'Putusan Pengadilan ke MPD',
            'keterangan_penjelidikan'=>'Keterangan Penyelidikan',
          ];
          foreach ($optJenis as $val=>$label):
          ?>
            <option value="<?= $val ?>" <?= $jenis===$val?'selected':'' ?>><?= $label ?></option>
          <?php endforeach; ?>
        </select>

        <label class="m-l-15 m-r-10">Status:</label>
        <select name="status" class="form-control input-sm">
          <?php $optStatus = [''=>'Semua','draft'=>'Draft','terkirim'=>'Terkirim','ditolak'=>'Ditolak'];
          foreach ($optStatus as $val=>$label): ?>
            <option value="<?= $val ?>" <?= $status===$val?'selected':'' ?>><?= $label ?></option>
          <?php endforeach; ?>
        </select>

        <button class="btn btn-sm btn-primary m-l-10" type="submit"><i class="fa fa-filter"></i> Terapkan</button>
      </form>
    </div>
  </div>

  <div class="panel panel-inverse">
    <div class="panel-heading">
      <h4 class="panel-title">Daftar Surat</h4>
    </div>
    <div class="panel-body">
      <div class="table-responsive">
        <table id="tbl-surat" class="table table-striped table-bordered">
          <thead>
          <tr>
            <th width="45">No</th>
            <th>No Surat</th>
            <th>Perihal</th>
            <th>Jenis</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th width="170">Lampiran</th>
            <th width="140">Aksi</th>
          </tr>
          </thead>
          <tbody>
          <?php if (empty($list)): ?>
            <tr><td colspan="8" class="text-center text-muted">Belum ada data.</td></tr>
          <?php else: $no=1; foreach ($list as $row): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= html_escape($row['no_surat'] ?? '-') ?></td>
              <td><?= html_escape($row['perihal'] ?? '-') ?></td>
              <td><?= html_escape($row['jenis_surat'] ?? '-') ?></td>
              <td><?= !empty($row['tgl_surat']) ? date('d-m-Y', strtotime($row['tgl_surat'])) : '-' ?></td>
              <td><span class="label label-<?= ($row['status']??'draft')==='terkirim'?'success':(($row['status']??'')==='ditolak'?'danger':'default') ?>">
                    <?= strtoupper(html_escape($row['status'] ?? 'draft')) ?>
                  </span></td>
              <td class="text-center">
                <?php if(!empty($row['lampiran_path'])): ?>
                  <a class="btn btn-xs btn-default" href="<?= base_url(html_escape($row['lampiran_path'])) ?>" target="_blank"><i class="fa fa-file-pdf-o"></i> Unduh</a>
                <?php else: ?>
                  <span class="text-muted">Tidak ada lampiran</span>
                <?php endif; ?>
              </td>
              <td class="text-center">
                <a class="btn btn-xs btn-info" href="<?= site_url('sekretariat_mkn/detail/'.($row['id_perkara']??0)) ?>"><i class="fa fa-eye"></i> Detail</a>
                <a class="btn btn-xs btn-warning" href="<?= site_url('sekretariat_mkn/form_surat/'.($row['id_perkara']??0)) ?>"><i class="fa fa-pencil"></i> Ubah</a>
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
  $('#tbl-surat').DataTable({
    pageLength: 10,
    order: [[4,'desc']],
    language: { url: "assets/panel/plugins/DataTables/i18n/Indonesian.json" }
  });
});
</script>
