<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>">
    <style>
        @media print { @page { margin: 1cm; size: portrait; } }
        .header-kop { border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 10px; text-align: center; }
        .filter-info { margin-bottom: 20px; font-style: italic; }
    </style>
</head>
<body onload="window.print();">
    <div class="container">
        <div class="header-kop">
            <h3><b>UNIVERSITAS FIKRUL HANIF</b></h3>
            <h4><b>LAPORAN DATA MAHASISWA</b></h4>
        </div>

        <div class="filter-info">
            Filter: Prodi <b><?= $prodi_text ?></b> | Angkatan <b><?= $angkatan == 'all' ? 'Semua' : $angkatan ?></b>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="30" class="text-center">No</th>
                    <th class="text-center">NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th class="text-center">L/P</th>
                    <th>Program Studi</th>
                    <th class="text-center">Angkatan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($mhs)): ?>
                    <tr><td colspan="6" class="text-center">Data tidak ditemukan</td></tr>
                <?php endif; ?>
                <?php foreach ($mhs as $idx => $m) : ?>
                <tr>
                    <td class="text-center"><?= $idx + 1 ?></td>
                    <td class="text-center"><?= $m['nim'] ?></td>
                    <td><?= $m['nama_mhs'] ?></td>
                    <td class="text-center"><?= $m['jenkel'] ?></td>
                    <td><?= $m['nama_prodi'] ?></td>
                    <td class="text-center"><?= $m['angkatan'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>