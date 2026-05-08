<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>">
    <style>
        @media print { @page { margin: 1cm; size: portrait; } }
        .header-kop { border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 15px; text-align: center; }
        .table th { background-color: #f4f4f4 !important; text-align: center; }
        .high-score { font-weight: bold; color: #2c3e50; }
    </style>
</head>
<body onload="window.print();">
    <div class="container">
        <div class="header-kop">
            <h3><b>UNIVERSITAS FIKRUL HANIF</b></h3>
            <h4><b>LAPORAN REKAPITULASI INDEKS PRESTASI (IP)</b></h4>
            <p>Tahun Akademik: <?= $ta ?> | Prodi: <?= $prodi ?></p>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="30">Rank</th>
                    <th width="120">NIM</th>
                    <th width="100">Angkatan</th>
                    <th>Nama Mahasiswa</th>
                    <th width="80">SKS</th>
                    <th width="100">IP Semester</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (empty($rekap)): ?>
                    <tr><td colspan="6" class="text-center">Data nilai belum tersedia untuk periode ini</td></tr>
                <?php else:
                    foreach ($rekap as $idx => $r) :
                        ?>
                <tr>
    <td class="text-center"><?= $idx + 1 ?></td>
    <td class="text-center"><?= $r['nim'] ?></td>
    <td class="text-center"><?= $r['angkatan'] ?></td>
    <td><?= $r['nama_mhs'] ?></td>
    <td class="text-center"><?= $r['total_sks'] ?></td>
    <td class="text-center"><b><?= number_format($r['ips'], 2) ?></b></td>
</tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>