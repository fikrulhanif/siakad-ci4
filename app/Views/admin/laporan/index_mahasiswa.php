<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<section class="content-header">
    <h1><i class="fa fa-users"></i> Laporan Data Mahasiswa</h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('admin/laporan') ?>"><i class="fa fa-file-text"></i> Laporan</a></li>
        <li class="active">Mahasiswa</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-filter"></i> Filter Laporan</h3>
                </div>
                <form action="<?= site_url('admin/laporan/preview-mahasiswa') ?>" method="POST">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Program Studi</label>
                            <select name="id_prodi" class="form-control" required>
                                <option value="all">-- Semua Program Studi --</option>
                                <?php foreach ($prodi as $p): ?>
                                    <option value="<?= $p['id_prodi'] ?>"><?= $p['nama_prodi'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Angkatan</label>
                            <select name="angkatan" class="form-control" required>
                                <option value="all">-- Semua Angkatan --</option>
                                <?php
                                $thn_skrg = date('Y');
for ($i = $thn_skrg; $i >= ($thn_skrg - 5); $i--): ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor; ?>
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