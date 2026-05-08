<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>">
    <style>
        @media print { 
            @page { margin: 1cm; size: portrait; } 
        }
        .header-kop { border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; text-align: center; }
        .table th { background-color: #f4f4f4 !important; text-align: center; }
    </style>
</head>
<body onload="window.print();">
    <div class="container">
        <div class="header-kop">
            <h3><b>UNIVERSITAS FIKRUL HANIF</b></h3>
            <p>Sistem Informasi Akademik</p>
            <h4><b>LAPORAN DATA DOSEN</b></h4>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th width="200">NIDN</th>
                    <th>Nama Dosen</th>
                    <th>Program Studi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($dosen)): ?>
                    <tr><td colspan="4" class="text-center">Data dosen tidak ditemukan</td></tr>
                <?php endif; ?>
                <?php foreach ($dosen as $idx => $d) : ?>
                <tr>
                    <td class="text-center"><?= $idx + 1 ?></td>
                    <td class="text-center"><b><?= $d['nidn'] ?></b></td>
                    <td><?= $d['nama_dosen'] ?></td>
                    <td><?= $d['nama_prodi'] ?? '-' ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="row" style="margin-top: 30px;">
            <div class="col-xs-8"></div>
            <div class="col-xs-4 text-center">
                <p>Padang, <?= date('d F Y') ?></p>
                <p>Administrator,</p>
                <br><br><br>
                <p><b>( ____________________ )</b></p>
            </div>
        </div>
    </div>
</body>
</html>