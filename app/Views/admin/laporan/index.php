<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<section class="content-header">
    <h1><i class="fa fa-file-text"></i> Pusat Laporan</h1>
    <small>Sistem Informasi Akademik</small>
</section>

<section class="content">
    <!-- Laporan Master Data -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-database"></i> Laporan Master Data</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="info-box bg-aqua" style="cursor: pointer;" onclick="window.location='<?= site_url('admin/laporan/mahasiswa') ?>'">
                        <span class="info-box-icon"><i class="fa fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Data Mahasiswa</span>
                            <span class="info-box-number">Laporan</span>
                            <div class="progress"><div class="progress-bar" style="width: 100%"></div></div>
                            <span class="progress-description">Filter berdasarkan Prodi & Angkatan</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box bg-green" style="cursor: pointer;" onclick="window.location='<?= site_url('admin/laporan/dosen') ?>'">
                        <span class="info-box-icon"><i class="fa fa-briefcase"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Data Dosen</span>
                            <span class="info-box-number">Laporan</span>
                            <div class="progress"><div class="progress-bar" style="width: 100%"></div></div>
                            <span class="progress-description">Semua data dosen pengampu</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box bg-yellow" style="cursor: pointer;" onclick="window.location='<?= site_url('admin/laporan/matakuliah') ?>'">
                        <span class="info-box-icon"><i class="fa fa-book"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Data Mata Kuliah</span>
                            <span class="info-box-number">Laporan</span>
                            <div class="progress"><div class="progress-bar" style="width: 100%"></div></div>
                            <span class="progress-description">Filter berdasarkan Prodi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Laporan Akademik -->
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-graduation-cap"></i> Laporan Akademik</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="info-box bg-purple" style="cursor: pointer;" onclick="window.location='<?= site_url('admin/laporan/jadwal') ?>'">
                        <span class="info-box-icon"><i class="fa fa-calendar"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Jadwal Perkuliahan</span>
                            <span class="info-box-number">Laporan</span>
                            <div class="progress"><div class="progress-bar" style="width: 100%"></div></div>
                            <span class="progress-description">Per Semester & Prodi</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box bg-navy" style="cursor: pointer;" onclick="window.location='<?= site_url('admin/laporan/krs') ?>'">
                        <span class="info-box-icon"><i class="fa fa-file-text"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Rekapitulasi KRS</span>
                            <span class="info-box-number">Laporan</span>
                            <div class="progress"><div class="progress-bar" style="width: 100%"></div></div>
                            <span class="progress-description">KRS Mahasiswa per Semester</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box bg-red" style="cursor: pointer;" onclick="window.location='<?= site_url('admin/laporan/nilai') ?>'">
                        <span class="info-box-icon"><i class="fa fa-trophy"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Indeks Prestasi</span>
                            <span class="info-box-number">Laporan</span>
                            <div class="progress"><div class="progress-bar" style="width: 100%"></div></div>
                            <span class="progress-description">Ranking IP Mahasiswa</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box bg-orange" style="cursor: pointer;" onclick="window.location='<?= site_url('admin/laporan/nilai-mk') ?>'">
                        <span class="info-box-icon"><i class="fa fa-list-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Nilai Per Matkul</span>
                            <span class="info-box-number">Laporan</span>
                            <div class="progress"><div class="progress-bar" style="width: 100%"></div></div>
                            <span class="progress-description">Daftar nilai per kelas</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="callout callout-info">
        <h4><i class="fa fa-info-circle"></i> Informasi</h4>
        <p>Pilih jenis laporan yang ingin Anda cetak. Setiap laporan memiliki filter dan parameter yang dapat disesuaikan.</p>
    </div>
</section>

<style>
.info-box:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.3);
    transform: translateY(-2px);
    transition: all 0.3s;
}
</style>

<?= $this->endSection() ?>
