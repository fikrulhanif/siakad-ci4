<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<section class="content-header">
    <h1><i class="fa fa-dashboard"></i> Dashboard Admin</h1>
    <small>Sistem Informasi Akademik</small>
</section>

<section class="content">
    <!-- Info Boxes Row 1 -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua shadow">
                <div class="inner"><h3><?= $jml_mhs ?></h3><p>Mahasiswa</p></div>
                <div class="icon"><i class="fa fa-users"></i></div>
                <a href="<?= base_url('admin/mahasiswa') ?>" class="small-box-footer">Kelola <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green shadow">
                <div class="inner"><h3><?= $jml_dsn ?></h3><p>Dosen Pengampu</p></div>
                <div class="icon"><i class="fa fa-briefcase"></i></div>
                <a href="<?= base_url('admin/dosen') ?>" class="small-box-footer">Kelola <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-yellow shadow">
                <div class="inner"><h3><?= $jml_mk ?></h3><p>Mata Kuliah</p></div>
                <div class="icon"><i class="fa fa-book"></i></div>
                <a href="<?= base_url('admin/matakuliah') ?>" class="small-box-footer">Kelola <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red shadow">
                <div class="inner"><h3><?= $jml_prodi ?></h3><p>Program Studi</p></div>
                <div class="icon"><i class="fa fa-university"></i></div>
                <a href="<?= base_url('admin/prodi') ?>" class="small-box-footer">Kelola <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <!-- Info Boxes Row 2 - KRS Statistics -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div class="info-box bg-purple">
                <span class="info-box-icon"><i class="fa fa-file-text"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total KRS</span>
                    <span class="info-box-number"><?= $totalKrs ?></span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="info-box bg-green">
                <span class="info-box-icon"><i class="fa fa-check"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">KRS Disetujui</span>
                    <span class="info-box-number"><?= $krsApproved ?></span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="info-box bg-yellow">
                <span class="info-box-icon"><i class="fa fa-clock-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">KRS Pending</span>
                    <span class="info-box-number"><?= $krsPending ?></span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="info-box bg-navy">
                <span class="info-box-icon"><i class="fa fa-calendar"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Jadwal Semester Ini</span>
                    <span class="info-box-number"><?= $totalJadwal ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Grafik Mahasiswa per Prodi -->
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-pie-chart"></i> Sebaran Mahasiswa Per Prodi</h3>
                </div>
                <div class="box-body">
                    <canvas id="prodiChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>

        <!-- Grafik Mahasiswa per Angkatan -->
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-bar-chart"></i> Mahasiswa Per Angkatan (5 Tahun Terakhir)</h3>
                </div>
                <div class="box-body">
                    <canvas id="angkatanChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Tahun Akademik & Quick Actions -->
        <div class="col-md-5">
            <div class="info-box bg-blue">
                <span class="info-box-icon"><i class="fa fa-calendar"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Tahun Akademik Aktif</span>
                    <span class="info-box-number">
                        <?= $taAktif ? $taAktif['tahun_ajaran'] . ' (' . $taAktif['semester'] . ')' : 'Tidak Aktif' ?>
                    </span>
                    <div class="progress"><div class="progress-bar" style="width: 100%"></div></div>
                    <span class="progress-description text-white">Status: <b>Berjalan</b></span>
                </div>
            </div>

            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-bullhorn"></i> Pintasan Cepat</h3>
                </div>
                <div class="box-body">
                    <a href="<?= base_url('admin/mahasiswa/create') ?>" class="btn btn-app">
                        <i class="fa fa-user-plus"></i> Tambah Mahasiswa
                    </a>
                    <a href="<?= base_url('admin/dosen/create') ?>" class="btn btn-app">
                        <i class="fa fa-user-plus"></i> Tambah Dosen
                    </a>
                    <a href="<?= base_url('admin/jadwal') ?>" class="btn btn-app">
                        <i class="fa fa-clock-o"></i> Kelola Jadwal
                    </a>
                    <a href="<?= base_url('admin/tahun-akademik') ?>" class="btn btn-app">
                        <i class="fa fa-toggle-on"></i> Ganti Semester
                    </a>
                    <a href="<?= base_url('admin/matakuliah') ?>" class="btn btn-app">
                        <i class="fa fa-book"></i> Kelola Matakuliah
                    </a>
                </div>
            </div>
        </div>

        <!-- Aktivitas Terbaru -->
        <div class="col-md-7">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-history"></i> Aktivitas KRS Terbaru</h3>
                </div>
                <div class="box-body">
                    <?php if (empty($recentKrs)) : ?>
                        <div class="text-center text-muted" style="padding: 20px;">
                            <i class="fa fa-inbox fa-3x"></i>
                            <p>Belum ada aktivitas KRS</p>
                        </div>
                    <?php else : ?>
                        <ul class="timeline timeline-inverse">
                            <?php foreach ($recentKrs as $krs) : ?>
                            <li>
                                <i class="fa <?= $krs['status_krs'] == 'Approved' ? 'fa-check bg-green' : ($krs['status_krs'] == 'Pending' ? 'fa-clock-o bg-yellow' : 'fa-times bg-red') ?>"></i>
                                <div class="timeline-item">
                                    <h3 class="timeline-header">
                                        <b><?= $krs['nama_mhs'] ?></b> (<?= $krs['nim'] ?>)
                                    </h3>
                                    <div class="timeline-body">
                                        <span class="label <?= $krs['status_krs'] == 'Approved' ? 'label-success' : ($krs['status_krs'] == 'Pending' ? 'label-warning' : 'label-danger') ?>">
                                            <?= $krs['status_krs'] ?>
                                        </span>
                                        <span class="label label-default"><?= $krs['nama_prodi'] ?></span>
                                    </div>
                                </div>
                            </li>
                            <?php endforeach; ?>
                            <li><i class="fa fa-clock-o bg-gray"></i></li>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="<?= base_url('assets/plugins/chart.js/chart.umd.min.js') ?>"></script>
<script>
    // Grafik Prodi (Doughnut)
    const ctxProdi = document.getElementById('prodiChart').getContext('2d');
    new Chart(ctxProdi, {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($prodiLabels) ?>,
            datasets: [{
                data: <?= json_encode($prodiData) ?>,
                backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                legend: { position: 'right' }
            }
        }
    });

    // Grafik Angkatan (Bar)
    const ctxAngkatan = document.getElementById('angkatanChart').getContext('2d');
    new Chart(ctxAngkatan, {
        type: 'bar',
        data: {
            labels: <?= json_encode($angkatanLabels) ?>,
            datasets: [{
                label: 'Jumlah Mahasiswa',
                data: <?= json_encode($mhsPerAngkatan) ?>,
                backgroundColor: '#00a65a',
                borderColor: '#008d4c',
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 10
                    }
                }
            }
        }
    });
</script>
<?= $this->endSection() ?>