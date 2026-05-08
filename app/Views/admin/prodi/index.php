<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.css') ?>">

<section class="content-header">
    <h1><i class="fa fa-university"></i> Data Program Studi</h1>
</section>

<section class="content">

    <?php if (session()->getFlashdata('success')): ?>
        <div class="flash-data" data-flashdata="<?= session()->getFlashdata('success') ?>"></div>
    <?php endif; ?>

    <div class="box box-primary shadow">
        <div class="box-header with-border">
            <button class="btn btn-success btn-flat" data-toggle="modal" data-target="#modalTambah">
                <i class="fa fa-plus"></i> Tambah Program Studi
            </button>
        </div>

        <div class="box-body">
            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped table-hover">
                    <thead class="bg-navy">
                        <tr>
                            <th width="50" class="text-center">No</th>
                            <th>Nama Program Studi</th>
                            <th width="120" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
foreach ($prodi as $p): ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><b><?= esc($p['nama_prodi']) ?></b></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button title="Edit" class="btn btn-warning btn-sm btn-flat" data-toggle="modal" data-target="#modalEdit<?= $p['id_prodi'] ?>">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <a href="<?= site_url('admin/prodi/delete/'.$p['id_prodi']) ?>" class="btn btn-danger btn-sm btn-flat btn-hapus" title="Hapus">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="modalEdit<?= $p['id_prodi'] ?>">
                            <div class="modal-dialog">
                                <div class="modal-content border-radius-modal">
                                    <div class="modal-header bg-orange">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Program Studi</h4>
                                    </div>
                                    <form action="<?= site_url('admin/prodi/update/'.$p['id_prodi']) ?>" method="post">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Nama Program Studi</label>
                                                <input type="text" name="nama_prodi" class="form-control" value="<?= esc($p['nama_prodi']) ?>" required placeholder="Masukkan Nama Prodi">
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
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Tambah Program Studi Baru</h4>
                </div>
                <form action="<?= site_url('admin/prodi/store') ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Program Studi</label>
                            <input type="text" name="nama_prodi" class="form-control" placeholder="Contoh: Teknik Informatika" required>
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

        // Konfirmasi Hapus
        $('.btn-hapus').on('click', function(e) {
            e.preventDefault();
            const href = $(this).attr('href');

            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data Program Studi ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.location.href = href;
                }
            })
        });
    });
</script>
<?= $this->endSection() ?>