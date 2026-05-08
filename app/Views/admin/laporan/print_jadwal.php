<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
    <style>
        @media print { 
            @page { margin: 1.5cm; size: A4 landscape; } 
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
        
        .header-kop p {
            margin: 5px 0;
            font-size: 12px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        table th,
        table td {
            border: 1px solid #000;
            padding: 6px 4px;
        }
        
        table th {
            background-color: #e0e0e0;
            font-weight: bold;
            text-align: center;
            font-size: 11px;
        }
        
        .group-header {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: left;
            padding: 8px 10px !important;
        }
        
        .text-center { text-align: center; }
        
        .footer-print {
            margin-top: 20px;
            font-size: 9px;
            color: #666;
            font-style: italic;
        }
    </style>
</head>
<body onload="window.print();">
    <div style="max-width: 1000px; margin: 0 auto;">
        <div class="header-kop">
            <h2><b>UNIVERSITAS FIKRUL HANIF</b></h2>
            <h3><b>LAPORAN JADWAL PERKULIAHAN</b></h3>
            <p><b>Tahun Akademik: <?= $ta ?> | Program Studi: <?= $prodi ?></b></p>
        </div>

        <?php if (empty($jadwal)) : ?>
            <p style="text-align: center; padding: 20px; color: #999;">Tidak ada data jadwal</p>
        <?php else : ?>
            <?php
            // Group by hari
            $jadwalByHari = [];
            foreach ($jadwal as $j) {
                $jadwalByHari[$j['hari']][] = $j;
            }
            $urutanHari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

            $no = 1;
            ?>

            <table>
                <thead>
                    <tr>
                        <th width="30">No</th>
                        <th width="100">Kode MK</th>
                        <th>Mata Kuliah</th>
                        <th width="40">SKS</th>
                        <th width="50">Kelas</th>
                        <th width="100">Waktu</th>
                        <th width="70">Ruang</th>
                        <th width="150">Dosen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($urutanHari as $hari) : ?>
                        <?php if (isset($jadwalByHari[$hari])) : ?>
                            <tr>
                                <td colspan="8" class="group-header"><?= strtoupper($hari) ?></td>
                            </tr>
                            <?php foreach ($jadwalByHari[$hari] as $j) : ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class="text-center"><b><?= $j['kd_mk'] ?></b></td>
                                <td><?= $j['nama_mk'] ?></td>
                                <td class="text-center"><?= $j['sks'] ?></td>
                                <td class="text-center"><?= $j['kelas'] ?></td>
                                <td class="text-center"><?= date('H:i', strtotime($j['jam'])) ?> - <?= date('H:i', strtotime($j['jam_selesai'])) ?></td>
                                <td class="text-center"><?= $j['ruang'] ?></td>
                                <td><?= $j['nama_dosen'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
                <tfoot style="background-color: #e0e0e0;">
                    <tr>
                        <td colspan="8" class="text-center"><b>TOTAL: <?= count($jadwal) ?> Kelas</b></td>
                    </tr>
                </tfoot>
            </table>
        <?php endif; ?>

        <div class="footer-print">
            Dicetak otomatis oleh Sistem Informasi Akademik pada <?= date('d/m/Y H:i:s') ?>
        </div>
    </div>
</body>
</html>