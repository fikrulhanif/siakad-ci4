<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.css') ?>">

<section class="content-header">
    <h1><i class="fa fa-calendar-check-o"></i> Penjadwalan Kuliah</h1>
    <p>Semester Aktif: <span class="label label-primary"><?= $taAktif['tahun_ajaran'] ?> - <?= $taAktif['semester'] ?></span></p>
</section>

<section class="content">

    <?php if (session()->getFlashdata('success')): ?>
        <div class="flash-data" data-flashdata="<?= session()->getFlashdata('success') ?>"></div>
    <?php endif; ?>

    <div class="box box-primary shadow"> <div class="box-header with-border">
            <div class="row">
                <div class="col-md-8">
                    <button class="btn btn-success btn-flat" data-toggle="modal" data-target="#modalTambah">
                        <i class="fa fa-plus"></i> Buat Jadwal Baru
                    </button>
                    <a href="<?= site_url('admin/jadwal/copy_jadwal') ?>" class="btn btn-info btn-flat btn-copy">
                        <i class="fa fa-copy"></i> Salin Jadwal Semester Lalu
                    </a>
                </div>
                
                <div class="col-md-4">
                    <form action="<?= site_url('admin/jadwal') ?>" method="get" class="form-inline pull-right">
                        <div class="input-group">
                            <span class="input-group-addon bg-gray"><i class="fa fa-filter"></i>Filter Semester</span>
                            <select name="filter_smt" class="form-control select2" onchange="this.form.submit()">
                                <option value="">Semua</option>
                                <?php foreach ($smtList as $s) : ?>
                                    <option value="<?= $s ?>" <?= ($filterSmt == $s) ? 'selected' : '' ?>>Semester <?= $s ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php if ($filterSmt): ?>
                                <span class="input-group-btn">
                                    <a href="<?= site_url('admin/jadwal') ?>" class="btn btn-default" title="Reset Filter">
                                        <i class="fa fa-refresh"></i>
                                    </a>
                                </span>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="box-body">
            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped table-hover">
                    <thead class="bg-navy"> <tr>
                            <th width="30" class="text-center">No</th>
                            <th class="text-center">Smt</th> 
                            <th>Mata Kuliah</th>
                            <th class="text-center">SKS</th>
                            <th>Dosen Pengampu</th>
                            <th class="text-center">Kelas</th>
                            <th>Waktu / Ruang</th>
                            <th class="text-center">Kuota</th>
                            <th width="100" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
foreach ($jadwal as $j) : ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td class="text-center"><span class="badge bg-gray"><?= $j['smt'] ?></span></td> 
                            <td>
                                <b><?= $j['nama_mk'] ?></b><br>
                                <small class="text-muted"><?= $j['kd_mk'] ?></small> 
                                | <span class="label <?= ($j['id_prodi'] == null) ? 'label-default' : 'label-info' ?>" style="font-size: 10px;">
                                    <?= $j['nama_prodi'] ?? 'MATKUL UMUM' ?>
                                </span>
                            </td>
                            <td class="text-center"><?= $j['sks'] ?></td>
                            <td><?= $j['nama_dosen'] ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $j['kelas'] ?></span></td>
                            <td>
                                <div style="font-size: 13px;">
                                    <i class="fa fa-clock-o text-primary"></i> <?= date('H:i', strtotime($j['jam'])) ?> - <?= date('H:i', strtotime($j['jam_selesai'])) ?><br>
                                    <i class="fa fa-map-marker text-danger"></i> <?= $j['hari'] ?>, <?= $j['ruang'] ?>
                                </div>
                            </td>
                            <td class="text-center"><b><?= $j['kouta'] ?></b></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button title="Edit" class="btn btn-warning btn-sm btn-flat" data-toggle="modal" data-target="#modalEdit<?= $j['id_jadwal'] ?>">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <a href="<?= site_url('admin/jadwal/delete/' . $j['id_jadwal']) ?>" class="btn btn-danger btn-sm btn-flat btn-hapus" title="Hapus">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="modalEdit<?= $j['id_jadwal'] ?>">
                            <div class="modal-dialog">
                                <div class="modal-content border-radius-modal">
                                    <div class="modal-header bg-orange">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Jadwal: <?= $j['nama_mk'] ?></h4>
                                    </div>
                                    <form action="<?= site_url('admin/jadwal/update/' . $j['id_jadwal']) ?>" method="post">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Mata Kuliah</label>
                                                <input type="text" class="form-control" value="<?= $j['kd_mk'] ?> - <?= $j['nama_mk'] ?> (Smt <?= $j['smt'] ?>)" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label>Dosen Pengampu</label>
                                                <select name="nidn" class="form-control select2" style="width: 100%;" required>
                                                    <?php foreach ($dosen as $d) : ?>
                                                        <option value="<?= $d['nidn'] ?>" <?= ($d['nidn'] == $j['nidn']) ? 'selected' : '' ?>><?= $d['nama_dosen'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <label>Kelas</label>
                                                    <input type="text" name="kelas" class="form-control" value="<?= $j['kelas'] ?>" required>
                                                </div>
                                                <div class="col-xs-6">
                                                    <label>Hari</label>
                                                    <select name="hari" class="form-control" required>
                                                        <?php $hari_list = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']; ?>
                                                        <?php foreach ($hari_list as $h) : ?>
                                                            <option value="<?= $h ?>" <?= ($h == $j['hari']) ? 'selected' : '' ?>><?= $h ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <label>Jam Mulai</label>
                                                    <input type="time" name="jam" class="form-control" value="<?= $j['jam'] ?>" required>
                                                </div>
                                                <div class="col-xs-6">
                                                    <label>Jam Selesai</label>
                                                    <input type="time" name="jam_selesai" class="form-control" value="<?= $j['jam_selesai'] ?>" required>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <label>Ruang</label>
                                                    <input type="text" name="ruang" class="form-control" value="<?= $j['ruang'] ?>" required>
                                                </div>
                                                <div class="col-xs-6">
                                                    <label>Kuota</label>
                                                    <input type="number" name="kouta" class="form-control" value="<?= $j['kouta'] ?>" required>
                                                </div>
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
            <div class="modal-content">
                <div class="modal-header bg-green">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Tambah Jadwal Baru</h4>
                </div>
                <form action="<?= site_url('admin/jadwal/store') ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Mata Kuliah</label>
                            <select name="kd_mk" class="form-control select2">
                                <?php foreach ($mk_grouped as $smt => $list) : ?>
                                    <optgroup label="Semester <?= $smt ?>">
                                        <?php foreach ($list as $mk) : ?>
                                            <option value="<?= $mk['kd_mk'] ?>">
                                                <?= $mk['kd_mk'] ?> - <?= $mk['nama_mk'] ?> 
                                                (<?= ($mk['id_prodi'] == null) ? 'UMUM' : 'PRODI' ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Dosen Pengampu</label>
                            <select name="nidn" class="form-control select2" style="width: 100%;" required>
                                <option value="">-- Pilih Dosen --</option>
                                <?php foreach ($dosen as $d) : ?>
                                    <option value="<?= $d['nidn'] ?>"><?= $d['nama_dosen'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-xs-6"><label>Kelas</label><input type="text" name="kelas" class="form-control" placeholder="Contoh: A" required></div>
                            <div class="col-xs-6">
                                <label>Hari</label>
                                <select name="hari" class="form-control" required>
                                    <option value="Senin">Senin</option><option value="Selasa">Selasa</option><option value="Rabu">Rabu</option><option value="Kamis">Kamis</option><option value="Jumat">Jumat</option><option value="Sabtu">Sabtu</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-xs-6"><label>Jam Mulai</label><input type="time" name="jam" class="form-control" required></div>
                            <div class="col-xs-6"><label>Jam Selesai</label><input type="time" name="jam_selesai" class="form-control" required></div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-xs-6"><label>Ruang</label><input type="text" name="ruang" class="form-control" placeholder="Contoh: 3.1" required></div>
                            <div class="col-xs-6"><label>Kuota</label><input type="number" name="kouta" class="form-control" placeholder="Kuota Kelas" required></div>
                        </div>
                    </div>
                    <div class="modal-footer bg-gray-light">
                        <button type="button" class="btn btn-default pull-left btn-flat" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success btn-flat">Simpan Jadwal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<style>
    /* Custom Styling */
    .table > thead > tr > th { vertical-align: middle; border-bottom: 2px solid #333; }
    .shadow { box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24); }
    .btn-flat { border-radius: 0; }
    .modal-content { border-radius: 5px; overflow: hidden; }
    #example1 tbody tr {
        transition: 0.2s;
    }

    #example1 tbody tr:hover {
        background-color: #bdbab8ff !important; /* Warna abu-abu yang Anda minta */
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
            "pageLength": 25,
            "order": [[1, 'asc']]
        });

        // Inisialisasi Select2
        if ($.isFunction($.fn.select2)) {
            $('.select2').select2({
                placeholder: "-- Pilih --",
                allowClear: true
            });
        }

        // Notifikasi Sukses Simpan/Hapus (Flashdata)
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

        // SweetAlert untuk Hapus Data
        $('.btn-hapus').on('click', function(e) {
            e.preventDefault();
            const href = $(this).attr('href');

            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data jadwal akan dihapus secara permanen!",
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

        // SweetAlert untuk Copy Jadwal
        $('.btn-copy').on('click', function(e) {
            e.preventDefault();
            const href = $(this).attr('href');

            Swal.fire({
                title: 'Salin Jadwal?',
                text: "Menyalin semua jadwal dari semester yang sama di tahun sebelumnya.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#00c0ef',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Salin!',
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