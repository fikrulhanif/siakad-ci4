<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
    .border-thick { border: 2px solid #000 !important; }
    .table-transkrip { border: 2px solid #000; margin-bottom: 25px; }
    .table-transkrip th { border: 1px solid #000 !important; background-color: #eee !important; color: #000; font-weight: bold; text-align: center; }
    .table-transkrip td { border: 1px solid #000 !important; }
    .semester-header { background: #3c8dbc; color: white; padding: 10px; font-weight: bold; border: 2px solid #000; border-bottom: none; }
    .info-mhs td { padding: 5px; font-weight: bold; }
</style>

<section class="content-header">
    <h1><i class="fa fa-book"></i> Transkrip Nilai Akademik</h1>
</section>

<section class="content">
    <div class="box box-primary border-thick">
        <div class="box-body" style="padding: 20px;">
            
            <div class="row" style="border-bottom: 2px solid #000; padding-bottom: 15px; margin-bottom: 20px;">
                <div class="col-md-6">
                    <table class="info-mhs">
                        <tr><td width="150">NAMA MAHASISWA</td><td>: <?= strtoupper($mhs['nama_mhs']) ?></td></tr>
                        <tr><td>NIM / NO BP</td><td>: <?= $mhs['nim'] ?></td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="info-mhs">
                        <tr><td width="150">PROGRAM STUDI</td><td>: <?= strtoupper($mhs['nama_prodi']) ?></td></tr>
                        <tr><td>JENJANG PENDIDIKAN</td><td>: STRATA SATU (S1)</td></tr>
                    </table>
                </div>
            </div>

            <?php if (empty($transkrip)): ?>
                <div class="alert alert-warning text-center">Data nilai belum tersedia.</div>
            <?php else: ?>
                <?php foreach ($transkrip as $semester => $mk_list): ?>
                    <div class="semester-header">
                        PERIODE : <?= strtoupper($semester) ?>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-transkrip">
                            <thead>
                                <tr>
                                    <th width="50">NO</th>
                                    <th width="120">KODE MK</th>
                                    <th>MATA KULIAH</th>
                                    <th width="60">SKS</th>
                                    <th width="80">NILAI</th>
                                    <th width="80">BOBOT</th>
                                    <th width="80">MUTU</th>
                                    <th width="100">STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $subSks = 0;
                    $subPoin = 0;
                    foreach ($mk_list as $i => $row):
                        $subSks += $row['sks'];
                        $subPoin += $row['poin'];
                        ?>
                                <tr>
                                    <td class="text-center"><?= $i + 1 ?></td>
                                    <td class="text-center"><b><?= $row['kd_mk'] ?></b></td>
                                    <td><?= strtoupper($row['nama_mk']) ?></td>
                                    <td class="text-center"><?= $row['sks'] ?></td>
                                    <td class="text-center"><b><?= $row['nilai_huruf'] ?></b></td>
                                    <td class="text-center"><?= $row['bobot'] ?></td>
                                    <td class="text-center"><?= $row['poin'] ?></td>
                                    <td class="text-center">
                                        <b class="<?= $row['status'] == 'Lulus' ? 'text-success' : 'text-danger' ?>">
                                            <?= strtoupper($row['status']) ?>
                                        </b>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot style="background: #f9f9f9; font-weight: bold;">
                                <tr>
                                    <td colspan="3" class="text-right">JUMLAH SEMESTER INI :</td>
                                    <td class="text-center"><?= $subSks ?></td>
                                    <td colspan="2"></td>
                                    <td class="text-center"><?= $subPoin ?></td>
                                    <td class="text-center">IPS: <?= number_format($subPoin / $subSks, 2) ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <div class="row" style="margin-top: 20px;">
                <div class="col-md-6 col-md-offset-6">
                    <table class="table border-thick" style="font-size: 16px; font-weight: bold; background: #eee;">
                        <tr>
                            <td width="60%">TOTAL SKS LULUS</td>
                            <td class="text-right"><?= $summary['totalSksLulus'] ?> SKS</td>
                        </tr>
                        <tr>
                            <td>INDEKS PRESTASI KUMULATIF (IPK)</td>
                            <td class="text-right" style="font-size: 24px; color: #d9534f;"><?= $summary['ipk'] ?></td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
        <div class="box-footer">
            <button onclick="window.print()" class="btn btn-default"><i class="fa fa-print"></i> Print Screen</button>
            <a href="<?= site_url('mahasiswa/transkrip/print') ?>" target="_blank" class="btn btn-primary pull-right">
                <i class="fa fa-file-pdf-o"></i> Cetak Transkrip
            </a>
        </div>
    </div>
</section>

<?= $this->endSection() ?>