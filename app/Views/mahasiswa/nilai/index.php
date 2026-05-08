<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
    .table-khs { border: 2px solid #333; }
    .table-khs th { border: 1px solid #333 !important; background-color: #3c8dbc !important; color: white; text-align: center; vertical-align: middle !important; }
    .table-khs td { border: 1px solid #333 !important; vertical-align: middle !important; }
    .info-box-khs { border: 2px solid #3c8dbc; padding: 10px; border-radius: 5px; background: #f4f7f9; }
    .label-status { font-size: 11px; padding: 4px 8px; border-radius: 3px; font-weight: bold; }
    .profil-mhs th { padding: 4px 0; color: #555; font-size: 13px; }
    .profil-mhs td { padding: 4px 10px; font-weight: bold; font-size: 13px; }
</style>

<section class="content-header">
    <h1><i class="fa fa-graduation-cap text-blue"></i> Kartu Hasil Studi (KHS)</h1>
</section>

<section class="content">
    <div class="box box-solid">
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <form action="" method="get" class="form-inline">
                        <label><i class="fa fa-calendar"></i> Pilih Periode Semester : </label>
                        <select name="id_tahun" class="form-control" onchange="this.form.submit()" style="min-width: 200px;">
                            <?php foreach ($semuaTa as $t) : ?>
                                <option value="<?= $t['id_tahun'] ?>" <?= ($t['id_tahun'] == $taTerpilih['id_tahun']) ? 'selected' : '' ?>>
                                    <?= $t['tahun_ajaran'] ?> - <?= $t['semester'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </div>
                <div class="col-md-6 text-right">
                    <?php if (!empty($id_krs)) : ?>
                        <a href="<?= site_url('mahasiswa/nilai/print/'.$id_krs) ?>" target="_blank" class="btn btn-danger">
                            <i class="fa fa-print"></i> Cetak KHS
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="box box-primary" style="border-top: 3px solid #3c8dbc;">
        <div class="box-header with-border text-center">
            <h3 class="box-title" style="font-weight:bold; font-size: 20px; letter-spacing: 1px;">KARTU HASIL STUDI MAHASISWA</h3>
        </div>
        
        <div class="box-body">
            <div class="row" style="margin-bottom: 25px;">
                <div class="col-md-7">
                    <table class="profil-mhs">
                        <tr><th width="140">NAMA MAHASISWA</th><td>: <?= strtoupper(session()->get('nama')) ?></td></tr>
                        <tr><th>NIM / NO BP</th><td>: <?= session()->get('nim') ?></td></tr>
                        <tr><th>PROGRAM STUDI</th><td>: <?= strtoupper(isset($mahasiswa['nama_prodi']) ? $mahasiswa['nama_prodi'] : '-') ?></td></tr>
                    </table>
                </div>
                <div class="col-md-5">
                    <div class="info-box-khs text-center">
                        <span class="text-muted" style="display:block; font-size: 12px; margin-bottom: 5px;">INDEKS PRESTASI SEMESTER (IPS)</span>
                        <strong style="font-size: 32px; color: #3c8dbc; line-height: 1;"><?= $summary['ips'] ?></strong>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-khs table-hover">
                    <thead>
                        <tr>
                            <th width="40">NO</th>
                            <th width="120">KODE MK</th>
                            <th>MATA KULIAH</th>
                            <th width="60">SKS</th>
                            <th width="80">HURUF</th>
                            <th width="80">BOBOT</th>
                            <th width="100">MUTU</th>
                            <th width="120">KETERANGAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($nilai)): ?>
                            <tr><td colspan="8" class="text-center text-muted" style="padding: 20px;">Belum ada data nilai untuk semester ini.</td></tr>
                        <?php else: ?>
                            <?php foreach ($nilai as $key => $n) : ?>
                            <tr>
                                <td class="text-center"><?= $key + 1 ?></td>
                                <td class="text-center"><code><?= $n['kd_mk'] ?></code></td>
                                <td><?= strtoupper($n['nama_mk']) ?></td>
                                <td class="text-center"><?= $n['sks'] ?></td>
                                <td class="text-center"><b><?= $n['nilai_huruf'] ?? '-' ?></b></td>
                                <td class="text-center"><?= $n['bobot'] ?></td>
                                <td class="text-center"><?= $n['poin'] ?></td>
                                <td class="text-center">
                                    <?php if ($n['nilai_huruf']): ?>
                                        <span class="label-status <?= ($n['bobot'] > 0) ? 'bg-green' : 'bg-red' ?>">
                                            <?= ($n['bobot'] > 0) ? 'LULUS' : 'GAGAL' ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="label-status bg-gray">PROSES</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                    <tfoot style="background-color: #eee; font-weight: bold;">
                        <tr>
                            <td colspan="3" class="text-right">JUMLAH CAPAIAN SEMESTER :</td>
                            <td class="text-center"><?= $summary['totalSks'] ?></td>
                            <td colspan="2"></td>
                            <td class="text-center"><?= $summary['totalPoin'] ?></td>
                            <td class="text-center" style="background: #3c8dbc; color: white;">IPS: <?= $summary['ips'] ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="box-footer">
            <div class="row">
                <div class="col-md-6">
                    <p class="small text-muted"><b>Catatan:</b><br>
                    * Gunakan tombol cetak untuk mengunduh versi PDF resmi.<br>
                    * Pastikan semua nilai sudah divalidasi oleh dosen pengampu.</p>
                </div>
                <div class="col-md-6 text-right">
                    <p class="small text-muted">Dicetak pada: <?= date('d/m/Y H:i') ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
@media print {
    .main-footer, .btn, .content-header, form, .box-footer { display: none !important; }
    .box { border: none !important; }
    .table-khs { width: 100% !important; border: 1px solid #000 !important; }
    .table-khs th, .table-khs td { border: 1px solid #000 !important; }
    .table-khs th { background-color: #eee !important; color: #000 !important; }
    .info-box-khs { border: 1px solid #000 !important; }
}
</style>

<?= $this->endSection() ?>