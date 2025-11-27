<?php
// ==== MODE FORM (CREATE / EDIT) ====

// default: create
$mode    = isset($mode) ? $mode : 'create';
$is_edit = ($mode === 'edit' && !empty($d));

// tentukan URL action
$action_url = $is_edit
    ? site_url('aph/update_pengajuan/'.$d->id_perkara)
    : site_url('aph/simpan_pengajuan');

// nilai default untuk form (kalau edit diisi dari $d, kalau create kosong)
$val_nama_notaris   = $is_edit ? $d->nama_notaris   : '';
$val_nomor_akta     = $is_edit ? $d->nomor_akta     : '';
$val_alamat_notaris = $is_edit ? $d->alamat_notaris : '';
$val_kronologi      = $is_edit ? $d->kronologi      : '';
?>

<div class="container">
    <h3 style="margin-top:10px;">
        <?= $is_edit ? 'Edit Pengajuan Perkara (APH)' : 'Form Pengajuan Perkara (APH)'; ?>
    </h3>

    <?php if($this->session->flashdata('msg')): ?>
        <?= $this->session->flashdata('msg'); ?>
    <?php endif; ?>

    <div class="panel panel-default">
        <div class="panel-body">
            <form action="<?= $action_url; ?>" method="post" enctype="multipart/form-data" novalidate>

                <?php // CSRF (jika diaktifkan di config)
                if (isset($this->security) && method_exists($this->security, 'get_csrf_token_name')): ?>
                    <input type="hidden"
                           name="<?= $this->security->get_csrf_token_name(); ?>"
                           value="<?= $this->security->get_csrf_hash(); ?>">
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Notaris <span class="text-danger">*</span></label>
                            <select name="id_data_notaris" id="id_data_notaris" class="form-control select2-notaris" required>
                                <option value="">-- Pilih Notaris --</option>
                                <?php if (!empty($list_notaris)): ?>
                                    <?php foreach ($list_notaris as $n): ?>
                                        <?php
                                            $selected = ($is_edit && $val_nama_notaris == $n->nama) ? 'selected' : '';
                                        ?>
                                        <option
                                            value="<?= htmlspecialchars($n->id_data_notaris, ENT_QUOTES, 'UTF-8'); ?>"
                                            data-alamat="<?= htmlspecialchars($n->alamat_notaris . ' - ' . $n->tempat_kedudukan, ENT_QUOTES, 'UTF-8'); ?>"
                                            <?= $selected; ?>>
                                            <?= htmlspecialchars($n->nama . ' - ' . $n->tempat_kedudukan, ENT_QUOTES, 'UTF-8'); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nomor Akta (opsional)</label>
                            <input type="text"
                                   name="nomor_akta"
                                   class="form-control"
                                   placeholder="Contoh: AKT-001/2025"
                                   value="<?= htmlspecialchars($val_nomor_akta); ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Alamat Notaris <span class="text-danger">*</span></label>
                    <textarea name="alamat_notaris" id="alamat_notaris" class="form-control" rows="3" required
                              placeholder="Alamat lengkap notaris"><?= htmlspecialchars($val_alamat_notaris); ?></textarea>
                </div>

                <div class="form-group">
                    <label>Kronologi <span class="text-danger">*</span></label>
                    <textarea name="kronologi" class="form-control" rows="5" required
                              placeholder="Uraikan kronologi singkat"><?= htmlspecialchars($val_kronologi); ?></textarea>
                </div>

                <div class="form-group">
                    <label>Lampiran (PDF/JPG/PNG, maks 4MB)</label>

                    <?php if ($is_edit && !empty($d->lampiran_surat)): ?>
                        <p>
                            Lampiran saat ini:
                            <a href="<?= base_url($d->lampiran_surat); ?>" target="_blank">
                                Lihat / Download
                            </a>
                        </p>
                        <p class="text-muted">
                            Biarkan kosong jika tidak ingin mengganti lampiran.
                        </p>
                    <?php endif; ?>

                    <input type="file" name="lampiran" class="form-control"
                           accept=".pdf,.jpg,.jpeg,.png">
                    <?php if (!$is_edit): ?>
                        <p class="help-block">Opsional—unggah surat/berkas pendukung.</p>
                    <?php endif; ?>
                </div>

                <div class="text-right">
                    <?php if ($is_edit): ?>
                        <a href="<?= site_url('aph/permohonan?status=draft'); ?>" class="btn btn-default">
                            Batal
                        </a>
                    <?php else: ?>
                        <a href="<?= site_url('aph/create'); ?>" class="btn btn-default">
                            Reset
                        </a>
                    <?php endif; ?>

                    <button type="submit" class="btn btn-primary">
                        <?= $is_edit ? 'Simpan Perubahan' : 'Simpan Pengajuan'; ?>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php // Opsional: jika nanti kamu kirim $riwayat dari controller, table ini akan muncul ?>
    <?php if (!empty($riwayat) && is_array($riwayat)): ?>
        <h4>Riwayat Pengajuan Saya</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Notaris</th>
                    <th>Nomor Akta</th>
                    <th>Tahapan</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Lampiran</th>
                </tr>
                </thead>
                <tbody>
                <?php $no=1; foreach($riwayat as $r): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= html_escape($r->nama_notaris); ?></td>
                        <td><?= html_escape($r->nomor_akta); ?></td>
                        <td><?= html_escape($r->tahapan); ?></td>
                        <td><?= html_escape($r->status); ?></td>
                        <td><?= html_escape($r->tgl_pengajuan); ?></td>
                        <td>
                            <?php if(!empty($r->lampiran_surat)): ?>
                                <a class="btn btn-xs btn-default" target="_blank"
                                   href="<?= base_url($r->lampiran_surat); ?>">Lihat</a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <script>
      $(document).ready(function() {
        var $selectNotaris = $('.select2-notaris');

        // Aktifkan Select2
        $selectNotaris.select2({
          placeholder: 'Cari / pilih notaris',
          allowClear: true,
          width: '100%'
        });

        // Fungsi untuk sinkron alamat
        function syncAlamatNotaris() {
          var alamat = $selectNotaris.find('option:selected').data('alamat') || '';
          // Kalau mode edit dan alamat sudah ada, biarkan user bisa edit manual.
          // Tapi kalau kosong, isi otomatis dari data-notaris.
          if ($('#alamat_notaris').val().trim() === '' || <?= $is_edit ? 'false' : 'true'; ?>) {
              $('#alamat_notaris').val(alamat);
          }
        }

        // Saat pilihan berubah, update textarea alamat
        $selectNotaris.on('change', syncAlamatNotaris);

        // Sinkron saat load (biar edit juga rapih)
        syncAlamatNotaris();
      });
    </script>
</div>
