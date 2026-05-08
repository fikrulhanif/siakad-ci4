<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<section class="content-header">
    <h1><i class="fa fa-book"></i> Detail Mata Kuliah</h1>
</section>

<section class="content">
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><b><?= $j['nama_mk'] ?></b> (<?= $j['kelas'] ?>)</h3>
            <div class="box-tools pull-right">
                <a href="<?= base_url('dosen/print-absensi/' . $j['id_jadwal']) ?>" target="_blank" class="btn btn-primary btn-sm btn-cetak">
                    <i class="fa fa-print"></i> Cetak Absensi Resmi
                </a>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table">
                        <tr><th width="150">Kode MK</th><td>: <?= $j['kd_mk'] ?></td></tr>
                        <tr><th>SKS</th><td>: <?= $j['sks'] ?> SKS</td></tr>
                        <tr><th>Jadwal</th><td>: <?= $j['hari'] ?>, <?= $j['jam'] ?> - <?= $j['jam_selesai'] ?></td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table">
                        <tr><th width="150">Ruang</th><td>: <?= $j['ruang'] ?></td></tr>
                        <tr><th>Semester</th><td>: <?= $j['semester'] ?> <?= $j['tahun_ajaran'] ?></td></tr>
                        <tr><th>Total Mahasiswa</th><td>: <b><?= count($peserta) ?> Orang</b></td></tr>
                    </table>
                </div>
            </div>

            <hr>
            <h4 class="text-center"><b>DAFTAR PESERTA</b></h4>
            <table class="table table-bordered table-striped" id="example1">
                <thead>
                    <tr class="bg-navy">
                        <th width="30" class="text-center">No</th>
                        <th width="150">NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th class="text-center">Angkatan</th>
                        <th>Program Studi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($peserta as $idx => $p) : ?>
                    <tr>
                        <td class="text-center"><?= $idx + 1 ?></td>
                        <td><?= $p['nim'] ?></td>
                        <td><?= $p['nama_mhs'] ?></td>
                        <td class="text-center"><?= $p['angkatan'] ?></td>
                        <td><?= $p['nama_prodi'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<style>
    .btn-cetak:hover{
        color: white !important;
        background-color: crimson !important;
    }
</style>

<?= $this->endSection() ?>