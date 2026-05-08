<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<section class="content-header">
    <h1>
        <i class="fa fa-users"></i> Daftar Mahasiswa Bimbingan
        <small>Tahun Akademik: <?= $taAktif['tahun_ajaran'] ?> (<?= $taAktif['semester'] ?>)</small>
    </h1>
</section>

<section class="content">
    <?php if (empty($mhs)) : ?>
        <div class="callout callout-warning">
            <h4><i class="fa fa-warning"></i> Tidak Ada Data!</h4>
            <p>Belum ada mahasiswa bimbingan yang terdaftar.</p>
        </div>
    <?php else : ?>
        <!-- Summary Box -->
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-aqua">
                    <span class="info-box-icon"><i class="fa fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Mahasiswa</span>
                        <span class="info-box-number"><?= count($mhs) ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-yellow">
                    <span class="info-box-icon"><i class="fa fa-clock-o"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">KRS Pending</span>
                        <span class="info-box-number"><?= array_sum(array_column($mhs, 'pending_krs')) ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-green">
                    <span class="info-box-icon"><i class="fa fa-graduation-cap"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Angkatan</span>
                        <span class="info-box-number"><?= count($mhsByAngkatan) ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-red">
                    <span class="info-box-icon"><i class="fa fa-warning"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">IPK < 2.5</span>
                        <span class="info-box-number"><?= count(array_filter($mhs, fn ($m) => (float)$m['ipk'] < 2.5)) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Group by Angkatan -->
        <?php foreach ($mhsByAngkatan as $angkatan => $mahasiswaList) : ?>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-graduation-cap"></i> Angkatan <?= $angkatan ?></h3>
                    <span class="pull-right badge bg-blue"><?= count($mahasiswaList) ?> Mahasiswa</span>
                </div>
                <div class="box-body">
                    <div class="row">
                        <?php foreach ($mahasiswaList as $m) : ?>
                        <div class="col-md-6">
                            <div class="info-box shadow" style="min-height: 120px; background: linear-gradient(135deg, #e1f5fe 0%, #b3e5fc 100%);">
                                <span class="info-box-icon <?= (float)$m['ipk'] >= 3.5 ? 'bg-green' : ((float)$m['ipk'] >= 2.5 ? 'bg-yellow' : 'bg-red') ?>">
                                    <i class="fa fa-user"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><b><?= $m['nama_mhs'] ?></b></span>
                                    <span class="info-box-number" style="font-size: 14px;">
                                        <span class="label label-primary"><?= $m['nim'] ?></span>
                                    </span>
                                    
                                    <div style="margin-top: 5px;">
                                        <span class="badge bg-gray"><i class="fa fa-building"></i> <?= $m['nama_prodi'] ?></span>
                                        <span class="badge bg-blue"><i class="fa fa-calendar"></i> Semester <?= $m['semester'] ?></span>
                                    </div>
                                    
                                    <div style="margin-top: 5px;">
                                        <span class="badge <?= (float)$m['ipk'] >= 3.5 ? 'bg-green' : ((float)$m['ipk'] >= 2.5 ? 'bg-yellow' : 'bg-red') ?>">
                                            <i class="fa fa-star"></i> IPK: <?= $m['ipk'] ?>
                                        </span>
                                        <span class="badge bg-aqua">
                                            <i class="fa fa-check"></i> <?= $m['total_sks'] ?> SKS Lulus
                                        </span>
                                        <?php if ($m['pending_krs'] > 0) : ?>
                                        <span class="badge bg-orange">
                                            <i class="fa fa-clock-o"></i> KRS Pending
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div style="margin-top: 8px;">
                                        <a href="<?= site_url('dosen/bimbingan/nilai/'.$m['nim']) ?>" class="btn btn-success btn-xs">
                                            <i class="fa fa-file-text"></i> Lihat KHS
                                        </a>
                                        <a href="<?= site_url('dosen/persetujuan-krs') ?>" class="btn btn-warning btn-xs">
                                            <i class="fa fa-check-square-o"></i> Persetujuan KRS
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</section>

<style>
.info-box:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    transition: 0.3s;
}
</style>

<?= $this->endSection() ?>