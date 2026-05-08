<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
    <style>
        @media print { 
            @page { margin: 1.5cm; size: A4 portrait; } 
            body { margin: 0; }
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }
        
        .header-kop {
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .header-kop h2 {
            margin: 5px 0;
            font-size: 18px;
        }
        
        .header-kop h3 {
            margin: 5px 0;
            font-size: 16px;
        }
        
        .info-table {
            width: 100%;
            margin-bottom: 20px;
            font-size: 11px;
        }
        
        .info-table td {
            padding: 3px 5px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        table th,
        table td {
            border: 1px solid #000;
            padding: 8px 5px;
        }
        
        table th {
            background-color: #e0e0e0;
            font-weight: bold;
            text-align: center;
        }
        
        .text-center { text-align: center; }
        
        .footer-info {
            margin-top: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            font-size: 10px;
        }
        
        .footer-print {
            margin-top: 20px;
            font-size: 9px;
            color: #666;
            font-style: italic;
        }
        
        .signature-area {
            margin-top: 40px;
            text-align: right;
            font-size: 11px;
        }
    </style>
</head>
<body onload="window.print()">
    <div style="max-width: 800px; margin: 0 auto;">
        <div class="header-kop">
            <h2><b>UNIVERSITAS FIKRUL HANIF</b></h2>
            <h3><b>DAFTAR PESERTA DAN NILAI AKHIR (DPNA)</b></h3>
        </div>

        <table class="info-table">
            <tr>
                <td width="150"><b>Kode Mata Kuliah</b></td>
                <td width="250">: <?= $info['kd_mk'] ?></td>
                <td width="150"><b>Kelas</b></td>
                <td>: <?= $info['kelas'] ?></td>
            </tr>
            <tr>
                <td><b>Nama Mata Kuliah</b></td>
                <td>: <?= $info['nama_mk'] ?></td>
                <td><b>Semester</b></td>
                <td>: Semester <?= $info['smt'] ?></td>
            </tr>
            <tr>
                <td><b>SKS</b></td>
                <td>: <?= $info['sks'] ?> SKS</td>
                <td><b>Tahun Akademik</b></td>
                <td>: <?= $info['tahun_ajaran'] ?> (<?= $info['semester'] ?>)</td>
            </tr>
            <tr>
                <td><b>Dosen Pengampu</b></td>
                <td>: <?= $info['nama_dosen'] ?></td>
                <td><b>Ruang / Waktu</b></td>
                <td>: <?= $info['ruang'] ?> / <?= $info['hari'] ?>, <?= date('H:i', strtotime($info['jam'])) ?>-<?= date('H:i', strtotime($info['jam_selesai'])) ?></td>
            </tr>
        </table>

        <?php if (empty($peserta)) : ?>
            <p style="text-align: center; padding: 20px; color: #999;">Tidak ada data mahasiswa</p>
        <?php else : ?>
            <table>
                <thead>
                    <tr>
                        <th width="40">No</th>
                        <th width="120">NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th width="150">Program Studi</th>
                        <th width="100">Nilai Angka</th>
                        <th width="100">Nilai Huruf</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sudahDinilai = 0;
            $totalNilai = 0;
            foreach ($peserta as $key => $p):
                if ($p['nilai_angka']) {
                    $sudahDinilai++;
                    $totalNilai += $p['nilai_angka'];
                }
                ?>
                    <tr>
                        <td class="text-center"><?= $key + 1 ?></td>
                        <td class="text-center"><?= $p['nim'] ?></td>
                        <td><?= $p['nama_mhs'] ?></td>
                        <td><?= $p['nama_prodi'] ?></td>
                        <td class="text-center"><?= $p['nilai_angka'] ?? '-' ?></td>
                        <td class="text-center"><b><?= $p['nilai_huruf'] ?? '-' ?></b></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot style="background-color: #e0e0e0;">
                    <tr>
                        <td colspan="6" class="text-center">
                            <b>Total Mahasiswa: <?= count($peserta) ?> | Sudah Dinilai: <?= $sudahDinilai ?> | Belum Dinilai: <?= count($peserta) - $sudahDinilai ?></b>
                        </td>
                    </tr>
                </tfoot>
            </table>

            <div class="footer-info">
                <b>Statistik Nilai:</b><br>
                Total Mahasiswa: <?= count($peserta) ?> Mahasiswa<br>
                Sudah Dinilai: <?= $sudahDinilai ?> Mahasiswa<br>
                Rata-rata Nilai: <?= $sudahDinilai > 0 ? number_format($totalNilai / $sudahDinilai, 2) : '0.00' ?>
            </div>
        <?php endif; ?>

        <div class="signature-area">
            <p>Padang, <?= date('d F Y') ?></p>
            <p>Dosen Pengampu,</p>
            <br><br><br>
            <p><b><?= $info['nama_dosen'] ?></b></p>
        </div>

        <div class="footer-print">
            Dicetak otomatis oleh Sistem Informasi Akademik pada <?= date('d/m/Y H:i:s') ?>
        </div>
    </div>
</body>
</html>