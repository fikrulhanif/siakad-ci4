<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.css') ?>">

<section class="content-header">
    <div class="row">
        <div class="col-md-8">
            <h1 style="margin-top: 0;">
                <i class="fa fa-file-text-o text-blue"></i> Kartu Rencana Studi (KRS)
            </h1>
            <p style="margin: 5px 0 0 0; color: #666;">
                <i class="fa fa-calendar"></i> Tahun Akademik: <strong><?= $taAktif['tahun_ajaran'] ?></strong> - Semester <strong><?= $taAktif['semester'] ?></strong>
            </p>
        </div>
    </div>
</section>

<section class="content">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="flash-data" data-flashdata="<?= session()->getFlashdata('success') ?>"></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?php if (!$krs_aktif) : ?>
        <div class="callout callout-warning">
            <h4><i class="icon fa fa-warning"></i> Kamu belum mengisi KRS!</h4>
            <p>Silakan klik tombol di bawah untuk memilih mata kuliah yang akan diambil pada semester ini.</p>
            <a href="<?= site_url('mahasiswa/krs/create') ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Isi KRS Sekarang</a>
        </div>
    <?php else : ?>
        
        <?php if ($krs_aktif['status_krs'] == 'Rejected') : ?>
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-ban"></i> KRS Anda Ditolak oleh Dosen PA!</h3>
                </div>
                <div class="box-body">
                    <p><strong>Catatan dari Dosen PA:</strong></p>
                    <div style="background: #fff3cd; padding: 15px; border-left: 4px solid #dd4b39; margin-top: 10px; color: #000; border-radius: 3px;">
                        <i class="fa fa-comment text-danger"></i> 
                        <strong style="color: #000;"><?= nl2br(esc($krs_aktif['catatan_pa'] ?? 'Tidak ada catatan')) ?></strong>
                    </div>
                    <br>
                    <p>Silakan perbaiki KRS Anda sesuai catatan di atas, kemudian klik tombol di bawah untuk mengajukan ulang.</p>
                    <div class="btn-group">
                        <a href="<?= site_url('mahasiswa/krs/create') ?>" class="btn btn-warning">
                            <i class="fa fa-edit"></i> Edit KRS
                        </a>
                        <a href="<?= site_url('mahasiswa/krs/resubmit/' . $krs_aktif['id_krs']) ?>" class="btn btn-primary btn-resubmit">
                            <i class="fa fa-paper-plane"></i> Ajukan Ulang ke Dosen PA
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="box box-solid">
            <div class="box-body bg-gray-light">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-condensed no-border">
                            <tr>
                                <th width="150">NIM</th>
                                <td>: <?= session()->get('nim') ?></td>
                            </tr>
                            <tr>
                                <th>Nama Lengkap</th>
                                <td>: <?= session()->get('nama') ?></td>
                            </tr>
                            <tr>
                                <th>Prodi</th>
                                <td>: <?= $mhs['nama_prodi'] ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-condensed no-border">
                            <tr>
                                <th width="150">Tahun Akademik</th>
                                <td>: <?= $taAktif['tahun_ajaran'] ?> (<?= $taAktif['semester'] ?>)</td>
                            </tr>
                            <tr>
                                <th>Dosen PA</th>
                                <td>: <?= $mhs['nama_pa'] ?? 'Belum Ditentukan' ?></td>
                            </tr>
                            <tr>
                                <th>Status KRS</th>
                                <td>: 
                                    <?php if ($krs_aktif['status_krs'] == 'Disetujui' || $krs_aktif['status_krs'] == 'Approved') : ?>
                                        <span class="label label-success"><i class="fa fa-check-circle"></i> Disetujui</span>
                                    <?php elseif ($krs_aktif['status_krs'] == 'Rejected' || $krs_aktif['status_krs'] == 'Ditolak') : ?>
                                        <span class="label label-danger"><i class="fa fa-times-circle"></i> Ditolak</span>
                                    <?php else : ?>
                                        <span class="label label-warning"><i class="fa fa-hourglass-half"></i> Menunggu Persetujuan</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-list"></i> Daftar Mata Kuliah Yang Diambil</h3>
                <div class="box-tools">
                    <?php if ($krs_aktif['status_krs'] == 'Pending' || $krs_aktif['status_krs'] == 'Rejected') : ?>
                        <a href="<?= site_url('mahasiswa/krs/create') ?>" class="btn btn-primary btn-sm">
                            <i class="fa fa-<?= $krs_aktif['status_krs'] == 'Rejected' ? 'edit' : 'plus' ?>"></i> 
                            <?= $krs_aktif['status_krs'] == 'Rejected' ? 'Edit' : 'Tambah' ?> Mata Kuliah
                        </a>
                    <?php endif; ?>

                    <?php if ($krs_aktif['status_krs'] == 'Disetujui' || $krs_aktif['status_krs'] == 'Approved') : ?>
                        <a href="<?= site_url('mahasiswa/krs/print/' . $krs_aktif['id_krs']) ?>" target="_blank" class="btn btn-danger btn-sm">
                            <i class="fa fa-print"></i> Cetak KRS
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr class="bg-navy">
                            <th width="50" class="text-center">No</th>
                            <th>Mata Kuliah</th>
                            <th class="text-center">SKS</th>
                            <th>Dosen Pengampu</th>
                            <th class="text-center">Kelas</th>
                            <th>Jadwal & Ruang</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $totalSks = 0;
foreach ($detailKrs as $key => $d) : $totalSks += $d['sks']; ?>
                        <tr>
                            <td class="text-center"><?= $key + 1 ?></td>
                            <td>
                                <b><?= $d['nama_mk'] ?></b>
                                <br><small class="text-muted"><?= $d['kd_mk'] ?></small>
                            </td>
                            <td class="text-center"><span class="badge bg-blue"><?= $d['sks'] ?> SKS</span></td>
                            <td><?= $d['nama_dosen'] ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $d['kelas'] ?></span></td>
                            <td>
                                <small>
                                    <i class="fa fa-calendar text-blue"></i> <?= $d['hari'] ?>, 
                                    <?= date('H:i', strtotime($d['jam'])) ?> - <?= date('H:i', strtotime($d['jam_selesai'])) ?><br>
                                    <i class="fa fa-map-marker text-red"></i> <?= $d['ruang'] ?>
                                </small>
                            </td>
                            <td class="text-center">
                                <?php if ($krs_aktif['status_krs'] == 'Pending' || $krs_aktif['status_krs'] == 'Rejected') : ?>
                                    <a href="<?= site_url('mahasiswa/krs/delete_item/' . $d['id_detail']) ?>" class="btn btn-danger btn-xs btn-flat btn-hapus">
                                        <i class="fa fa-trash"></i> Hapus
                                    </a>
                                <?php else : ?>
                                    <span class="label label-success"><i class="fa fa-check"></i> Terdaftar</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray">
                            <th colspan="2" class="text-right">Total SKS yang diambil:</th>
                            <th class="text-center" colspan="1"><?= $totalSks ?></th>
                            <th colspan="4"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <?php if ($krs_aktif['status_krs'] == 'Pending'): ?>
                <div class="box-footer">
                    <div class="alert alert-warning" style="margin-bottom: 0;">
                        <i class="icon fa fa-info"></i> 
                        KRS Anda sedang menunggu verifikasi dari Dosen Pembimbing Akademik. 
                        Silahkan hubungi beliau untuk melakukan proses <b>ACC</b> agar Anda dapat mengikuti perkuliahan.
                    </div>
                </div>
            <?php elseif ($krs_aktif['status_krs'] == 'Rejected'): ?>
                <div class="box-footer">
                    <div class="alert alert-danger" style="margin-bottom: 0;">
                        <i class="icon fa fa-ban"></i> 
                        KRS Anda <b>ditolak</b> oleh Dosen PA. Silakan lihat catatan di atas dan perbaiki KRS Anda.
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="box box-info">
        <div class="box-header with-border" style="background: linear-gradient(135deg, #00c0ef 0%, #0073b7 100%); color: white;">
            <h3 class="box-title" style="color: white;"><i class="fa fa-calendar"></i> Visualisasi Jadwal Kuliah Mingguan</h3>
        </div>
        <div class="box-body" style="overflow-x: auto;">
            <?php if (empty($listJam)) : ?>
                <div style="padding: 40px;" class="text-center">
                    <i class="fa fa-calendar-times-o fa-3x text-muted"></i>
                    <p class="text-muted" style="margin-top: 15px;">Belum ada jadwal untuk ditampilkan.</p>
                </div>
            <?php else : ?>
                <table class="table table-bordered text-center" style="margin-bottom: 0; background: white;">
                    <thead>
                        <tr style="background: #001f3f; color: white;">
                            <th width="120" style="vertical-align: middle; color: white;">Jam</th>
                            <?php foreach ($listHari as $h) : ?>
                                <th style="color: white;"><?= $h ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($listJam as $jam) : ?>
                            <tr>
                                <td style="background: #f4f4f4; font-weight: bold; vertical-align: middle;"><?= $jam ?></td>
                                <?php foreach ($listHari as $h) : ?>
                                    <td style="vertical-align: middle; min-height: 80px; padding: 8px;">
                                        <?php if (isset($jadwalGrid[$h][$jam])) : $d = $jadwalGrid[$h][$jam]; ?>
                                            <div style="background: linear-gradient(135deg, #d9edf7 0%, #bce8f1 100%); border-left: 4px solid #31708f; padding: 10px; border-radius: 4px; min-height: 70px;">
                                                <div style="font-weight: bold; color: #31708f; margin-bottom: 5px;"><?= $d['nama_mk'] ?></div>
                                                <div style="font-size: 11px; color: #555;">
                                                    <i class="fa fa-map-marker"></i> <?= $d['ruang'] ?><br>
                                                    <i class="fa fa-tag"></i> Kelas <?= $d['kelas'] ?>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <span style="color: #ddd; font-size: 20px;">-</span>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</section>

<style>
@media print {
    .main-footer, .content-header, .btn, .box-tools, .main-sidebar, .main-header {
        display: none !important;
    }
    .content-wrapper {
        margin-left: 0 !important;
    }
    .box {
        border: none !important;
    }
}

.bg-navy { background-color: #001f3f !important; color: #fff; }
.btn-flat { border-radius: 0; }

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
            "pageLength": 25,
            "ordering": false
        });

        // Notifikasi SweetAlert
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
                text: "Mata kuliah ini akan dihapus dari Pilihan Anda",
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

        // Konfirmasi Ajukan Ulang
        $('.btn-resubmit').on('click', function(e) {
            e.preventDefault();
            const href = $(this).attr('href');

            Swal.fire({
                title: 'Ajukan Ulang KRS?',
                text: "KRS Anda akan dikirim kembali ke Dosen PA untuk ditinjau ulang.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Ajukan!',
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