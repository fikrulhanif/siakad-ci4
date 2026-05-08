<!DOCTYPE html>
<html>
<head>
    <title>Absensi - <?= $j['nama_mk'] ?></title>
    <style>
        @media print { 
            @page { 
                margin: 1.5cm; 
                size: A4 landscape; 
            }
            body { margin: 0; }
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }
        
        .header-kop {
            border-bottom: 3px solid #000;
            margin-bottom: 15px;
            padding-bottom: 10px;
            display: flex;
            align-items: center;
        }
        
        .header-kop img {
            width: 80px;
            margin-right: 20px;
        }
        
        .header-text {
            flex: 1;
            text-align: center;
        }
        
        .header-text h2 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        
        .header-text h3 {
            margin: 5px 0 0 0;
            font-size: 16px;
            font-weight: bold;
        }
        
        .header-text h4 {
            margin: 10px 0 0 0;
            font-size: 14px;
            font-weight: bold;
        }
        
        .kelas-badge {
            position: absolute;
            right: 30px;
            top: 80px;
            font-size: 48px;
            font-weight: bold;
            border: 3px solid #000;
            padding: 10px 25px;
            background: #f0f0f0;
        }
        
        .info-table {
            width: 100%;
            margin-bottom: 15px;
            font-size: 11px;
        }
        
        .info-table td {
            padding: 3px 5px;
        }
        
        .table-absensi {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }
        
        .table-absensi th,
        .table-absensi td {
            border: 1px solid #000;
            padding: 5px 3px;
            text-align: center;
        }
        
        .table-absensi th {
            background-color: #e0e0e0;
            font-weight: bold;
        }
        
        .table-absensi .col-no { width: 30px; }
        .table-absensi .col-nobp { width: 70px; }
        .table-absensi .col-nama { width: 180px; text-align: left; }
        .table-absensi .col-pertemuan { width: 25px; }
        .table-absensi .col-uts { width: 60px; }
        .table-absensi .col-uas { width: 60px; }
        
        .footer-note {
            margin-top: 10px;
            font-size: 9px;
        }
        
        .footer-signature {
            margin-top: 30px;
            text-align: right;
            font-size: 11px;
        }
        
        .form-code {
            position: absolute;
            bottom: 20px;
            left: 30px;
            font-size: 9px;
        }
    </style>
</head>
<body onload="window.print();">
    <div style="position: relative;">
        <!-- Header -->
        <div class="header-kop">
            <img src="<?= base_url('assets/dist/img/Logo.png') ?>" alt="Logo">
            <div class="header-text">
                <h2>UNIVERSITAS FIKRUL HANIF</h2>
                <h4>DAFTAR HADIR MAHASISWA</h4>
                <h4>SEMESTER <?= strtoupper($j['semester']) ?> <?= $j['tahun_ajaran'] ?></h4>
            </div>
        </div>
        
        <!-- Kelas Badge -->
        <div class="kelas-badge"><?= $j['kelas'] ?></div>
        
        <!-- Info Mata Kuliah -->
        <table class="info-table">
            <tr>
                <td width="120"><b>Kelas/Dosen</b></td>
                <td width="350">: <?= $j['kd_mk'] ?>-<?= $j['kelas'] ?> / <?= $j['nama_dosen'] ?></td>
            </tr>
            <tr>
                <td><b>Matakuliah</b></td>
                <td>: <?= strtoupper($j['nama_mk']) ?> [<?= $j['kd_mk'] ?>]</td>
            </tr>
            <tr>
                <td><b>Hari/Jam/Ruang</b></td>
                <td>: <?= $j['hari'] ?> / <?= date('H.i', strtotime($j['jam'])) ?>-<?= date('H.i', strtotime($j['jam_selesai'])) ?> / <?= $j['ruang'] ?></td>
            </tr>
        </table>
        
        <!-- Tabel Absensi -->
        <table class="table-absensi">
            <thead>
                <tr>
                    <th rowspan="2" class="col-no">No</th>
                    <th rowspan="2" class="col-nobp">No.BP</th>
                    <th rowspan="2" class="col-nama">Nama</th>
                    <th colspan="7">Pertemuan</th>
                    <th rowspan="2" class="col-uts">UTS<br>Absen</th>
                    <th colspan="7">Pertemuan</th>
                    <th rowspan="2" class="col-uas">UAS<br>Jml<br>Absen</th>
                </tr>
                <tr>
                    <?php for ($i = 1; $i <= 7; $i++): ?>
                        <th class="col-pertemuan"><?= $i ?></th>
                    <?php endfor; ?>
                    <?php for ($i = 8; $i <= 14; $i++): ?>
                        <th class="col-pertemuan"><?= $i ?></th>
                    <?php endfor; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($peserta as $idx => $p) : ?>
                <tr>
                    <td><?= $idx + 1 ?></td>
                    <td><?= $p['nim'] ?></td>
                    <td style="text-align: left; padding-left: 5px;"><?= strtoupper($p['nama_mhs']) ?></td>
                    <?php for ($i = 1; $i <= 7; $i++): ?>
                        <td style="height: 25px;"></td>
                    <?php endfor; ?>
                    <td></td>
                    <?php for ($i = 8; $i <= 14; $i++): ?>
                        <td style="height: 25px;"></td>
                    <?php endfor; ?>
                    <td></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <!-- Footer -->
        <div class="footer-note">
            Cat : Absen Yang Ditulis Dengan Tulisan Tangan Tidak Diakui
        </div>
        
        <div class="footer-signature">
            Padang, <?= date('d-m-Y') ?>
        </div>
        
        <div class="form-code">
            FM-FM-07/21
        </div>
    </div>
</body>
</html>