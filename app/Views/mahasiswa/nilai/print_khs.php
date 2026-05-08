<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak KHS - <?= $krs['nim'] ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>">
    <style>
        /* CSS Khusus Cetak */
        @media print {
            .no-print { display: none !important; } /* Sembunyikan elemen no-print */
            @page { 
                margin: 1.5cm; 
                size: portrait;
            }
            body { font-size: 12px; }
            .table-bordered th, .table-bordered td { border: 1px solid #000 !important; }
        }

        /* Styling Header agar Center */
        .header-kop { 
            border-bottom: 2px solid #000; 
            padding-bottom: 10px; 
            margin-bottom: 20px;
            display: flex; /* Menggunakan flexbox untuk alignment */
            align-items: center;
        }
        .logo-box { width: 15%; }
        .text-box { 
            width: 85%; 
            text-align: center; 
            padding-right: 15%; /* Offset untuk menyeimbangkan posisi logo di kiri */
        }
        .header-kop h3, .header-kop h4, .header-kop p {
            margin: 0;
            padding: 2px 0;
        }

        /* Informasi Mahasiswa */
        .table-info { margin-bottom: 15px; }
        .table-info td { padding: 3px 5px; vertical-align: top; }
        
        /* Tanda Tangan */
        .ttd-container {
            margin-top: 30px;
            float: right;
            width: 250px;
            text-align: center;
        }
    </style>
</head>
<body onload="window.print();">

    <div class="container">
        <div class="header-kop">
            <div class="logo-box">
                <img src="<?= base_url('assets/dist/img/Logo.png') ?>" width="90">
            </div>
            <div class="text-box">
                <h3><b>UNIVERSITAS FIKRUL HANIF</b></h3>
                <h4><b>SISTEM INFORMASI AKADEMIK</b></h4>
            </div>
        </div>

        <h4 class="text-center" style="text-decoration: underline; margin-bottom: 25px;">
            <b>HASIL STUDI MAHASISWA (KHS)</b>
        </h4>

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
                <td>Program Studi</td><td>: <?= $krs['nama_prodi'] ?> (<?= $jenjang ?>)</td>
                <td>Pembimbing Akademik</td><td>: <?= $krs['pembimbing'] ?></td>
            </tr>
        </table>

        <table class="table table-bordered">
            <thead>
                <tr style="background-color: #f9f9f9 !important;">
                    <th class="text-center" width="5%">No</th>
                    <th class="text-center" width="15%">Kode</th>
                    <th class="text-center">Mata Kuliah</th>
                    <th class="text-center" width="8%">SKS</th>
                    <th class="text-center" width="8%">Nilai</th>
                    <th class="text-center" width="8%">Bobot</th>
                    <th class="text-center" width="8%">Mutu</th>
                    <th class="text-center" width="10%">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($detail as $idx => $d) : ?>
                <tr>
                    <td class="text-center"><?= $idx + 1 ?></td>
                    <td class="text-center"><?= $d['kd_mk'] ?></td>
                    <td><?= $d['nama_mk'] ?></td>
                    <td class="text-center"><?= $d['sks'] ?></td>
                    <td class="text-center"><?= $d['nilai_huruf'] ?? '-' ?></td>
                    <td class="text-center"><?php
                        $bobot = match($d['nilai_huruf']) {
                            'A' => 4, 'B' => 3, 'C' => 2, 'D' => 1, default => 0
                        };
                    echo $bobot;
                    ?></td>
                    <td class="text-center"><?= $bobot * $d['sks'] ?></td>
                    <td class="text-center"><?= $d['keterangan'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-right">Total</th>
                    <th class="text-center"><?= $summary['totalSksAmbil'] ?></th>
                    <th colspan="2"></th>
                    <th class="text-center"><?= $summary['totalPoin'] ?></th>
                </tr>
            </tfoot>
        </table>

        <div style="margin-top: 10px;">
            <p>Indeks Prestasi (IP): <b><?= $summary['ips'] ?></b></p>
        </div>

        <div class="ttd-container">
            <p>Padang, <?= date('d F Y') ?></p>
            <p>Ketua Program Studi,</p>
            <br><br><br><br>
            <p><b>( Novinaldi, S.Kom, M.Kom )</b></p>
        </div>
    </div>

</body>
</html>