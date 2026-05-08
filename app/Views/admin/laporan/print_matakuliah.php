<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
    <style>
        @media print { 
            @page { margin: 1.5cm; size: portrait; } 
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
            padding: 8px 5px;
        }
        
        table th {
            background-color: #e0e0e0;
            font-weight: bold;
            text-align: center;
        }
        
        .group-header {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: left;
            padding: 8px 10px !important;
        }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        
        .footer-info {
            margin-top: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }
        
        .footer-print {
            margin-top: 20px;
            font-size: 9px;
            color: #666;
            font-style: italic;
        }
    </style>
</head>
<body onload="window.print();">
    <div style="max-width: 800px; margin: 0 auto;">
        <div class="header-kop">
            <h2><b>UNIVERSITAS FIKRUL HANIF</b></h2>
            <h3><b>LAPORAN DATA MATA KULIAH</b></h3>
            <p><b>Program Studi: <?= $prodi_text ?></b></p>
        </div>

        <?php if (empty($mk)) : ?>
            <p style="text-align: center; padding: 20px; color: #999;">Tidak ada data mata kuliah</p>
        <?php else : ?>
            <?php
            // Group by semester
            $mkBySemester = [];
            foreach ($mk as $m) {
                $smt = $m['semester_prodi'] ?? $m['smt'];
                $mkBySemester[$smt][] = $m;
            }
            ksort($mkBySemester);

            $totalSKS = 0;
            $no = 1;
            ?>

            <table>
                <thead>
                    <tr>
                        <th width="40">No</th>
                        <th width="100">Kode MK</th>
                        <th>Nama Mata Kuliah</th>
                        <th width="60">SKS</th>
                        <th width="80">Sifat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($mkBySemester as $smt => $matakuliah) : ?>
                        <tr>
                            <td colspan="5" class="group-header">SEMESTER <?= $smt ?></td>
                        </tr>
                        <?php
                        $sksSemester = 0;
                        foreach ($matakuliah as $m) :
                            $sksSemester += (int)$m['sks'];
                            $totalSKS += (int)$m['sks'];
                            ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td class="text-center"><b><?= $m['kd_mk'] ?></b></td>
                            <td><?= $m['nama_mk'] ?></td>
                            <td class="text-center"><?= $m['sks'] ?></td>
                            <td class="text-center"><?= $m['is_wajib'] == 1 ? 'Wajib' : 'Pilihan' ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <tr style="background-color: #f5f5f5;">
                            <td colspan="3" class="text-right"><b>Total SKS Semester <?= $smt ?>:</b></td>
                            <td class="text-center"><b><?= $sksSemester ?></b></td>
                            <td></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot style="background-color: #e0e0e0;">
                    <tr>
                        <td colspan="3" class="text-right"><b>TOTAL KESELURUHAN:</b></td>
                        <td class="text-center"><b><?= $totalSKS ?> SKS</b></td>
                        <td class="text-center"><b><?= count($mk) ?> MK</b></td>
                    </tr>
                </tfoot>
            </table>

            <div class="footer-info">
                <b>Ringkasan:</b><br>
                Total Mata Kuliah: <?= count($mk) ?> Mata Kuliah<br>
                Total SKS: <?= $totalSKS ?> SKS<br>
                Jumlah Semester: <?= count($mkBySemester) ?> Semester
            </div>
        <?php endif; ?>

        <div class="footer-print">
            Dicetak otomatis oleh Sistem Informasi Akademik pada <?= date('d/m/Y H:i:s') ?>
        </div>
    </div>
</body>
</html>