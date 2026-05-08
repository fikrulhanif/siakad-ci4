<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<section class="content-header">
    <h1><i class="fa fa-calendar"></i> Preview Laporan Jadwal</h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/laporan') ?>"><i class="fa fa-file-text"></i> Laporan</a></li>
        <li><a href="<?= site_url('admin/laporan/jadwal') ?>">Jadwal</a></li>
        <li class="active">Preview</li>
    </ol>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-list"></i> <?= $prodi ?> - <?= $ta ?></h3>
            <div class="box-tools pull-right">
                <form action="<?= site_url('admin/laporan/print-jadwal') ?>" method="POST" target="_blank" style="display: inline;">
                    <input type="hidden" name="id_prodi" value="<?= $id_prodi ?>">
                    <input type="hidden" name="id_tahun" value="<?= $id_tahun ?>">
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fa fa-print"></i> Cetak Laporan
                    </button>
                </form>
                <a href="<?= site_url('admin/laporan/jadwal') ?>" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="box-body">
            <?php if (empty($jadwal)) : ?>
                <div class="alert alert-warning">
                    <i class="fa fa-warning"></i> Tidak ada data jadwal untuk parameter yang dipilih.
                </div>
            <?php else : ?>
                <?php
                // Group by hari
                $jadwalByHari = [];
                foreach ($jadwal as $j) {
                    $jadwalByHari[$j['hari']][] = $j;
                }
                $urutanHari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                ?>

                <?php foreach ($urutanHari as $hari) : ?>
                    <?php if (isset($jadwalByHari[$hari])) : ?>
                        <h4 class="text-primary"><b><?= $hari ?></b></h4>
                        <table class="table table-bordered table-striped">
                            <thead class="bg-gray">
                                <tr>
                                    <th width="50" class="text-center">No</th>
                                    <th width="120">Kode MK</th>
                                    <th>Mata Kuliah</th>
                                    <th width="60" class="text-center">SKS</th>
                                    <th width="80" class="text-center">Kelas</th>
                                    <th width="120">Waktu</th>
                                    <th width="80">Ruang</th>
                                    <th>Dosen</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($jadwalByHari[$hari] as $idx => $j) : ?>
                                <tr>
                                    <td class="text-center"><?= $idx + 1 ?></td>
                                    <td><span class="label label-default"><?= $j['kd_mk'] ?></span></td>
                                    <td><?= $j['nama_mk'] ?></td>
                                    <td class="text-center"><span class="badge bg-green"><?= $j['sks'] ?></span></td>
                                    <td class="text-center"><span class="badge bg-purple"><?= $j['kelas'] ?></span></td>
                                    <td><?= date('H:i', strtotime($j['jam'])) ?> - <?= date('H:i', strtotime($j['jam_selesai'])) ?></td>
                                    <td class="text-center"><?= $j['ruang'] ?></td>
                                    <td><?= $j['nama_dosen'] ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <br>
                    <?php endif; ?>
                <?php endforeach; ?>

                <div class="alert alert-info">
                    <i class="fa fa-info-circle"></i> <b>Total Jadwal:</b> <?= count($jadwal) ?> Kelas
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
