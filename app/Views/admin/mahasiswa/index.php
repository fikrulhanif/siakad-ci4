<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.css') ?>">

<section class="content-header">
    <h1><i class="fa fa-users"></i> Data Mahasiswa</h1>
</section>

<section class="content">

    <?php if (session()->getFlashdata('success')): ?>
        <div class="flash-data" data-flashdata="<?= session()->getFlashdata('success') ?>" data-type="success"></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="flash-data" data-flashdata="<?= session()->getFlashdata('error') ?>" data-type="error"></div>
    <?php endif; ?>

    <div class="box box-primary shadow">
        <div class="box-header with-border">
            <button class="btn btn-success btn-flat" data-toggle="modal" data-target="#modalTambah">
                <i class="fa fa-plus"></i> Tambah Mahasiswa Baru
            </button>
        </div>

        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="example1">
                    <thead class="bg-navy">
                        <tr>
                            <th width="30" class="text-center">No</th>
                            <th class="text-center">NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th>Jenkel</th>
                            <th>Program Studi</th>
                            <th class="text-center">Angkatan</th>
                            <th>Dosen Wali (PA)</th>
                            <th class="text-center">Status</th>
                            <th width="100" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
foreach ($mahasiswa as $m) : ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class="text-center"><b><?= $m['nim'] ?></b></td>
                                <td><?= esc($m['nama_mhs']) ?></td>
                                <td class="text-center"><?= $m['jenkel'] ?></td>
                                <td><small class="label label-default"><?= $m['nama_prodi'] ?></small></td>
                                <td class="text-center"><?= $m['angkatan'] ?></td>
                                <td><i class="fa fa-user-md text-muted"></i> <?= $m['nama_dosen'] ?></td>
                                <td class="text-center">
                                    <?php if ($m['status'] == 'aktif'): ?>
                                        <span class="label label-success"><i class="fa fa-check"></i> Aktif</span>
                                    <?php else: ?>
                                        <span class="label label-danger"><i class="fa fa-times"></i> Non-Aktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button class="btn btn-warning btn-sm btn-flat" data-toggle="modal" data-target="#edit<?= $m['nim'] ?>" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <a href="<?= site_url('admin/mahasiswa/delete/' . $m['nim']) ?>" 
                                           class="btn btn-danger btn-sm btn-flat btn-hapus" title="Hapus">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="edit<?= $m['nim'] ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title">Edit Data Mahasiswa</h4>
                                        </div>
                                        <form action="<?= site_url('admin/mahasiswa/update/' . $m['nim']) ?>" method="post">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>NIM</label>
                                                    <input type="text" class="form-control" value="<?= $m['nim'] ?>" readonly>
                                                    <small class="text-danger">*NIM tidak dapat diubah untuk menjaga relasi data.</small>
                                                </div>
                                                <div class="form-group">
                                                    <label>Nama Mahasiswa</label>
                                                    <input type="text" name="nama_mhs" class="form-control" value="<?= esc($m['nama_mhs']) ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Jenis Kelamin</label>
                                                    <div class="radio">
                                                        <label style="margin-right: 20px;">
                                                            <input type="radio" name="jenkel" value="L" <?= ($m['jenkel'] == 'L') ? 'checked' : '' ?> required> Laki-laki
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="jenkel" value="P" <?= ($m['jenkel'] == 'P') ? 'checked' : '' ?> required> Perempuan
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Program Studi</label>
                                                    <select name="id_prodi" class="form-control" required>
                                                        <?php foreach ($prodi as $p) : ?>
                                                            <option value="<?= $p['id_prodi'] ?>" <?= ($p['id_prodi'] == $m['id_prodi']) ? 'selected' : '' ?>>
                                                                <?= $p['nama_prodi'] ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Angkatan</label>
                                                    <input type="number" name="angkatan" class="form-control" value="<?= $m['angkatan'] ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Dosen Wali (PA)</label>
                                                    <select name="nidn_wali" class="form-control" required>
                                                        <?php foreach ($dosen as $d): ?>
                                                            <option value="<?= $d['nidn'] ?>" <?= ($d['nidn'] == $m['nidn_wali']) ? 'selected' : '' ?>>
                                                                <?= $d['nama_dosen'] ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Status</label>
                                                    <select name="status" class="form-control">
                                                        <option value="aktif" <?= ($m['status'] == 'aktif') ? 'selected' : '' ?>>Aktif</option>
                                                        <option value="nonaktif" <?= ($m['status'] == 'nonaktif') ? 'selected' : '' ?>>Non-Aktif</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTambah">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Tambah Mahasiswa Baru</h4>
                </div>
                <form action="<?= site_url('admin/mahasiswa/store') ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>NIM</label>
                            <input type="text" name="nim" class="form-control" placeholder="Masukkan NIM" required>
                        </div>
                        <div class="form-group">
                            <label>Nama Mahasiswa</label>
                            <input type="text" name="nama_mhs" class="form-control" placeholder="Nama Lengkap" required>
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <div class="radio">
                                <label style="margin-right: 20px;">
                                    <input type="radio" name="jenkel" value="L" required> Laki-laki
                                </label>
                                <label>
                                    <input type="radio" name="jenkel" value="P" required> Perempuan
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Program Studi</label>
                            <select name="id_prodi" class="form-control" required>
                                <option value="">-- Pilih Program Studi --</option>
                                <?php foreach ($prodi as $p) : ?>
                                    <option value="<?= $p['id_prodi'] ?>"><?= $p['nama_prodi'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Angkatan</label>
                            <input type="number" name="angkatan" class="form-control" value="<?= date('Y') ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Dosen Wali (PA)</label>
                            <select name="nidn_wali" class="form-control" required>
                                <option value="">-- Pilih Dosen Wali --</option>
                                <?php foreach ($dosen as $d): ?>
                                    <option value="<?= $d['nidn'] ?>"><?= $d['nama_dosen'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="well well-sm">
                            <p><i class="fa fa-info-circle"></i> <b>Informasi Login:</b></p>
                            <small>Sistem akan otomatis membuatkan akun login dengan:<br>
                            Username: <b>NIM</b><br>
                            Password: <b>NIM (default)</b></small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>

<style>
    .shadow { box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24); }
    .btn-flat { border-radius: 0; }
    .modal-content { border-radius: 5px; overflow: hidden; }
    .bg-navy { background-color: #001f3f !important; color: #fff; }

     #example1 tbody tr {
        transition: 0.2s;
    }

    #example1 tbody tr:hover {
        background-color: #bdbab8ff !important;
    }
</style>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        // Initialize DataTables
        $('#example1').DataTable({
            columnDefs: [
                { orderable: false, targets: [0, -1] } // Disable sort untuk kolom No dan Aksi
            ]
        });

        // Delete Confirmation menggunakan helper global
        $('.btn-hapus').on('click', function(e) {
            e.preventDefault();
            const href = $(this).attr('href');
            const nama = $(this).closest('tr').find('td:eq(2)').text().trim();
            confirmDelete(href, `Mahasiswa <strong>${nama}</strong> dan akses loginnya`);
        });
    });
</script>
<?= $this->endSection() ?>