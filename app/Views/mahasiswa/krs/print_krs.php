<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak KRS - <?= $krs['nim'] ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>">
    <style>
        @media print {
            .no-print { display: none !important; }
            @page { margin: 1.5cm; size: portrait; }
            .table-bordered th, .table-bordered td { border: 1px solid #000 !important; }
        }
        .header-kop { border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; display: flex; align-items: center; }
        .logo-box { width: 15%; }
        .text-box { width: 85%; text-align: center; padding-right: 15%; }
        .table-info td { padding: 3px 5px; }
    </style>
</head>
<body onload="window.print();">

    <div class="container">
        <div class="header-kop">
            <div class="logo-box"><img src="<?= base_url('assets/dist/img/Logo.png') ?>" width="80"></div>
            <div class="text-box">
                <h3><b>UNIVERSITAS FIKRUL HANIF</b></h3>
                <h4><b>SISTEM INFORMASI AKADEMIK</b></h4>
            </div>
        </div>

        <h4 class="text-center" style="text-decoration: underline; margin-bottom: 20px;"><b>KARTU RENCANA STUDI (KRS)</b></h4>

        <table class="table-info" width="100%">
            <tr>
                <td width="15%">NIM</td><td width="35%">: <?= $krs['nim'] ?></td>
                <td width="20%">Semester</td><td width="30%">: <?= $krs['semester'] ?></td>
            </tr>
            <tr>
                <td>Nama Mahasiswa</td><td>: <?= $krs['nama_mhs'] ?></td>
                <td>Tahun Akademik</td><td>: <?= $krs['tahun_ajaran'] ?></td>
            </tr>
            <tr>
                <td>Program Studi</td><td>: <?= $krs['nama_prodi'] ?></td>
                <td>Pembimbing Akademik</td><td>: <?= $krs['pembimbing'] ?></td>
            </tr>
        </table>

        <table class="table table-bordered" style="margin-top: 15px;">
            <thead>
                <tr style="background-color: #f5f5f5 !important;">
                    <th class="text-center" width="5%">No</th>
                    <th class="text-center" width="15%">Kode</th>
                    <th>Mata Kuliah</th>
                    <th class="text-center" width="5%">SKS</th>
                    <th class="text-center" width="10%">Kelas</th>
                    <th class="text-center">Jadwal & Ruang</th>
                </tr>
            </thead>
            <tbody>
                <?php $totalSks = 0;
    foreach ($detail as $idx => $d) : $totalSks += $d['sks'];?>
                <tr>
                    <td class="text-center"><?= $idx + 1 ?></td>
                    <td class="text-center"><?= $d['kd_mk'] ?></td>
                    <td><?= $d['nama_mk'] ?></td>
                    <td class="text-center"><?= $d['sks'] ?></td>
                    <td class="text-center"><?= $d['kelas'] ?></td>
                    <td>
                        <?= $d['hari'] ?>, <?= substr($d['jam'], 0, 5) ?> - <?= substr($d['jam_selesai'], 0, 5) ?> WIB 
                        (<?= $d['ruang'] ?>)
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-right">Total SKS yang diambil</th>
                    <th class="text-center"><?= $totalSks ?></th>
                    <th colspan="2"></th>
                </tr>
            </tfoot>
        </table>

        <div style="margin-top: 30px;">
            <div class="pull-left" style="width: 30%; text-align: center;">
                <p>Mahasiswa,</p>
                <br><br><br>
                <p><b>( <?= $krs['nama_mhs'] ?> )</b></p>
            </div>
            <div class="pull-right" style="width: 40%; text-align: center;">
                <p>Padang, <?= date('d F Y') ?></p>
                <p>Pembimbing Akademik,</p>
                <br><br><br>
                <p><b>( <?= $krs['pembimbing'] ?> )</b></p>
            </div>
        </div>
    </div>

</body>
</html>