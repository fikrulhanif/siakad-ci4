<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.css') ?>">

<section class="content-header">
    <h1><i class="fa fa-check-square-o"></i> Persetujuan KRS Mahasiswa</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dosen</a></li>
        <li class="active">Persetujuan KRS</li>
    </ol>
</section>

<section class="content">

    <?php if (session()->getFlashdata('success')): ?>
        <div class="flash-data" data-flashdata="<?= session()->getFlashdata('success') ?>"></div>
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('error')): ?>
        <div class="flash-data" data-flashdata="<?= session()->getFlashdata('error') ?>" data-type="error"></div>
    <?php endif; ?>

    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">Daftar Bimbingan - Semester <?= $ta['semester'] ?> <?= $ta['tahun_ajaran'] ?></h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="example1">
                    <thead>
                        <tr class="bg-navy">
                            <th width="30" class="text-center">No</th>
                            <th width="120">NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th>Program Studi</th>
                            <th class="text-center">Status KRS</th>
                            <th class="text-center" width="200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
foreach ($krs as $k) : ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><b><?= $k['nim'] ?></b></td>
                                <td><?= esc($k['nama_mhs']) ?></td>
                                <td><?= $k['nama_prodi'] ?></td>
                                <td class="text-center">
                                    <?php if ($k['status_krs'] == 'Approved') : ?>
                                        <span class="label label-success"><i class="fa fa-check-circle"></i> Disetujui</span>
                                    <?php elseif ($k['status_krs'] == 'Rejected') : ?>
                                        <span class="label label-danger"><i class="fa fa-times-circle"></i> Ditolak</span>
                                    <?php else : ?>
                                        <span class="label label-warning animated pulse infinite"><i class="fa fa-hourglass-half"></i> Menunggu</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button class="btn btn-info btn-sm btn-flat" data-toggle="modal" data-target="#modalDetail<?= $k['id_krs'] ?>">
                                            <i class="fa fa-search"></i> Detail
                                        </button>

                                        <?php if ($k['status_krs'] == 'Pending') : ?>
                                            <a href="<?= base_url('dosen/acc-krs/' . $k['id_krs']) ?>" class="btn btn-success btn-sm btn-flat btn-acc">
                                                <i class="fa fa-check"></i> ACC
                                            </a>
                                            <button class="btn btn-danger btn-sm btn-flat" data-toggle="modal" data-target="#modalReject<?= $k['id_krs'] ?>">
                                                <i class="fa fa-times"></i> Tolak
                                            </button>
                                        <?php elseif ($k['status_krs'] == 'Approved') : ?>
                                            <button class="btn btn-warning btn-sm btn-flat" data-toggle="modal" data-target="#modalReject<?= $k['id_krs'] ?>">
                                                <i class="fa fa-ban"></i> Batalkan
                                            </button>
                                        <?php else : ?>
                                            <span class="label label-danger">Ditolak</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?php foreach ($krs as $k) : ?>
<div class="modal fade" id="modalDetail<?= $k['id_krs'] ?>">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-file-text"></i> Review KRS: <?= $k['nama_mhs'] ?> (<?= $k['nim'] ?>)</h4>
            </div>
            <div class="modal-body">
                <!-- Info Akademik Mahasiswa -->
                <div class="row" style="margin-bottom: 15px;">
                    <div class="col-md-6">
                        <div class="info-box bg-aqua">
                            <span class="info-box-icon"><i class="fa fa-graduation-cap"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">IPK Kumulatif</span>
                                <span class="info-box-number"><?= $ipMahasiswa[$k['id_krs']]['ipk'] ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box bg-green">
                            <span class="info-box-icon"><i class="fa fa-line-chart"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">IP Semester Lalu</span>
                                <span class="info-box-number"><?= $ipMahasiswa[$k['id_krs']]['ips_lalu'] ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-bottom: 15px;">
                    <div class="col-md-6">
                        <div class="info-box bg-yellow">
                            <span class="info-box-icon"><i class="fa fa-calendar"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Semester Saat Ini</span>
                                <span class="info-box-number"><?= $ipMahasiswa[$k['id_krs']]['semester'] ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box bg-purple">
                            <span class="info-box-icon"><i class="fa fa-book"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total SKS Lulus</span>
                                <span class="info-box-number"><?= $ipMahasiswa[$k['id_krs']]['total_sks'] ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rekomendasi Otomatis -->
                <?php
                $totalSks = 0;
    if (isset($detailKrs[$k['id_krs']])) {
        foreach ($detailKrs[$k['id_krs']] as $d) {
            $totalSks += $d['sks'];
        }
    }

    $ipsLalu = (float)$ipMahasiswa[$k['id_krs']]['ips_lalu'];
    $maxSksRekomendasi = 24; // Default
    $warningMessage = '';

    if ($ipsLalu < 2.0) {
        $maxSksRekomendasi = 18;
        $warningMessage = 'IP semester lalu < 2.0, sebaiknya maksimal 18 SKS';
    } elseif ($ipsLalu < 2.5) {
        $maxSksRekomendasi = 20;
        $warningMessage = 'IP semester lalu < 2.5, sebaiknya maksimal 20 SKS';
    } elseif ($ipsLalu < 3.0) {
        $maxSksRekomendasi = 22;
    }

    if ($totalSks > $maxSksRekomendasi && $warningMessage) : ?>
                    <div class="box box-warning">
                        <i class="fa fa-exclamation-triangle"></i> <b>Perhatian!</b> 
                        <?= $warningMessage ?>. Mahasiswa ini mengambil <b><?= $totalSks ?> SKS</b>.
                    </div>
                <?php elseif ($totalSks > 24) : ?>
                    <div class="box box-danger">
                        <i class="fa fa-ban"></i> <b>Melebihi Batas!</b> 
                        Total SKS <b><?= $totalSks ?> SKS</b> melebihi batas maksimal 24 SKS.
                    </div>
                <?php endif; ?>

                <!-- Daftar Mata Kuliah -->
                <h4 style="margin-top: 20px;"><i class="fa fa-list"></i> Daftar Mata Kuliah</h4>
                <table class="table table-condensed table-bordered">
                    <thead>
                        <tr class="bg-gray">
                            <th width="100">Kode MK</th>
                            <th>Mata Kuliah</th>
                            <th class="text-center">SKS</th>
                            <th class="text-center">Kelas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
            if (isset($detailKrs[$k['id_krs']])) :
                foreach ($detailKrs[$k['id_krs']] as $d) : ?>
                                <tr>
                                    <td><?= $d['kd_mk'] ?></td>
                                    <td><?= $d['nama_mk'] ?></td>
                                    <td class="text-center"><?= $d['sks'] ?></td>
                                    <td class="text-center"><?= $d['kelas'] ?></td>
                                </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                    <tfoot>
                        <tr class="<?= $totalSks > 24 ? 'danger' : ($totalSks > $maxSksRekomendasi ? 'warning' : 'success') ?>">
                            <th colspan="2" class="text-right">Total Kredit yang Diajukan:</th>
                            <th class="text-center"><?= $totalSks ?></th>
                            <th>SKS</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Tutup</button>
                <?php if ($k['status_krs'] == 'Pending') : ?>
                    <button class="btn btn-danger btn-flat" data-dismiss="modal" data-toggle="modal" data-target="#modalReject<?= $k['id_krs'] ?>">
                        <i class="fa fa-times"></i> Tolak
                    </button>
                    <a href="<?= base_url('dosen/acc-krs/' . $k['id_krs']) ?>" class="btn btn-success btn-flat btn-acc">
                        <i class="fa fa-check"></i> Setujui Sekarang
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<?php foreach ($krs as $k) : ?>
<div class="modal fade" id="modalReject<?= $k['id_krs'] ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-times-circle"></i> Tolak KRS: <?= $k['nama_mhs'] ?></h4>
            </div>
            <form action="<?= base_url('dosen/reject-krs/' . $k['id_krs']) ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fa fa-warning"></i> Mahasiswa akan melihat catatan Anda dan harus memperbaiki KRS.
                    </div>
                    <div class="form-group">
                        <label>Alasan Penolakan / Catatan untuk Mahasiswa <span class="text-danger">*</span></label>
                        <textarea name="catatan_pa" class="form-control" rows="5" 
                                  placeholder="Contoh: Total SKS terlalu banyak, kurangi menjadi maksimal 20 SKS. Atau: Mata kuliah X bentrok dengan Y, silakan pilih salah satu." 
                                  required><?= $k['catatan_pa'] ?? '' ?></textarea>
                        <small class="text-muted">Berikan catatan yang jelas agar mahasiswa tahu apa yang harus diperbaiki.</small>
                    </div>
                </div>
                <div class="modal-footer bg-gray-light">
                    <button type="button" class="btn btn-default pull-left btn-flat" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-times"></i> Tolak KRS</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>

<style>
    .btn-flat { border-radius: 0; }
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
    $(function () {
        // DataTables
        $('#example1').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
            },
            "pageLength": 25
        });

        const flashData = $('.flash-data').data('flashdata');
        if (flashData) {
            const type = $('.flash-data').data('type') || 'success';
            Swal.fire({
                icon: type,
                title: type === 'success' ? 'Berhasil' : 'Gagal',
                text: flashData,
                timer: 2000,
                showConfirmButton: false
            });
        }

        $('.btn-acc').on('click', function (e) {
            e.preventDefault();
            const href = $(this).attr('href');
            Swal.fire({
                title: 'Setujui KRS?',
                text: "Mahasiswa akan dapat mencetak KPU/KRS.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#00a65a',
                confirmButtonText: 'Ya, ACC!'
            }).then((result) => {
                if (result.isConfirmed) { window.location.href = href; }
            });
        });
    });
</script>
<?= $this->endSection() ?>