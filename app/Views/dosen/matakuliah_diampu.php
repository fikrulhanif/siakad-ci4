<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<section class="content-header">
    <h1><i class="fa fa-book"></i> Mata Kuliah Diampu</h1>
    <small>Tahun Akademik: <?= $taAktif['tahun_ajaran'] ?> (<?= $taAktif['semester'] ?>)</small>
</section>

<section class="content">
    <?php if (empty($jadwal)) : ?>
        <div class="callout callout-warning">
            <h4><i class="fa fa-warning"></i> Tidak Ada Data!</h4>
            <p>Anda tidak memiliki jadwal mengajar pada semester aktif ini.</p>
        </div>
    <?php else : ?>
        <?php
        // Group jadwal by semester
        $jadwalBySemester = [];
        foreach ($jadwal as $j) {
            $jadwalBySemester[$j['smt']][] = $j;
        }
        ksort($jadwalBySemester); // Sort by semester
        ?>

        <?php foreach ($jadwalBySemester as $smt => $matakuliah) : ?>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-graduation-cap"></i> Semester <?= $smt ?></h3>
                    <span class="pull-right badge bg-blue"><?= count($matakuliah) ?> Mata Kuliah</span>
                </div>
                <div class="box-body">
                    <div class="row">
                        <?php foreach ($matakuliah as $j) : ?>
                        <div class="col-md-6">
                            <div class="info-box shadow" style="min-height: 100px; background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
                                <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><b><?= $j['nama_mk'] ?></b></span>
                                    <span class="info-box-number">
                                        Kelas <?= $j['kelas'] ?> 
                                        <small>(<?= $j['sks'] ?> SKS)</small>
                                    </span>
                                    
                                    <div style="margin-top: 5px;">
                                        <span class="badge bg-green"><?= $j['jml_mhs'] ?> Mahasiswa</span>
                                        <span class="badge bg-gray"><i class="fa fa-map-marker"></i> <?= $j['ruang'] ?></span>
                                        <span class="badge bg-gray"><i class="fa fa-calendar"></i> <?= $j['hari'] ?></span>
                                    </div>
                                    
                                    <div style="margin-top: 8px;">
                                        <a href="<?= site_url('dosen/detail-matakuliah/'.$j['id_jadwal']) ?>" class="btn btn-info btn-xs">
                                            <i class="fa fa-users"></i> Peserta
                                        </a>
                                        <a href="<?= site_url('dosen/print-absensi/'.$j['id_jadwal']) ?>" target="_blank" class="btn btn-default btn-xs">
                                            <i class="fa fa-print"></i> Absen
                                        </a>
                                        <a href="<?= site_url('dosen/nilai/input/'.$j['id_jadwal']) ?>" class="btn btn-success btn-xs">
                                            <i class="fa fa-edit"></i> Input Nilai
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