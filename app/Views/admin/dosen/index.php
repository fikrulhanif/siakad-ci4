<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.css') ?>">

<section class="content-header">
    <h1><i class="fa fa-briefcase"></i> Data Dosen</h1>
</section>

<section class="content">

    <?php if (session()->getFlashdata('success')): ?>
        <div class="flash-data" data-flashdata="<?= session()->getFlashdata('success') ?>"></div>
    <?php endif; ?>

    <div class="box box-primary shadow">
        <div class="box-header with-border">
            <button class="btn btn-success btn-flat" data-toggle="modal" data-target="#modalTambah">
                <i class="fa fa-plus"></i> Tambah Dosen Baru
            </button>
        </div>

        <div class="box-body">
            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped table-hover">
                    <thead class="bg-navy">
                        <tr>
                            <th width="30" class="text-center">No</th>
                            <th class="text-center">NIDN</th>
                            <th>Nama Dosen</th>
                            <th>Program Studi</th>
                            <th width="100" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
foreach ($dosen as $d) : ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td class="text-center"><b><?= $d['nidn'] ?></b></td>
                            <td><?= esc($d['nama_dosen']) ?></td>
                            <td><span class="label label-default"><i class="fa fa-university"></i> <?= $d['nama_prodi'] ?></span></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button title="Edit" class="btn btn-warning btn-sm btn-flat" data-toggle="modal" data-target="#modalEdit<?= $d['nidn'] ?>">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <a href="<?= site_url('admin/dosen/delete/' . $d['nidn']) ?>" class="btn btn-danger btn-sm btn-flat btn-hapus" title="Hapus">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="modalEdit<?= $d['nidn'] ?>">
                            <div class="modal-dialog">
                                <div class="modal-content border-radius-modal">
                                    <div class="modal-header bg-orange">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Data Dosen</h4>
                                    </div>
                                    <form action="<?= site_url('admin/dosen/update/' . $d['nidn']) ?>" method="post">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>NIDN</label>
                                                <input type="text" class="form-control" value="<?= $d['nidn'] ?>" readonly>
                                                <small class="text-muted">* NIDN tidak dapat diubah (Primary Key)</small>
                                            </div>
                                            <div class="form-group">
                                                <label>Nama Dosen</label>
                                                <input type="text" name="nama_dosen" class="form-control" value="<?= esc($d['nama_dosen']) ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Program Studi</label>
                                                <select name="id_prodi" class="form-control select2" style="width: 100%;" required>
                                                    <?php foreach ($prodi as $p) : ?>
                                                        <option value="<?= $p['id_prodi'] ?>" <?= ($p['id_prodi'] == $d['id_prodi']) ? 'selected' : '' ?>>
                                                            <?= $p['nama_prodi'] ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-gray-light">
                                            <button type="button" class="btn btn-default pull-left btn-flat" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-warning btn-flat">Simpan Perubahan</button>
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
            <div class="modal-content border-radius-modal">
                <div class="modal-header bg-green">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Tambah Dosen</h4>
                </div>
                <form action="<?= site_url('admin/dosen/store') ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>NIDN</label>
                            <input type="text" name="nidn" class="form-control" placeholder="Masukkan NIDN" required>
                        </div>
                        <div class="form-group">
                            <label>Nama Dosen</label>
                            <input type="text" name="nama_dosen" class="form-control" placeholder="Nama Lengkap dengan Gelar" required>
                        </div>
                        <div class="form-group">
                            <label>Program Studi</label>
                            <select name="id_prodi" class="form-control select2" style="width: 100%;" required>
                                <option value="">-- Pilih Program Studi --</option>
                                <?php foreach ($prodi as $p) : ?>
                                    <option value="<?= $p['id_prodi'] ?>"><?= $p['nama_prodi'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="callout callout-info" style="margin-bottom: 0;">
                            <h4><i class="icon fa fa-info"></i> Info Login</h4>
                            <p>Username & Password default akun dosen adalah <b>NIDN</b>.</p>
                        </div>
                    </div>
                    <div class="modal-footer bg-gray-light">
                        <button type="button" class="btn btn-default pull-left btn-flat" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success btn-flat">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>

<style>
    .table > thead > tr > th { vertical-align: middle; border-bottom: 2px solid #333; }
    .shadow { box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24); }
    .btn-flat { border-radius: 0; }
    .modal-content { border-radius: 5px; overflow: hidden; }
    
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
        // Inisialisasi Select2
        if ($.isFunction($.fn.select2)) {
            $('.select2').select2({
                placeholder: "-- Pilih Prodi --",
                allowClear: true
            });
        }

        // Notifikasi Flashdata
        const flashData = $('.flash-data').data('flashdata');
        if (flashData) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: flashData,
                showConfirmButton: false,
                timer: 2000
            });
        }

        // Initialize DataTables
        $('#example1').DataTable({
            columnDefs: [
                { orderable: false, targets: [0, -1] }
            ]
        });

        // Konfirmasi Hapus menggunakan helper global
        $('.btn-hapus').on('click', function(e) {
            e.preventDefault();
            const href = $(this).attr('href');
            const nama = $(this).closest('tr').find('td:eq(2)').text().trim(); // Ambil nama dosen
            confirmDelete(href, `Dosen <strong>${nama}</strong> dan akun loginnya`);
        });
    });
</script>
<?= $this->endSection() ?>