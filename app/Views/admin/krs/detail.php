<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<section class="content-header">
    <h1>
        Detail KRS
        <small><?= $krs['nama_mhs'] ?></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= base_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?= base_url('admin/krs') ?>">Kelola KRS</a></li>
        <li class="active">Detail</li>
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

        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Informasi Mahasiswa</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tr>
                                <th width="150">NIM</th>
                                <td><?= $krs['nim'] ?></td>
                            </tr>
                            <tr>
                                <th>Nama</th>
                                <td><?= $krs['nama_mhs'] ?></td>
                            </tr>
                            <tr>
                                <th>Prodi</th>
                                <td><?= $krs['nama_prodi'] ?></td>
                            </tr>
                            <tr>
                                <th>Angkatan</th>
                                <td><?= $krs['angkatan'] ?></td>
                            </tr>
                            <tr>
                                <th>Dosen PA</th>
                                <td><?= $krs['nama_pa'] ?? '-' ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Informasi KRS</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tr>
                                <th width="150">Tahun Akademik</th>
                                <td><?= $krs['tahun_ajaran'] ?> - <?= $krs['semester'] ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal KRS</th>
                                <td><?= date('d/m/Y', strtotime($krs['tgl_krs'])) ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <?php if ($krs['status_krs'] == 'Pending'): ?>
                                        <span class="label label-warning">Pending</span>
                                    <?php elseif ($krs['status_krs'] == 'Approved'): ?>
                                        <span class="label label-success">Approved</span>
                                    <?php elseif ($krs['status_krs'] == 'Rejected'): ?>
                                        <span class="label label-danger">Rejected</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Total SKS</th>
                                <td>
                                    <strong>
                                        <?php
                                        $totalSks = 0;
foreach ($detailKrs as $dk) {
    $totalSks += $dk['sks'];
}
echo $totalSks;
?> SKS
                                    </strong>
                                </td>
                            </tr>
                            <?php if ($krs['catatan_pa']): ?>
                                <tr>
                                    <th>Catatan</th>
                                    <td><?= $krs['catatan_pa'] ?></td>
                                </tr>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Update Status KRS</h3>
            </div>
            <div class="box-body">
                <form method="post" action="<?= base_url('admin/krs/update_status/' . $krs['id_krs']) ?>">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Status KRS</label>
                                <select name="status_krs" class="form-control" required>
                                    <option value="Pending" <?= $krs['status_krs'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="Approved" <?= $krs['status_krs'] == 'Approved' ? 'selected' : '' ?>>Approved</option>
                                    <option value="Rejected" <?= $krs['status_krs'] == 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Catatan (Opsional)</label>
                                <input type="text" name="catatan_pa" class="form-control" 
                                       placeholder="Catatan untuk mahasiswa" value="<?= $krs['catatan_pa'] ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-success btn-block">
                                <i class="fa fa-save"></i> Update Status
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Daftar Mata Kuliah</h3>
                <div class="box-tools">
                    <form method="post" action="<?= base_url('admin/krs/pilih_matakuliah') ?>" style="display:inline;">
                        <input type="hidden" name="nim" value="<?= $krs['nim'] ?>">
                        <input type="hidden" name="id_tahun" value="<?= $krs['id_tahun'] ?>">
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fa fa-plus"></i> Tambah Mata Kuliah
                        </button>
                    </form>
                </div>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Kode MK</th>
                            <th>Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Kelas</th>
                            <th>Dosen</th>
                            <th>Hari</th>
                            <th>Jam</th>
                            <th>Ruang</th>
                            <th>Kapasitas</th>
                            <th width="80">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($detailKrs)): ?>
                            <tr>
                                <td colspan="11" class="text-center">Belum ada mata kuliah yang diambil</td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1;
                            foreach ($detailKrs as $dk): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $dk['kd_mk'] ?></td>
                                    <td><?= $dk['nama_mk'] ?></td>
                                    <td class="text-center"><?= $dk['sks'] ?></td>
                                    <td><?= $dk['kelas'] ?></td>
                                    <td><?= $dk['nama_dosen'] ?></td>
                                    <td><?= $dk['hari'] ?></td>
                                    <td><?= date('H:i', strtotime($dk['jam'])) ?> - <?= date('H:i', strtotime($dk['jam_selesai'])) ?></td>
                                    <td><?= $dk['ruang'] ?></td>
                                    <td class="text-center">
                                        <?= $dk['terisi'] ?>/<?= $dk['kapasitas'] ?>
                                        <?php if ($dk['terisi'] >= $dk['kapasitas']): ?>
                                            <span class="label label-danger">Penuh</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('admin/krs/delete_item/' . $dk['id_detail']) ?>" 
                                           class="btn btn-danger btn-xs btn-delete-item"
                                           data-nama="<?= $dk['nama_mk'] ?>">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                    <?php if (!empty($detailKrs)): ?>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-right">Total SKS:</th>
                                <th class="text-center"><?= $totalSks ?></th>
                                <th colspan="7"></th>
                            </tr>
                        </tfoot>
                    <?php endif; ?>
                </table>
            </div>
        </div>

        <?php if (!empty($detailKrs)): ?>
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Jadwal Visual (Grid)</h3>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="100">Jam</th>
                                <?php foreach ($listHari as $hari): ?>
                                    <th><?= $hari ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($listJam as $jam): ?>
                                <tr>
                                    <td><strong><?= $jam ?></strong></td>
                                    <?php foreach ($listHari as $hari): ?>
                                        <td>
                                            <?php if (isset($jadwalGrid[$hari][$jam])): ?>
                                                <?php $mk = $jadwalGrid[$hari][$jam]; ?>
                                                <div class="alert alert-info" style="margin:0; padding:5px;">
                                                    <strong><?= $mk['nama_mk'] ?></strong><br>
                                                    <small><?= $mk['kelas'] ?> | <?= $mk['ruang'] ?></small><br>
                                                    <small><?= $mk['nama_dosen'] ?></small>
                                                </div>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>

        <div class="box-footer">
            <a href="<?= base_url('admin/krs') ?>" class="btn btn-default">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
    </section>
</section>

<script>
$(document).ready(function() {
    // SweetAlert for delete item confirmation
    $('.btn-delete-item').on('click', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        const nama = $(this).data('nama');
        
        Swal.fire({
            title: 'Hapus Mata Kuliah?',
            html: `Yakin ingin menghapus <strong>${nama}</strong> dari KRS?`,
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
