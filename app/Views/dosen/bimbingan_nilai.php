<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<section class="content-header">
    <h1><i class="fa fa-line-chart"></i> Kartu Hasil Studi (KHS)</h1>
    <small>Riwayat Akademik Mahasiswa</small>
</section>

<section class="content">
    <!-- Profile Card -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-user"></i> Profil Mahasiswa</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="150"><b>NIM</b></td>
                            <td>: <span class="label label-primary" style="font-size: 13px;"><?= $mhs['nim'] ?></span></td>
                        </tr>
                        <tr>
                            <td><b>Nama Lengkap</b></td>
                            <td>: <?= $mhs['nama_mhs'] ?></td>
                        </tr>
                        <tr>
                            <td><b>Program Studi</b></td>
                            <td>: <?= $mhs['nama_prodi'] ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="150"><b>Angkatan</b></td>
                            <td>: <?= $mhs['angkatan'] ?></td>
                        </tr>
                        <tr>
                            <td><b>IPK</b></td>
                            <td>: <span class="badge <?= $ipk >= 3.5 ? 'bg-green' : ($ipk >= 2.5 ? 'bg-yellow' : 'bg-red') ?>" style="font-size: 14px;"><?= $ipk ?></span></td>
                        </tr>
                        <tr>
                            <td><b>Total SKS Lulus</b></td>
                            <td>: <span class="badge bg-aqua" style="font-size: 14px;"><?= $totalSks ?> / 144 SKS</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-line-chart"></i> Progress Studi</h3>
                </div>
                <div class="box-body">
                    <div class="progress" style="height: 30px;">
                        <?php
                        $persen = ($totalSks / 144) * 100;
$color = $persen >= 75 ? 'success' : ($persen >= 50 ? 'warning' : 'danger');
?>
                        <div class="progress-bar progress-bar-<?= $color ?>" style="width: <?= $persen ?>%">
                            <span style="font-size: 14px; font-weight: bold;"><?= number_format($persen, 1) ?>% (<?= $totalSks ?> / 144 SKS)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Nilai per Semester -->
    <?php foreach ($nilai as $n) : ?>
    <div class="box box-solid">
        <div class="box-header with-border" style="background-color: #3c8dbc; color: white;">
            <h3 class="box-title"><i class="fa fa-graduation-cap"></i> <?= $n['semester'] ?></h3>
            <div class="box-tools pull-right">
                <span class="badge bg-navy">IP: <?= $n['ip'] ?></span>
                <span class="badge bg-green"><?= $n['total_sks'] ?> SKS</span>
            </div>
        </div>
        <div class="box-body no-padding">
            <table class="table table-striped table-bordered">
                <thead class="bg-gray">
                    <tr>
                        <th width="50" class="text-center">No</th>
                        <th width="120">Kode MK</th>
                        <th>Mata Kuliah</th>
                        <th width="80" class="text-center">SKS</th>
                        <th width="100" class="text-center">Nilai Angka</th>
                        <th width="100" class="text-center">Nilai Huruf</th>
                        <th width="80" class="text-center">Bobot</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($n['detail'] as $idx => $d) : ?>
                    <tr>
                        <td class="text-center"><?= $idx + 1 ?></td>
                        <td><span class="label label-default"><?= $d['kd_mk'] ?></span></td>
                        <td><?= $d['nama_mk'] ?></td>
                        <td class="text-center"><span class="badge bg-blue"><?= $d['sks'] ?></span></td>
                        <td class="text-center">
                            <?php if ($d['nilai_angka']) : ?>
                                <span class="badge bg-aqua"><?= $d['nilai_angka'] ?></span>
                            <?php else : ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php if ($d['nilai_huruf']) : ?>
                                <?php
        $badgeClass = match($d['nilai_huruf']) {
            'A' => 'bg-green',
            'B' => 'bg-blue',
            'C' => 'bg-yellow',
            'D' => 'bg-orange',
            'E' => 'bg-red',
            default => 'bg-gray'
        };
                                ?>
                                <span class="badge <?= $badgeClass ?>" style="font-size: 14px; padding: 5px 10px;"><?= $d['nilai_huruf'] ?></span>
                            <?php else : ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php if ($d['nilai_huruf']) : ?>
                                <?php
                                $bobot = match($d['nilai_huruf']) {
                                    'A' => 4, 'B' => 3, 'C' => 2, 'D' => 1, 'E' => 0, default => 0
                                };
                                ?>
                                <span class="badge bg-purple"><?= $bobot ?></span>
                            <?php else : ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot class="bg-light-blue">
                    <tr>
                        <td colspan="3" class="text-right"><b>Total Semester Ini:</b></td>
                        <td class="text-center"><b><?= $n['total_sks'] ?> SKS</b></td>
                        <td colspan="2" class="text-center"><b>IP Semester: <?= $n['ip'] ?></b></td>
                        <td class="text-center"><b><?= $n['total_bobot'] ?></b></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <?php endforeach; ?>

    <!-- Summary -->
    <div class="box box-warning">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-bar-chart"></i> Ringkasan Akademik</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="info-box bg-aqua">
                        <span class="info-box-icon"><i class="fa fa-book"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total SKS Lulus</span>
                            <span class="info-box-number"><?= $totalSks ?> / 144</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="info-box <?= $ipk >= 3.5 ? 'bg-green' : ($ipk >= 2.5 ? 'bg-yellow' : 'bg-red') ?>">
                        <span class="info-box-icon"><i class="fa fa-star"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">IPK</span>
                            <span class="info-box-number"><?= $ipk ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="info-box bg-purple">
                        <span class="info-box-icon"><i class="fa fa-calendar"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Semester Ditempuh</span>
                            <span class="info-box-number"><?= count($nilai) ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="info-box bg-navy">
                        <span class="info-box-icon"><i class="fa fa-graduation-cap"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Sisa SKS</span>
                            <span class="info-box-number"><?= 144 - $totalSks ?> SKS</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <a href="<?= site_url('dosen/bimbingan') ?>" class="btn btn-default">
                <i class="fa fa-arrow-left"></i> Kembali ke Daftar Mahasiswa
            </a>
        </div>
    </div>
</section>

<?= $this->endSection() ?>