<div id="content" class="content">
    <ol class="breadcrumb pull-right">
        <li><a href="<?= site_url('sekretariat_mkn'); ?>">Dashboard Sekretariat</a></li>
        <li class="active">Catatan Baru Hari Ini</li>
    </ol>

    <h1 class="page-header">Perkara dengan Catatan Baru Hari Ini</h1>

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
                    Belum ada perkara yang diperbarui catatannya hari ini.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Nama Notaris</th>
                            <th>Nomor Akta</th>
                            <th>Tahapan</th>
                            <th>Status</th>
                            <th>Terakhir Diupdate</th>
                            <th>Cuplikan Catatan</th>
                            <th width="12%">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $no=1; foreach ($rows as $r): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($r->nama_notaris); ?></td>
                                <td><?= htmlspecialchars($r->nomor_akta); ?></td>
                                <td><?= htmlspecialchars($r->tahapan); ?></td>
                                <td><?= htmlspecialchars($r->status); ?></td>
                                <td><?= htmlspecialchars($r->tgl_update); ?></td>
                                <td style="max-width:280px;">
                                    <?php
                                    $plain = strip_tags($r->catatan);
                                    $snippet = mb_substr($plain, 0, 80);
                                    if (mb_strlen($plain) > 80) {
                                        $snippet .= '...';
                                    }
                                    echo nl2br(htmlspecialchars($snippet));
                                    ?>
                                </td>
                                <td>
                                    <a href="<?= site_url('sekretariat_mkn/detail/'.$r->id_perkara); ?>"
                                       class="btn btn-xs btn-primary">
                                        Detail
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
