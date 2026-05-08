<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<section class="content-header">
    <h1><i class="fa fa-trophy"></i> Laporan Prestasi Mahasiswa</h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/laporan') ?>"><i class="fa fa-file-text"></i> Laporan</a></li>
        <li class="active">Prestasi</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-filter"></i> Filter Laporan</h3>
                </div>
                <form action="<?= site_url('admin/laporan/preview-nilai') ?>" method="POST">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Tahun Akademik</label>
                            <select name="id_tahun" class="form-control" required>
                                <?php foreach ($tahun as $t): ?>
                                    <option value="<?= $t['id_tahun'] ?>" <?= ($t['status'] == 'Aktif') ? 'selected' : '' ?>>
                                        <?= $t['tahun_ajaran'] ?> - <?= $t['semester'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Program Studi</label>
                            <select name="id_prodi" class="form-control" required>
                                <option value="all">-- Semua Program Studi --</option>
                                <?php foreach ($prodi as $p): ?>
                                    <option value="<?= $p['id_prodi'] ?>"><?= $p['nama_prodi'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fa fa-eye"></i> Tampilkan Preview
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>