<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<section class="content-header">
    <h1><i class="fa fa-pencil-square-o text-green"></i> Input Nilai Mahasiswa</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dosen</a></li>
        <li>Nilai</li>
        <li class="active">Input</li>
    </ol>
</section>

<section class="content">
    <div class="box box-solid bg-blue-gradient">
        <div class="box-header">
            <i class="fa fa-info-circle"></i>
            <h3 class="box-title">Informasi Mata Kuliah</h3>
        </div>
        <div class="box-body no-padding">
            <table class="table no-border" style="color: white;">
                <tr>
                    <th width="150">Mata Kuliah</th>
                    <td>: <?= $infoJadwal['nama_mk'] ?> (<?= $infoJadwal['kd_mk'] ?>)</td>
                    <th width="150">SKS / Kelas</th>
                    <td>: <?= $infoJadwal['sks'] ?> SKS / <?= $infoJadwal['kelas'] ?></td>
                </tr>
            </table>
        </div>
    </div>

    <form action="<?= site_url('dosen/nilai/store') ?>" method="post">
        <?= csrf_field() ?>
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title text-bold">Daftar Peserta Kelas</h3>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr class="bg-gray">
                            <th class="text-center" width="50">No</th>
                            <th width="150">NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th class="text-center" width="200">Nilai Angka (0-100)</th>
                            <th class="text-center" width="150">Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mahasiswa as $i => $m) : ?>
                        <tr style="background: linear-gradient(135deg, #f1f8e9 0%, #dcedc8 100%);">
                            <td class="text-center"><?= $i + 1 ?></td>
                            <td><span class="text-bold"><?= $m['nim'] ?></span></td>
                            <td><?= $m['nama_mhs'] ?></td>
                            <td>
                                <input type="hidden" name="id_detail[]" value="<?= $m['id_detail'] ?>">
                                <div class="input-group">
                                    <input type="number" 
                                           name="nilai_angka[]" 
                                           class="form-control input-nilai" 
                                           value="<?= $m['nilai_angka'] ?? 0 ?>" 
                                           min="0" max="100" step="0.01"
                                           data-index="<?= $i ?>">
                                    <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                </div>
                            </td>
                            <td class="text-center">
                                <span id="grade-label-<?= $i ?>" class="badge label-grade" style="font-size: 14px; padding: 5px 15px;">
                                    <?= $m['nilai_huruf'] ?? '-' ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                <div class="pull-right">
                    <a href="<?= site_url('dosen/nilai') ?>" class="btn btn-default btn-flat">Batal</a>
                    <button type="submit" class="btn btn-success btn-flat">
                        <i class="fa fa-save"></i> Simpan Seluruh Nilai
                    </button>
                </div>
            </div>
        </div>
    </form>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('.input-nilai');
        
        inputs.forEach(input => {
            // Jalankan saat halaman load pertama kali
            updateGrade(input);

            // Jalankan setiap kali input berubah
            input.addEventListener('input', function() {
                updateGrade(this);
            });
        });

        function updateGrade(el) {
            const index = el.getAttribute('data-index');
            const val = parseFloat(el.value);
            const label = document.getElementById('grade-label-' + index);
            let grade = 'E';
            let color = 'bg-red';

            if (val >= 85) { grade = 'A'; color = 'bg-green'; }
            else if (val >= 75) { grade = 'B'; color = 'bg-blue'; }
            else if (val >= 65) { grade = 'C'; color = 'bg-yellow'; }
            else if (val >= 50) { grade = 'D'; color = 'bg-orange'; }
            else { grade = 'E'; color = 'bg-red'; }

            if (isNaN(val) || el.value === '') {
                grade = '-';
                color = 'bg-gray';
            }

            label.innerText = grade;
            label.className = 'badge label-grade ' + color;
        }
    });
</script>

<?= $this->endSection() ?>