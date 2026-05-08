<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<section class="content-header">
    <h1>
        Kelola KRS
        <small>Kartu Rencana Studi</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= base_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Kelola KRS</li>
    </ol>
</section>

<section class="content">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fa fa-check"></i> <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fa fa-warning"></i> <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Filter Data KRS</h3>
            </div>
            <div class="box-body">
                <form method="get" action="<?= base_url('admin/krs') ?>" class="form-inline">
                    <div class="form-group">
                        <label>Tahun Akademik:</label>
                        <select name="id_tahun" class="form-control">
                            <option value="">-- Semua --</option>
                            <?php foreach ($tahunAkademik as $ta): ?>
                                <option value="<?= $ta['id_tahun'] ?>" <?= $filterTahun == $ta['id_tahun'] ? 'selected' : '' ?>>
                                    <?= $ta['tahun_ajaran'] ?> - <?= $ta['semester'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Status:</label>
                        <select name="status" class="form-control">
                            <option value="">-- Semua --</option>
                            <option value="Pending" <?= $filterStatus == 'Pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="Approved" <?= $filterStatus == 'Approved' ? 'selected' : '' ?>>Approved</option>
                            <option value="Rejected" <?= $filterStatus == 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>NIM:</label>
                        <input type="text" name="nim" class="form-control" placeholder="Cari NIM" value="<?= $filterNim ?>">
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Filter</button>
                    <a href="<?= base_url('admin/krs') ?>" class="btn btn-default"><i class="fa fa-refresh"></i> Reset</a>
                    <a href="<?= base_url('admin/krs/create') ?>" class="btn btn-success pull-right">
                        <i class="fa fa-plus"></i> Input KRS Manual
                    </a>
                </form>
            </div>
        </div>

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Data KRS Mahasiswa</h3>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-bordered table-striped" id="tableKrs">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th>Prodi</th>
                            <th>Tahun Akademik</th>
                            <th>Tanggal KRS</th>
                            <th>Jumlah MK</th>
                            <th>Total SKS</th>
                            <th>Status</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($krs)): ?>
                            <tr>
                                <td colspan="10" class="text-center">Tidak ada data KRS</td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1;
                            foreach ($krs as $k): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $k['nim'] ?></td>
                                    <td><?= $k['nama_mhs'] ?></td>
                                    <td><?= $k['nama_prodi'] ?></td>
                                    <td><?= $k['tahun_ajaran'] ?> - <?= $k['semester'] ?></td>
                                    <td><?= date('d/m/Y', strtotime($k['tgl_krs'])) ?></td>
                                    <td class="text-center"><?= $k['jumlah_mk'] ?></td>
                                    <td class="text-center"><?= $k['total_sks'] ?? 0 ?></td>
                                    <td>
                                        <?php if ($k['status_krs'] == 'Pending'): ?>
                                            <span class="label label-warning">Pending</span>
                                        <?php elseif ($k['status_krs'] == 'Approved'): ?>
                                            <span class="label label-success">Approved</span>
                                        <?php elseif ($k['status_krs'] == 'Rejected'): ?>
                                            <span class="label label-danger">Rejected</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('admin/krs/detail/' . $k['id_krs']) ?>" class="btn btn-info btn-xs">
                                            <i class="fa fa-eye"></i> Detail
                                        </a>
                                        <a href="<?= base_url('admin/krs/delete/' . $k['id_krs']) ?>" 
                                           class="btn btn-danger btn-xs btn-delete"
                                           data-nama="KRS <?= $k['nama_mhs'] ?>">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</section>

<script>
$(document).ready(function() {
    $('#tableKrs').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "pageLength": 25,
        "order": [[5, 'desc']] // Sort by tanggal KRS descending
    });

    // SweetAlert for delete confirmation
    $('.btn-delete').on('click', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        const nama = $(this).data('nama');
        
        Swal.fire({
            title: 'Hapus Data?',
            html: `Yakin ingin menghapus <strong>${nama}</strong>?<br><small class="text-danger">Data yang dihapus tidak dapat dikembalikan!</small>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
