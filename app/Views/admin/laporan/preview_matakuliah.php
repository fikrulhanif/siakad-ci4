<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<section class="content-header">
    <h1><i class="fa fa-book"></i> Preview Laporan Mata Kuliah</h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/laporan') ?>"><i class="fa fa-file-text"></i> Laporan</a></li>
        <li><a href="<?= site_url('admin/laporan/matakuliah') ?>">Mata Kuliah</a></li>
        <li class="active">Preview</li>
    </ol>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-list"></i> <?= $prodi_text ?></h3>
            <div class="box-tools pull-right">
                <form action="<?= site_url('admin/laporan/print-matakuliah') ?>" method="POST" target="_blank" style="display: inline;">
                    <input type="hidden" name="id_prodi" value="<?= $id_prodi ?>">
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fa fa-print"></i> Cetak Laporan
                    </button>
                </form>
                <a href="<?= site_url('admin/laporan/matakuliah') ?>" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="box-body">
            <?php if (empty($mk)) : ?>
                <div class="alert alert-warning">
                    <i class="fa fa-warning"></i> Tidak ada data mata kuliah untuk prodi yang dipilih.
                </div>
            <?php else : ?>
                <?php
                // Group by semester
                $mkBySemester = [];
                foreach ($mk as $m) {
                    $smt = $m['semester_prodi'] ?? $m['smt'];
                    $mkBySemester[$smt][] = $m;
                }
                ksort($mkBySemester);
                ?>

                <?php foreach ($mkBySemester as $smt => $matakuliah) : ?>
                    <h4 class="text-primary"><b>Semester <?= $smt ?></b></h4>
                    <table class="table table-bordered table-striped">
                        <thead class="bg-gray">
                            <tr>
                                <th width="50" class="text-center">No</th>
                                <th width="120">Kode MK</th>
                                <th>Nama Mata Kuliah</th>
                                <th width="80" class="text-center">SKS</th>
                                <th width="100" class="text-center">Sifat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($matakuliah as $idx => $m) : ?>
                            <tr>
                                <td class="text-center"><?= $idx + 1 ?></td>
                                <td><span class="label label-default"><?= $m['kd_mk'] ?></span></td>
                                <td><?= $m['nama_mk'] ?></td>
                                <td class="text-center"><span class="badge bg-green"><?= $m['sks'] ?></span></td>
                                <td class="text-center">
                                    <span class="badge <?= $m['is_wajib'] == 1 ? 'bg-red' : 'bg-blue' ?>">
                                        <?= $m['is_wajib'] == 1 ? 'Wajib' : 'Pilihan' ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="bg-light-blue">
                            <tr>
                                <td colspan="3" class="text-right"><b>Total SKS Semester <?= $smt ?>:</b></td>
                                <td class="text-center"><b><?= array_sum(array_column($matakuliah, 'sks')) ?> SKS</b></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                    <br>
                <?php endforeach; ?>

                <div class="alert alert-info">
                    <i class="fa fa-info-circle"></i> <b>Total Mata Kuliah:</b> <?= count($mk) ?> | 
                    <b>Total SKS:</b> <?= array_sum(array_column($mk, 'sks')) ?> SKS
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
