<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.css') ?>">

<section class="content-header">
    <h1><i class="fa fa-calendar"></i> Pengaturan Tahun Akademik</h1>
</section>

<section class="content">

    <?php if (session()->getFlashdata('success')): ?>
        <div class="flash-data" data-flashdata="<?= session()->getFlashdata('success') ?>"></div>
    <?php endif; ?>

    <div class="box box-primary shadow">
        <div class="box-header with-border">
            <button class="btn btn-success btn-flat" data-toggle="modal" data-target="#modalTambah">
                <i class="fa fa-plus"></i> Tambah Tahun Akademik
            </button>
            <div class="pull-right">
                <span class="text-muted"><i class="fa fa-info-circle"></i> Hanya satu semester yang dapat berstatus <b>Aktif</b>.</span>
            </div>
        </div>

        <div class="box-body">
            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped table-hover">
                    <thead class="bg-navy">
                        <tr>
                            <th width="30" class="text-center">No</th>
                            <th class="text-center">Tahun Ajaran</th>
                            <th class="text-center">Semester</th>
                            <th class="text-center">Status Sistem</th>
                            <th width="180" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
foreach ($ta as $t) : ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td class="text-center"><b><?= $t['tahun_ajaran'] ?></b></td>
                            <td class="text-center">
                                <span class="label <?= $t['semester'] == 'Ganjil' ? 'bg-red' : 'bg-purple' ?>">
                                    <?= strtoupper($t['semester']) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <?php if ($t['status'] == 'Aktif'): ?>
                                    <span class="label label-success shadow-sm"><i class="fa fa-check-circle"></i> sedang digunakan</span>
                                <?php else: ?>
                                    <span class="label label-default text-muted">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if ($t['status'] == 'Nonaktif'): ?>
                                    <a href="<?= site_url('admin/tahun-akademik/set-aktif/' . $t['id_tahun']) ?>" 
                                       class="btn btn-primary btn-sm btn-flat btn-aktifkan">
                                        <i class="fa fa-power-off"></i> Aktifkan
                                    </a>
                                <?php else: ?>
                                    <button class="btn btn-success btn-sm btn-flat disabled">
                                        <i class="fa fa-check"></i> Aktif
                                    </button>
                                <?php endif; ?>
                                
                                <a href="<?= site_url('admin/tahun-akademik/delete/' . $t['id_tahun']) ?>" 
                                   class="btn btn-danger btn-sm btn-flat btn-hapus">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box-footer">
            <small class="text-danger">* Menghapus tahun akademik yang sudah memiliki data nilai/KRS akan menyebabkan error pada laporan mahasiswa.</small>
        </div>
    </div>

        <div class="modal fade" id="modalTambah">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"><h4 class="modal-title">Tambah Tahun Akademik</h4></div>
                <form action="<?= site_url('admin/tahun-akademik/store') ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Tahun Ajaran</label>
                            <input type="text" name="tahun_ajaran" class="form-control" placeholder="Contoh: 2024/2025" required>
                        </div>
                        <div class="form-group">
                            <label>Semester</label>
                            <select name="semester" class="form-control" required>
                                <option value="Ganjil">Ganjil</option>
                                <option value="Genap">Genap</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan</button>
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
<script src="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<script>
    $(document).ready(function() {
        // DataTables
        $('#example1').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
            },
            "pageLength": 25
        });

        // Notifikasi Berhasil
        const flashData = $('.flash-data').data('flashdata');
        if (flashData) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: flashData,
                showConfirmButton: false,
                timer: 2000
            });
        }

        // Konfirmasi Aktifkan Semester
        $('.btn-aktifkan').on('click', function(e) {
            e.preventDefault();
            const href = $(this).attr('href');

            Swal.fire({
                title: 'Aktifkan Semester?',
                text: "Semester lain akan otomatis dinonaktifkan dari sistem.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Aktifkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = href;
                }
            })
        });

        // Konfirmasi Hapus
        $('.btn-hapus').on('click', function(e) {
            e.preventDefault();
            const href = $(this).attr('href');

            Swal.fire({
                title: 'Hapus Data?',
                text: "Pastikan tidak ada data KRS yang menggunakan tahun akademik ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Hapus Sekarang',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = href;
                }
            })
        });
    });
</script>
<?= $this->endSection() ?>