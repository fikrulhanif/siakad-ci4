<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<section class="content-header">
    <h1><i class="fa fa-list-alt"></i> Laporan Nilai Per Mata Kuliah</h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/laporan') ?>"><i class="fa fa-file-text"></i> Laporan</a></li>
        <li class="active">Nilai Matkul</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-filter"></i> Filter Laporan</h3>
                </div>
                <form action="<?= site_url('admin/laporan/preview-nilai-mk') ?>" method="POST" id="formNilaiMK">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Tahun Akademik</label>
                            <select id="filter_tahun" name="id_tahun" class="form-control" required>
                                <?php foreach ($tahun as $t): ?>
                                    <option value="<?= $t['id_tahun'] ?>" <?= $t['status'] == 'Aktif' ? 'selected' : '' ?>>
                                        <?= $t['tahun_ajaran'] ?> - <?= $t['semester'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Program Studi</label>
                            <select id="filter_prodi" class="form-control" required>
                                <option value="all">-- Semua Prodi --</option>
                                <?php foreach ($prodi as $p): ?>
                                    <option value="<?= $p['id_prodi'] ?>"><?= $p['nama_prodi'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted">Filter untuk melihat matakuliah sesuai kurikulum prodi</small>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label>Pilih Mata Kuliah (Kelas)</label>
                            <select id="select_jadwal" name="id_jadwal" class="form-control" required disabled>
                                <option value="">Silahkan pilih Tahun & Prodi terlebih dahulu...</option>
                            </select>
                            <small class="text-muted">Matakuliah dikelompokkan berdasarkan semester</small>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" id="btn_preview" class="btn btn-primary btn-block" disabled>
                            <i class="fa fa-eye"></i> Tampilkan Preview
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    function loadJadwal() {
        let id_tahun = $('#filter_tahun').val();
        let id_prodi = $('#filter_prodi').val();
        let $select = $('#select_jadwal');

        $select.empty().append('<option>Loading data...</option>').prop('disabled', true);
        $('#btn_preview').prop('disabled', true);

        $.ajax({
            url: "<?= site_url('admin/laporan/get_jadwal_by_filter') ?>",
            type: "POST",
            data: { id_tahun: id_tahun, id_prodi: id_prodi },
            dataType: "JSON",
            success: function(response) {
                $select.empty().prop('disabled', false);
                if (response.length > 0) {
                    $select.append('<option value="">-- Pilih Mata Kuliah --</option>');
                    
                    // Group by semester
                    let bySemester = {};
                    response.forEach(function(item) {
                        if (!bySemester[item.smt]) {
                            bySemester[item.smt] = [];
                        }
                        bySemester[item.smt].push(item);
                    });
                    
                    // Add optgroup for each semester
                    Object.keys(bySemester).sort().forEach(function(smt) {
                        let optgroup = $('<optgroup label="Semester ' + smt + '"></optgroup>');
                        bySemester[smt].forEach(function(item) {
                            optgroup.append(`<option value="${item.id_jadwal}">${item.nama_mk} - Kelas ${item.kelas} (${item.nama_dosen})</option>`);
                        });
                        $select.append(optgroup);
                    });
                    
                    $('#btn_preview').prop('disabled', false);
                } else {
                    $select.append('<option value="">Tidak ada jadwal ditemukan</option>');
                }
            }
        });
    }

    // Trigger saat filter diubah
    $('#filter_tahun, #filter_prodi').on('change', loadJadwal);
    
    // Load pertama kali saat halaman dibuka
    loadJadwal();
});
</script>

<?= $this->endSection() ?>