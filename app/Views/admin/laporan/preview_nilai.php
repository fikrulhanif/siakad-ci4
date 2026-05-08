<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<section class="content-header">
    <h1><i class="fa fa-trophy"></i> Preview Laporan Prestasi</h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/laporan') ?>"><i class="fa fa-file-text"></i> Laporan</a></li>
        <li><a href="<?= site_url('admin/laporan/nilai') ?>">Prestasi</a></li>
        <li class="active">Preview</li>
    </ol>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-list"></i> <?= $prodi ?> - <?= $ta ?></h3>
            <div class="box-tools pull-right">
                <form action="<?= site_url('admin/laporan/print-nilai') ?>" method="POST" target="_blank" style="display: inline;">
                    <input type="hidden" name="id_prodi" value="<?= $id_prodi ?>">
                    <input type="hidden" name="id_tahun" value="<?= $id_tahun ?>">
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fa fa-print"></i> Cetak Laporan
                    </button>
                </form>
                <a href="<?= site_url('admin/laporan/nilai') ?>" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="box-body">
            <?php if (empty($rekap)) : ?>
                <div class="alert alert-warning">
                    <i class="fa fa-warning"></i> Tidak ada data nilai untuk parameter yang dipilih.
                </div>
            <?php else : ?>
                <table class="table table-bordered table-striped">
                    <thead class="bg-gray">
                        <tr>
                            <th width="50" class="text-center">Rank</th>
                            <th width="120">NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th>Program Studi</th>
                            <th width="100" class="text-center">Angkatan</th>
                            <th width="100" class="text-center">Total SKS</th>
                            <th width="100" class="text-center">IP Semester</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rekap as $idx => $r) : ?>
                        <tr>
                            <td class="text-center">
                                <?php if ($idx == 0) : ?>
                                    <span class="badge bg-yellow" style="font-size: 14px;"><i class="fa fa-trophy"></i> 1</span>
                                <?php elseif ($idx == 1) : ?>
                                    <span class="badge bg-gray" style="font-size: 14px;">2</span>
                                <?php elseif ($idx == 2) : ?>
                                    <span class="badge bg-orange" style="font-size: 14px;">3</span>
                                <?php else : ?>
                                    <?= $idx + 1 ?>
                                <?php endif; ?>
                            </td>
                            <td><span class="label label-primary"><?= $r['nim'] ?></span></td>
                            <td><?= $r['nama_mhs'] ?></td>
                            <td><?= $r['nama_prodi'] ?></td>
                            <td class="text-center"><?= $r['angkatan'] ?></td>
                            <td class="text-center"><span class="badge bg-blue"><?= $r['total_sks'] ?> SKS</span></td>
                            <td class="text-center">
                                <span class="badge <?= $r['ips'] >= 3.5 ? 'bg-green' : ($r['ips'] >= 2.5 ? 'bg-yellow' : 'bg-red') ?>" style="font-size: 14px;">
                                    <?= number_format($r['ips'], 2) ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="alert alert-info">
                    <i class="fa fa-info-circle"></i> <b>Total Mahasiswa:</b> <?= count($rekap) ?> | 
                    <b>Rata-rata IP:</b> <?= number_format(array_sum(array_column($rekap, 'ips')) / count($rekap), 2) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
