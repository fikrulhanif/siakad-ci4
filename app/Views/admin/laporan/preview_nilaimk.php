<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<section class="content-header">
    <h1><i class="fa fa-list-alt"></i> Preview Daftar Nilai</h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/laporan') ?>"><i class="fa fa-file-text"></i> Laporan</a></li>
        <li><a href="<?= site_url('admin/laporan/nilai-mk') ?>">Nilai Matkul</a></li>
        <li class="active">Preview</li>
    </ol>
</section>

<section class="content">
    <!-- Info Mata Kuliah -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-info-circle"></i> Informasi Mata Kuliah</h3>
            <div class="box-tools pull-right">
                <form action="<?= site_url('admin/laporan/print-nilai-mk') ?>" method="POST" target="_blank" style="display: inline;">
                    <input type="hidden" name="id_jadwal" value="<?= $id_jadwal ?>">
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fa fa-print"></i> Cetak Laporan
                    </button>
                </form>
                <a href="<?= site_url('admin/laporan/nilai-mk') ?>" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="150"><b>Kode Mata Kuliah</b></td>
                            <td>: <span class="label label-default" style="font-size: 13px;"><?= $info['kd_mk'] ?></span></td>
                        </tr>
                        <tr>
                            <td><b>Nama Mata Kuliah</b></td>
                            <td>: <?= $info['nama_mk'] ?></td>
                        </tr>
                        <tr>
                            <td><b>SKS</b></td>
                            <td>: <span class="badge bg-green"><?= $info['sks'] ?> SKS</span></td>
                        </tr>
                        <tr>
                            <td><b>Semester</b></td>
                            <td>: <span class="badge bg-blue">Semester <?= $info['smt'] ?></span></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="150"><b>Kelas</b></td>
                            <td>: <span class="badge bg-purple"><?= $info['kelas'] ?></span></td>
                        </tr>
                        <tr>
                            <td><b>Dosen Pengampu</b></td>
                            <td>: <?= $info['nama_dosen'] ?></td>
                        </tr>
                        <tr>
                            <td><b>Tahun Akademik</b></td>
                            <td>: <?= $info['tahun_ajaran'] ?> (<?= $info['semester'] ?>)</td>
                        </tr>
                        <tr>
                            <td><b>Ruang</b></td>
                            <td>: <?= $info['ruang'] ?> | <?= $info['hari'] ?>, <?= date('H:i', strtotime($info['jam'])) ?>-<?= date('H:i', strtotime($info['jam_selesai'])) ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik -->
    <div class="row">
        <div class="col-md-3">
            <div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Mahasiswa</span>
                    <span class="info-box-number"><?= $stats['total_mhs'] ?></span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box bg-green">
                <span class="info-box-icon"><i class="fa fa-check"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Sudah Dinilai</span>
                    <span class="info-box-number"><?= $stats['sudah_dinilai'] ?></span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box bg-yellow">
                <span class="info-box-icon"><i class="fa fa-clock-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Belum Dinilai</span>
                    <span class="info-box-number"><?= $stats['belum_dinilai'] ?></span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box bg-purple">
                <span class="info-box-icon"><i class="fa fa-calculator"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Rata-rata Nilai</span>
                    <span class="info-box-number"><?= $stats['rata_rata'] ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Nilai -->
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-list"></i> Daftar Nilai Mahasiswa</h3>
        </div>
        <div class="box-body">
            <?php if (empty($peserta)) : ?>
                <div class="alert alert-warning">
                    <i class="fa fa-warning"></i> Tidak ada mahasiswa yang mengambil mata kuliah ini.
                </div>
            <?php else : ?>
                <table class="table table-bordered table-striped">
                    <thead class="bg-gray">
                        <tr>
                            <th width="50" class="text-center">No</th>
                            <th width="120">NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th width="150">Program Studi</th>
                            <th width="120" class="text-center">Nilai Angka</th>
                            <th width="120" class="text-center">Nilai Huruf</th>
                            <th width="100" class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($peserta as $idx => $p) : ?>
                        <tr>
                            <td class="text-center"><?= $idx + 1 ?></td>
                            <td><span class="label label-primary"><?= $p['nim'] ?></span></td>
                            <td><?= $p['nama_mhs'] ?></td>
                            <td><?= $p['nama_prodi'] ?></td>
                            <td class="text-center">
                                <?php if ($p['nilai_angka']) : ?>
                                    <span class="badge bg-aqua" style="font-size: 14px;"><?= $p['nilai_angka'] ?></span>
                                <?php else : ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if ($p['nilai_huruf']) : ?>
                                    <?php
                                    $badgeClass = match($p['nilai_huruf']) {
                                        'A' => 'bg-green',
                                        'B' => 'bg-blue',
                                        'C' => 'bg-yellow',
                                        'D' => 'bg-orange',
                                        'E' => 'bg-red',
                                        default => 'bg-gray'
                                    };
                                    ?>
                                    <span class="badge <?= $badgeClass ?>" style="font-size: 16px; padding: 5px 12px;"><?= $p['nilai_huruf'] ?></span>
                                <?php else : ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if ($p['nilai_huruf']) : ?>
                                    <span class="label label-success">Sudah Dinilai</span>
                                <?php else : ?>
                                    <span class="label label-warning">Belum Dinilai</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="alert alert-info">
                    <i class="fa fa-info-circle"></i> 
                    <b>Nilai Tertinggi:</b> <?= $stats['tertinggi'] ?> | 
                    <b>Nilai Terendah:</b> <?= $stats['terendah'] ?> | 
                    <b>Rata-rata:</b> <?= $stats['rata_rata'] ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
