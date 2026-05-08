<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<section class="content-header">
    <h1><i class="fa fa-dashboard text-blue"></i> Dashboard Mahasiswa</h1>
</section>

<section class="content">
    <div class="row">
        <!-- Widget 1: IPK -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3><?= number_format($ipk, 2) ?></h3>
                    <p>IPK Kumulatif</p>
                </div>
                <div class="icon"><i class="fa fa-graduation-cap"></i></div>
                <a href="<?= site_url('mahasiswa/transkrip') ?>" class="small-box-footer">Detail Transkrip <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <!-- Widget 2: Total SKS Lulus -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3><?= $totalSks ?> <small style="font-size: 18px;">/ 144</small></h3>
                    <p>Total SKS Lulus</p>
                </div>
                <div class="icon"><i class="fa fa-book"></i></div>
                <a href="<?= site_url('mahasiswa/nilai') ?>" class="small-box-footer">Lihat KHS <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <!-- Widget 3: Semester Aktif -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>Semester <?= $semesterMhs ?></h3>
                    <p><?= $taAktif['tahun_ajaran'] ?> (<?= $taAktif['semester'] ?>)</p>
                </div>
                <div class="icon"><i class="fa fa-calendar"></i></div>
                <a href="<?= site_url('mahasiswa/krs') ?>" class="small-box-footer">Menu KRS <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <!-- Widget 4: Sisa SKS -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3><?= (144 - $totalSks) ?></h3>
                    <p>Sisa SKS untuk Lulus</p>
                </div>
                <div class="icon"><i class="fa fa-flag-checkered"></i></div>
                <a href="#" class="small-box-footer">Target Kelulusan <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <h3 class="profile-username text-center" style="font-weight: bold; margin-top: 5px;"><?= session()->get('nama') ?></h3>
                    <p class="text-muted text-center"><?= session()->get('nim') ?></p>
                    <p class="text-center"><span class="label label-primary"><?= $mhs['nama_prodi'] ?? 'Prodi Tidak Ditemukan' ?></span></p>
                    
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Status</b> <a class="pull-right"><span class="label label-success">Aktif</span></a>
                        </li>
                        <li class="list-group-item">
                            <b>Angkatan</b> <a class="pull-right"><?= $mhs['angkatan'] ?? '-' ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Status KRS</b> 
                            <a class="pull-right">
                                <span class="label <?= $statusKrs == 'Approved' ? 'label-success' : ($statusKrs == 'Pending' ? 'label-warning' : 'label-danger') ?>">
                                    <?= $statusKrs ?>
                                </span>
                            </a>
                        </li>
                        <?php if ($statusKrs == 'Approved') : ?>
                        <li class="list-group-item">
                            <b>SKS Semester Ini</b> <a class="pull-right"><span class="badge bg-blue"><?= $totalSksKrs ?> SKS</span></a>
                        </li>
                        <?php endif; ?>
                    </ul>

                    <!-- Progress Bar Perjalanan Studi -->
                    <div style="margin: 20px 0;">
                        <p class="text-center" style="margin-bottom: 5px;"><b>Perjalanan Studi</b></p>
                        <div class="progress" style="height: 25px;">
                            <?php
                            $persenStudi = ($totalSks / 144) * 100;
$colorProgress = $persenStudi >= 75 ? 'success' : ($persenStudi >= 50 ? 'warning' : 'danger');
?>
                            <div class="progress-bar progress-bar-<?= $colorProgress ?> progress-bar-striped" 
                                 role="progressbar" style="width: <?= $persenStudi ?>%; line-height: 25px;">
                                <b><?= number_format($persenStudi, 1) ?>%</b>
                            </div>
                        </div>
                        <p class="text-center text-muted"><small><?= $totalSks ?> dari 144 SKS</small></p>
                    </div>

                    <a href="<?= site_url('mahasiswa/krs') ?>" class="btn btn-primary btn-block"><b><i class="fa fa-plus"></i> Isi KRS Semester Ini</b></a>
                </div>
                    <?php if (empty($grafik['data'])): ?>
                        <div class="box-footer" style="background: #d9edf7; border-top: 1px solid #bce8f1;">
                            <p style="margin: 0; color: #31708f;">
                                <i class="fa fa-info-circle"></i> Belum ada data nilai untuk ditampilkan dalam grafik.
                            </p>
                        </div>
                    <?php endif; ?>
            </div>
        </div>

        <div class="col-md-8">
            <!-- Jadwal Hari Ini -->
            <div class="box box-success">
                <div class="box-header with-border" style="background: linear-gradient(135deg, #00a65a 0%, #008d4c 100%); color: white;">
                    <h3 class="box-title" style="color: white;">
                        <i class="fa fa-calendar-check-o"></i> Jadwal Kuliah Hari Ini (<?= $hari ?> - <?= date('d/m/Y') ?>)
                    </h3>
                    <span class="pull-right badge" style="background: white; color: #00a65a; font-size: 12px;"><?= count($jadwalHariIni) ?> Kelas</span>
                </div>
                <div class="box-body">
                    <?php if (empty($jadwalHariIni)) : ?>
                        <div style="padding: 40px;" class="text-center">
                            <i class="fa fa-calendar-times-o fa-3x text-muted"></i>
                            <p class="text-muted" style="margin-top: 15px;">Tidak ada jadwal kuliah hari ini</p>
                        </div>
                    <?php else : ?>
                        <?php foreach ($jadwalHariIni as $j) : ?>
                        <div style="background: linear-gradient(135deg, #dff0d8 0%, #c1e2b3 100%); border-left: 5px solid #3c763d; padding: 15px; border-radius: 4px; margin-bottom: 12px;">
                            <h4 style="margin: 0 0 10px 0; color: #3c763d; font-weight: bold;">
                                <i class="fa fa-book"></i> <?= $j['nama_mk'] ?>
                            </h4>
                            <div style="color: #555; font-size: 13px;">
                                <div style="margin-bottom: 5px;">
                                    <i class="fa fa-clock-o" style="width: 20px;"></i> 
                                    <strong><?= date('H:i', strtotime($j['jam'])) ?> - <?= date('H:i', strtotime($j['jam_selesai'])) ?></strong>
                                </div>
                                <div style="margin-bottom: 5px;">
                                    <i class="fa fa-map-marker" style="width: 20px;"></i> 
                                    Ruang <?= $j['ruang'] ?>
                                </div>
                                <div style="margin-bottom: 8px;">
                                    <i class="fa fa-user" style="width: 20px;"></i> 
                                    <?= $j['nama_dosen'] ?>
                                </div>
                                <div>
                                    <span class="label label-primary"><?= $j['sks'] ?> SKS</span>
                                    <span class="label label-info">Kelas <?= $j['kelas'] ?></span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Grafik IP -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-line-chart"></i> Grafik Indeks Prestasi</h3>
                </div>
                <div class="box-body">
                    <div class="chart">
                        <canvas id="lineChart" style="height:250px"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jadwal Mingguan dengan Grouping per Hari -->
    <?php if (!empty($semuaJadwal)): ?>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-calendar"></i> Jadwal Kuliah Mingguan - <?= $taAktif['tahun_ajaran'] ?> (<?= $taAktif['semester'] ?>)</h3>
                    </div>
                    <div class="box-body">
                        <?php
                        // Group jadwal by hari
                        $jadwalByHari = [];
        foreach ($semuaJadwal as $j) {
            $jadwalByHari[$j['hari']][] = $j;
        }

        // Urutan hari
        $urutanHari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        ?>

                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <?php foreach ($urutanHari as $index => $hariTab): ?>
                                    <?php if (isset($jadwalByHari[$hariTab])): ?>
                                        <li class="<?= $hariTab == $hari ? 'active' : '' ?>">
                                            <a href="#tab_<?= strtolower($hariTab) ?>" data-toggle="tab">
                                                <i class="fa fa-calendar-o"></i> <?= $hariTab ?>
                                                <span class="badge bg-blue"><?= count($jadwalByHari[$hariTab]) ?></span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>

                            <div class="tab-content">
                                <?php foreach ($urutanHari as $index => $hariTab): ?>
                                    <?php if (isset($jadwalByHari[$hariTab])): ?>
                                        <div class="tab-pane <?= $hariTab == $hari ? 'active' : '' ?>" id="tab_<?= strtolower($hariTab) ?>">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-striped table-bordered">
                                                    <thead>
                                                        <tr class="bg-navy">
                                                            <th width="50" class="text-center">No</th>
                                                            <th>Mata Kuliah</th>
                                                            <th width="80" class="text-center">SKS</th>
                                                            <th width="80" class="text-center">Semester</th>
                                                            <th width="80" class="text-center">Kelas</th>
                                                            <th width="200">Waktu & Ruang</th>
                                                            <th>Dosen</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($jadwalByHari[$hariTab] as $key => $j): ?>
                                                            <tr>
                                                                <td class="text-center"><?= $key + 1 ?></td>
                                                                <td>
                                                                    <strong class="text-blue"><?= $j['nama_mk'] ?></strong><br>
                                                                    <small class="text-muted"><?= $j['kd_mk'] ?></small>
                                                                </td>
                                                                <td class="text-center">
                                                                    <span class="label label-success"><?= $j['sks'] ?> SKS</span>
                                                                </td>
                                                                <td class="text-center">
                                                                    <span class="label label-primary">Semester <?= $j['smt'] ?></span>
                                                                </td>
                                                                <td class="text-center">
                                                                    <span class="badge bg-purple"><?= $j['kelas'] ?></span>
                                                                </td>
                                                                <td>
                                                                    <i class="fa fa-clock-o text-primary"></i> 
                                                                    <?= date('H:i', strtotime($j['jam'])) ?> - <?= date('H:i', strtotime($j['jam_selesai'])) ?><br>
                                                                    <i class="fa fa-map-marker text-danger"></i> <?= $j['ruang'] ?>
                                                                </td>
                                                                <td><?= $j['nama_dosen'] ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($is_lengkap) && !$is_lengkap): ?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-warning box-solid animated shake">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-bullhorn"></i> PERHATIAN: Biodata Belum Lengkap!</h3>
            </div>
            <div class="box-body">
                <p>Halo <b><?= session()->get('nama') ?></b>, kami melihat data profil Anda (NIK, Email, atau No.HP) belum dilengkapi. 
                Mohon segera melengkapi biodata diri untuk keperluan pelaporan data ke <b>PDDIKTI</b>.</p>
                <a href="<?= base_url('profile') ?>" class="btn btn-warning btn-sm btn-flat text-bold">LENGKAPI SEKARANG <i class="fa fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
</section>

<script src="<?= base_url('assets/plugins/chart.js/chart.umd.min.js') ?>"></script>
<script>
    const ctx = document.getElementById('lineChart').getContext('2d');
    
    // Gradient untuk area di bawah garis
    const gradient = ctx.createLinearGradient(0, 0, 0, 250);
    gradient.addColorStop(0, 'rgba(60, 141, 188, 0.4)');
    gradient.addColorStop(1, 'rgba(60, 141, 188, 0.05)');
    
    const myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($grafik['labels']) ?>,
            datasets: [{
                label: 'IP Semester (IPS)',
                data: <?= json_encode($grafik['data']) ?>,
                borderColor: '#3c8dbc',
                backgroundColor: gradient,
                fill: true,
                tension: 0.4,
                pointRadius: 6,
                pointHoverRadius: 8,
                pointBackgroundColor: '#3c8dbc',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: '#3c8dbc',
                borderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    padding: 12,
                    titleFont: {
                        size: 14
                    },
                    bodyFont: {
                        size: 13
                    },
                    callbacks: {
                        label: function(context) {
                            return 'IP: ' + context.parsed.y.toFixed(2);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 4.0,
                    ticks: {
                        stepSize: 0.5,
                        callback: function(value) {
                            return value.toFixed(1);
                        }
                    },
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            animation: {
                duration: 1500,
                easing: 'easeInOutQuart'
            }
        }
    });
</script>
<?= $this->endSection() ?>