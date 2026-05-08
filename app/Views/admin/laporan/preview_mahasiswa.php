<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<section class="content-header">
    <h1><i class="fa fa-users"></i> Preview Laporan Mahasiswa</h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/laporan') ?>"><i class="fa fa-file-text"></i> Laporan</a></li>
        <li><a href="<?= site_url('admin/laporan/mahasiswa') ?>">Mahasiswa</a></li>
        <li class="active">Preview</li>
    </ol>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-list"></i> <?= $prodi_text ?> - Angkatan <?= $angkatan == 'all' ? 'Semua' : $angkatan ?></h3>
            <div class="box-tools pull-right">
                <form action="<?= site_url('admin/laporan/print-mahasiswa') ?>" method="POST" target="_blank" style="display: inline;">
                    <input type="hidden" name="id_prodi" value="<?= $id_prodi ?>">
                    <input type="hidden" name="angkatan" value="<?= $angkatan ?>">
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fa fa-print"></i> Cetak Laporan
                    </button>
                </form>
                <a href="<?= site_url('admin/laporan/mahasiswa') ?>" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="box-body">
            <?php if (empty($mhs)) : ?>
                <div class="alert alert-warning">
                    <i class="fa fa-warning"></i> Tidak ada data mahasiswa untuk parameter yang dipilih.
                </div>
            <?php else : ?>
                <table class="table table-bordered table-striped">
                    <thead class="bg-gray">
                        <tr>
                            <th width="50" class="text-center">No</th>
                            <th width="120">NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th>Program Studi</th>
                            <th width="100" class="text-center">Angkatan</th>
                            <th width="150">Email</th>
                            <th width="120">No. HP</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mhs as $idx => $m) : ?>
                        <tr>
                            <td class="text-center"><?= $idx + 1 ?></td>
                            <td><span class="label label-primary"><?= $m['nim'] ?></span></td>
                            <td><?= $m['nama_mhs'] ?></td>
                            <td><?= $m['nama_prodi'] ?></td>
                            <td class="text-center"><?= $m['angkatan'] ?></td>
                            <td><?= $m['email'] ?? '-' ?></td>
                            <td><?= $m['no_hp'] ?? '-' ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="bg-light-blue">
                        <tr>
                            <td colspan="7" class="text-center"><b>Total: <?= count($mhs) ?> Mahasiswa</b></td>
                        </tr>
                    </tfoot>
                </table>

                <div class="alert alert-info">
                    <i class="fa fa-info-circle"></i> <b>Total Mahasiswa:</b> <?= count($mhs) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
