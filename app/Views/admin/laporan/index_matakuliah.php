<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<section class="content-header">
    <h1><i class="fa fa-book"></i> Laporan Mata Kuliah</h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/laporan') ?>"><i class="fa fa-file-text"></i> Laporan</a></li>
        <li class="active">Mata Kuliah</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-4">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-filter"></i> Filter Laporan</h3>
                </div>
                <form action="<?= site_url('admin/laporan/preview-matakuliah') ?>" method="POST" id="formFilter">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Program Studi</label>
                            <select name="id_prodi" id="id_prodi" class="form-control" required>
                                <option value="all">-- Semua Program Studi --</option>
                                <?php foreach ($prodi as $p): ?>
                                    <option value="<?= $p['id_prodi'] ?>"><?= $p['nama_prodi'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted">Pilih prodi untuk melihat kurikulum sesuai prodi</small>
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
