<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<section class="content-header">
    <h1>
        Input KRS Manual
        <small>Untuk kasus khusus</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= base_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?= base_url('admin/krs') ?>">Kelola KRS</a></li>
        <li class="active">Input Manual</li>
    </ol>
</section>

<section class="content">
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fa fa-warning"></i> <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Pilih Mahasiswa</h3>
            </div>
            <form method="post" action="<?= base_url('admin/krs/pilih_matakuliah') ?>">
                <div class="box-body">
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> 
                        <strong>Fitur Khusus Admin:</strong> Anda dapat menginput KRS untuk mahasiswa dengan opsi bypass kapasitas dan bentrok jadwal.
                        Gunakan fitur ini dengan bijak untuk kasus-kasus khusus.
                    </div>

                    <div class="form-group">
                        <label>Pilih Mahasiswa <span class="text-danger">*</span></label>
                        <select name="nim" class="form-control select2" required style="width: 100%;">
                            <option value="">-- Pilih Mahasiswa --</option>
                            <?php foreach ($mahasiswa as $mhs): ?>
                                <option value="<?= $mhs['nim'] ?>">
                                    <?= $mhs['nim'] ?> - <?= $mhs['nama_mhs'] ?> (<?= $mhs['nama_prodi'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tahun Akademik <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" readonly 
                               value="<?= $taAktif['tahun_ajaran'] ?> - <?= $taAktif['semester'] ?>">
                        <input type="hidden" name="id_tahun" value="<?= $taAktif['id_tahun'] ?>">
                    </div>

                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="bypass_kapasitas" value="1">
                                <strong>Bypass Kapasitas Kelas</strong> - Izinkan input meskipun kelas penuh
                            </label>
                        </div>
                        <small class="text-muted">
                            Centang ini jika mahasiswa perlu ditambahkan ke kelas yang sudah penuh (misal: ada persetujuan khusus dari fakultas)
                        </small>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-arrow-right"></i> Lanjut Pilih Mata Kuliah
                    </button>
                    <a href="<?= base_url('admin/krs') ?>" class="btn btn-default">
                        <i class="fa fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </section>
</section>

<script>
$(document).ready(function() {
    $('.select2').select2({
        placeholder: "-- Pilih Mahasiswa --",
        allowClear: true
    });
});
</script>
<?= $this->endSection() ?>
