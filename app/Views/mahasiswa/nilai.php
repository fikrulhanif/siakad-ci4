<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<section class="content-header">
    <h1><i class="fa fa-file-text-o"></i> Kartu Hasil Studi (KHS)</h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <form action="" method="get" class="form-inline">
                <label>Pilih Semester: </label>
                <select name="id_tahun" class="form-control input-sm" onchange="this.form.submit()">
                    <?php foreach ($semuaTa as $t) : ?>
                        <option value="<?= $t['id_tahun'] ?>" <?= ($t['id_tahun'] == $taTerpilih['id_tahun']) ? 'selected' : '' ?>>
                            <?= $t['tahun_ajaran'] ?> - <?= $t['semester'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>
        <div class="box-body">
            <div class="well well-sm">
                <b>Nama:</b> <?= session()->get('nama') ?> <br>
                <b>NIM:</b> <?= session()->get('nim') ?> <br>
                <b>Semester:</b> <?= $taTerpilih['tahun_ajaran'] ?> (<?= $taTerpilih['semester'] ?>)
            </div>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="bg-blue">
                        <th width="50">No</th>
                        <th>Kode</th>
                        <th>Mata Kuliah</th>
                        <th>SKS</th>
                        <th>Nilai Angka</th>
                        <th>Nilai Huruf</th>
                        <th>Bobot</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalSks = 0;
$totalPoin = 0;
foreach ($nilai as $key => $n) :
    $totalSks += $n['sks'];
    // Hitung Bobot
    $bobot = 0;
    if ($n['nilai_huruf'] == 'A') {
        $bobot = 4;
    } elseif ($n['nilai_huruf'] == 'B') {
        $bobot = 3;
    } elseif ($n['nilai_huruf'] == 'C') {
        $bobot = 2;
    } elseif ($n['nilai_huruf'] == 'D') {
        $bobot = 1;
    }
    $totalPoin += ($bobot * $n['sks']);
    ?>
                    <tr>
                        <td><?= $key + 1 ?></td>
                        <td><?= $n['kd_mk'] ?></td>
                        <td><?= $n['nama_mk'] ?></td>
                        <td><?= $n['sks'] ?></td>
                        <td><?= $n['nilai_angka'] ?? '-' ?></td>
                        <td><b><?= $n['nilai_huruf'] ?? '-' ?></b></td>
                        <td><?= $bobot ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="bg-gray">
                        <th colspan="3" class="text-right">Total SKS</th>
                        <th><?= $totalSks ?></th>
                        <th colspan="2" class="text-right">IP Semester</th>
                        <th><?= ($totalSks > 0) ? number_format($totalPoin / $totalSks, 2) : '0.00' ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="box-footer">
            <button onclick="window.print()" class="btn btn-default"><i class="fa fa-print"></i> Cetak KHS</button>
        </div>
    </div>
</section>

<?= $this->endSection() ?>