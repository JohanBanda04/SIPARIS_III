<div id="content" class="content">
    <!-- breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="aph.html">Dashboard APH</a></li>
        <li class="active">Daftar Permohonan</li>
    </ol>

    <!-- page header -->
    <h1 class="page-header">
        Daftar Permohonan
        <?php if (!empty($status_filter)): ?>
            <small>(<?= ucfirst(htmlspecialchars($status_filter)); ?>)</small>
        <?php endif; ?>
    </h1>

    <?php if ($this->session->flashdata('msg')): ?>
        <?= $this->session->flashdata('msg'); ?>
    <?php endif; ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>Permohonan Saya</strong>
        </div>
        <div class="panel-body">
            <?php if (empty($rows)): ?>
                <div class="alert alert-info">
                    Belum ada permohonan untuk kategori ini.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Notaris</th>
                            <th>Nomor Akta</th>
                            <th>Tahapan</th>
                            <th>Status</th>
                            <th>Tgl Pengajuan</th>
                            <th width="12%">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $no = 1; foreach ($rows as $r): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($r->nama_notaris); ?></td>
                                <td><?= htmlspecialchars($r->nomor_akta); ?></td>
                                <td><?= ucfirst(htmlspecialchars($r->tahapan)); ?></td>
                                <td><?= ucfirst(htmlspecialchars($r->status)); ?></td>
                                <td><?= htmlspecialchars($r->tgl_pengajuan); ?></td>
                                <td>
    <a href="<?= site_url('aph/detail/'.$r->id_perkara); ?>" class="btn btn-primary btn-xs">
        Detail
    </a>

    <?php if ($status_filter == 'draft' && $r->status == 'pending'): ?>
        <a href="<?= site_url('aph/edit/'.$r->id_perkara); ?>" class="btn btn-warning btn-xs">
            Edit
        </a>

        <a href="<?= site_url('aph/hapus/'.$r->id_perkara); ?>"
           class="btn btn-danger btn-xs"
           onclick="return confirm('Hapus permohonan ini? Data tidak dapat dikembalikan.');">
            Hapus
        </a>
    <?php endif; ?>
</td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
