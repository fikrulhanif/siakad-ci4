<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Transkrip Nilai - <?= $mhs['nim'] ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>">
    <style>
        @media print { 
            @page { margin: 1cm 1.5cm; size: portrait; } 
            .no-print { display: none; }
        }
        body { font-family: 'Times New Roman', Times, serif; color: #000; }
        .header-kop { border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .table-info td { padding: 2px; font-size: 13px; font-weight: bold; }
        /* Garis tabel harus hitam tegas saat dicetak */
        .table-bordered th, .table-bordered td { border: 1px solid #000 !important; font-size: 12px; }
        .semester-title { background-color: #f2f2f2 !important; font-weight: bold; padding: 5px; border: 1px solid #000; margin-top: 15px; }
    </style>
</head>
<body onload="window.print();">
    <div class="container-fluid">
        <div class="header-kop" style="display: flex; align-items: center;">
            <img src="<?= base_url('assets/dist/img/Logo.png') ?>" width="80" style="margin-right: 20px;">
            <div style="text-align: center; width: 100%;">
                <h3 style="margin:0;"><b>UNIVERSITAS FIKRUL HANIF</b></h3>
                <h4 style="margin:5px 0;">TRANSKRIP NILAI AKADEMIK (HISTORI NILAI)</h4>
            </div>
        </div>

        <table class="table-info" width="100%">
            <tr>
                <td width="15%">NIM</td><td width="40%">: <?= $mhs['nim'] ?></td>
                <td width="15%">PRODI</td><td width="30%">: <?= strtoupper($mhs['nama_prodi']) ?> (<?= $jenjang ?>)</td>
            </tr>
            <tr>
                <td>NAMA</td><td>: <?= strtoupper($mhs['nama_mhs']) ?></td>
                <td>DOSEN PA</td><td>: <?= $mhs['pembimbing'] ?></td>
            </tr>
        </table>

        <?php foreach ($transkrip as $semester => $mk_list): ?>
    <div style="font-weight: bold; margin-top: 10px; border: 1px solid #000; padding: 5px; background: #eee;">
        PERIODE: <?= strtoupper($semester) ?>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center" width="5%">NO</th>
                <th class="text-center" width="15%">KODE</th>
                <th>NAMA MATAKULIAH</th>
                <th class="text-center" width="8%">SKS</th>
                <th class="text-center" width="8%">NILAI</th>
                <th class="text-center" width="8%">BOBOT</th>
                <th class="text-center" width="8%">MUTU</th>
                <th class="text-center" width="12%">KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($mk_list as $idx => $t): ?>
            <tr>
                <td class="text-center"><?= $idx + 1 ?></td>
                <td class="text-center"><?= $t['kd_mk'] ?></td>
                <td><?= strtoupper($t['nama_mk']) ?></td>
                <td class="text-center"><?= $t['sks'] ?></td>
                <td class="text-center"><?= $t['nilai_huruf'] ?></td>
                <td class="text-center"><?= $t['bobot'] ?></td>
                <td class="text-center"><?= $t['poin'] ?></td>
                <td class="text-center"><b><?= $t['keterangan'] ?></b></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endforeach; ?>

        <div class="row" style="margin-top: 20px;">
            <div class="col-xs-7">
                <div style="border: 1px solid #000; padding: 10px; display: inline-block;">
                    <p style="margin:0;">Total SKS Lulus: <b><?= $summary['totalSksLulus'] ?> SKS</b></p>
                    <p style="margin:0;">IPK Kumulatif: <b><?= $summary['ipk'] ?></b></p>
                </div>
            </div>
            <div class="col-xs-5 text-center">
                <p>Padang, <?= date('d F Y') ?></p>
                <p>Ketua Program Studi,</p>
                <div style="height: 60px;"></div> <p><b>( Novinaldi, S.Kom, M.Kom )</b></p>
            </div>
        </div>
    </div>
</body>
</html>