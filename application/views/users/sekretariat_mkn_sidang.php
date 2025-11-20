<div id="content" class="content">
    <ol class="breadcrumb pull-right">
        <li><a href="<?= site_url('sekretariat_mkn'); ?>">Dashboard Sekretariat</a></li>
        <li class="active">Perkara Tahap Sidang</li>
    </ol>

    <h1 class="page-header">Perkara Tahap Sidang</h1>

    <?php if ($this->session->flashdata('msg')): ?>
        <?= $this->session->flashdata('msg'); ?>
    <?php endif; ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>Daftar Perkara</strong>
        </div>
        <div class="panel-body">
            <?php if (empty($rows)): ?>
                <div class="alert alert-info">
                    Belum ada perkara di tahap sidang.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Notaris</th>
                            <th>Nomor Akta</th>
                            <th>Tgl Pengajuan</th>
                            <th>Status</th>
                            <th width="20%">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $no=1; foreach ($rows as $r): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($r->nama_notaris); ?></td>
                                <td><?= htmlspecialchars($r->nomor_akta); ?></td>
                                <td><?= htmlspecialchars($r->tgl_pengajuan); ?></td>
                                <td><?= ucfirst(htmlspecialchars($r->status)); ?></td>
                                <td>
                                    <a href="<?= site_url('sekretariat_mkn/detail/'.$r->id_perkara); ?>"
                                       class="btn btn-primary btn-xs">
                                        Detail
                                    </a>
                                    <a href="<?= site_url('sekretariat_mkn/buat_putusan/'.$r->id_perkara); ?>"
                                       class="btn btn-success btn-xs">
                                        Buat Putusan
                                    </a>
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
