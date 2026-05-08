<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<section class="content-header">
    <h1><i class="fa fa-dashboard"></i> Dashboard Dosen</h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3><?= $jmlMatkul ?></h3>
                    <p>Mata Kuliah Yang Diampu</p>
                </div>
                <div class="icon"><i class="fa fa-book"></i></div>
                <a href="<?= site_url('dosen/nilai') ?>" class="small-box-footer">Input Nilai <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3><?= $jmlBimbingan ?></h3>
                    <p>Mahasiswa Bimbingan</p>
                </div>
                <div class="icon"><i class="fa fa-users"></i></div>
                <a href="<?= site_url('dosen/bimbingan') ?>" class="small-box-footer">Lihat Daftar <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3><?= $pendingKrs ?></h3>
                    <p>KRS Menunggu Persetujuan</p>
                </div>
                <div class="icon"><i class="fa fa-check-square-o"></i></div>
                <a href="<?= site_url('dosen/persetujuan-krs') ?>" class="small-box-footer">Proses Sekarang <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <!-- Statistik Mahasiswa Bimbingan -->
    <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box bg-red">
                <span class="info-box-icon"><i class="fa fa-warning"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Mahasiswa IPK < 2.5</span>
                    <span class="info-box-number"><?= $mhsIPKRendah ?></span>
                    <span class="progress-description">Perlu Perhatian Khusus</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box bg-yellow">
                <span class="info-box-icon"><i class="fa fa-star-half-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Mahasiswa IPK 2.5 - 3.5</span>
                    <span class="info-box-number"><?= $mhsIPKBaik ?></span>
                    <span class="progress-description">Prestasi Baik</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box bg-green">
                <span class="info-box-icon"><i class="fa fa-star"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Mahasiswa IPK ≥ 3.5</span>
                    <span class="info-box-number"><?= $mhsIPKSangatBaik ?></span>
                    <span class="progress-description">Prestasi Sangat Baik</span>
                </div>
            </div>
        </div>
    </div>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-calendar"></i> Jadwal Mengajar - <?= $taAktif['tahun_ajaran'] ?> (<?= $taAktif['semester'] ?>)</h3>
        </div>
        <div class="box-body">
            <?php if (empty($jadwal)): ?>
                <div class="text-center text-muted" style="padding: 40px;">
                    <i class="fa fa-calendar-times-o fa-4x"></i>
                    <p style="margin-top: 15px; font-size: 16px;">Tidak ada jadwal mengajar di semester ini.</p>
                </div>
            <?php else: ?>
                <?php
                // Group jadwal by hari
                $jadwalByHari = [];
                foreach ($jadwal as $j) {
                    $jadwalByHari[$j['hari']][] = $j;
                }

                // Urutan hari
                $urutanHari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                ?>

                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <?php foreach ($urutanHari as $index => $hari): ?>
                            <?php if (isset($jadwalByHari[$hari])): ?>
                                <li class="<?= $index == 0 ? 'active' : '' ?>">
                                    <a href="#tab_<?= strtolower($hari) ?>" data-toggle="tab">
                                        <i class="fa fa-calendar-o"></i> <?= $hari ?>
                                        <span class="badge bg-blue"><?= count($jadwalByHari[$hari]) ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>

                    <div class="tab-content">
                        <?php foreach ($urutanHari as $index => $hari): ?>
                            <?php if (isset($jadwalByHari[$hari])): ?>
                                <div class="tab-pane <?= $index == 0 ? 'active' : '' ?>" id="tab_<?= strtolower($hari) ?>">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped table-bordered">
                                            <thead>
                                                <tr class="bg-navy">
                                                    <th width="50" class="text-center">No</th>
                                                    <th>Mata Kuliah</th>
                                                    <th width="80" class="text-center">SKS</th>
                                                    <th width="80" class="text-center">Semester</th>
                                                    <th width="80" class="text-center">Kelas</th>
                                                    <th width="200">Waktu & Ruang</th>
                                                    <th width="100" class="text-center">Peserta</th>
                                                    <th width="120" class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($jadwalByHari[$hari] as $key => $j): ?>
                                                    <tr>
                                                        <td class="text-center"><?= $key + 1 ?></td>
                                                        <td>
                                                            <strong class="text-blue"><?= $j['nama_mk'] ?></strong><br>
                                                            <small class="text-muted"><?= $j['kd_mk'] ?></small>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="label label-success"><?= $j['sks'] ?> SKS</span>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="label label-primary">Semester <?= $j['smt'] ?></span>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="badge bg-purple"><?= $j['kelas'] ?></span>
                                                        </td>
                                                        <td>
                                                            <i class="fa fa-clock-o text-primary"></i> 
                                                            <?= date('H:i', strtotime($j['jam'])) ?> - <?= date('H:i', strtotime($j['jam_selesai'])) ?><br>
                                                            <i class="fa fa-map-marker text-danger"></i> <?= $j['ruang'] ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="label label-info" style="font-size: 12px;">
                                                                <?= $j['jml_mhs'] ?> / <?= $j['kouta'] ?>
                                                            </span><br>
                                                            <small class="text-muted">Mahasiswa</small>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="<?= base_url('dosen/print-absensi/' . $j['id_jadwal']) ?>" 
                                                               target="_blank" 
                                                               class="btn btn-primary btn-xs" 
                                                               title="Cetak Daftar Hadir">
                                                                <i class="fa fa-print"></i> Cetak
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="box box-success">
        <div class="box-header with-border" style="background: linear-gradient(135deg, #00a65a 0%, #008d4c 100%); color: white;">
            <h3 class="box-title" style="color: white;"><i class="fa fa-th"></i> Plotting Jadwal Mingguan</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" style="color: white;"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body" style="overflow-x: auto;">
            <?php if (empty($listJam)) : ?>
                <div style="padding: 40px;" class="text-center">
                    <i class="fa fa-calendar-times-o fa-3x text-muted"></i>
                    <p class="text-muted" style="margin-top: 15px;">Tidak ada jadwal mengajar di semester ini.</p>
                </div>
            <?php else : ?>
                <table class="table table-bordered text-center" style="margin-bottom: 0; background: white;">
                    <thead>
                        <tr style="background: #00a65a; color: white;">
                            <th width="120" style="vertical-align: middle; color: white;">Jam</th>
                            <?php foreach ($listHari as $h) : ?>
                                <th style="vertical-align: middle; color: white;"><?= $h ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($listJam as $jam) : ?>
                            <tr>
                                <td style="background: #f4f4f4; font-weight: bold; vertical-align: middle;"><?= $jam ?></td>
                                <?php foreach ($listHari as $h) : ?>
                                    <td style="vertical-align: middle; min-height: 90px; padding: 8px;">
                                        <?php if (isset($jadwalGrid[$h][$jam])) : $d = $jadwalGrid[$h][$jam]; ?>
                                            <div style="background: linear-gradient(135deg, #dff0d8 0%, #c1e2b3 100%); border-left: 4px solid #3c763d; padding: 10px; border-radius: 4px; text-align: left; min-height: 80px;">
                                                <div style="font-weight: bold; color: #3c763d; margin-bottom: 5px;">
                                                    <?= $d['nama_mk'] ?>
                                                    <span class="label label-primary pull-right" style="font-size: 9px;">Sem <?= $d['smt'] ?></span>
                                                </div>
                                                <div style="font-size: 11px; color: #555;">
                                                    <i class="fa fa-map-marker"></i> <?= $d['ruang'] ?><br>
                                                    <i class="fa fa-users"></i> <?= $d['jml_mhs'] ?> Mhs (Kelas <?= $d['kelas'] ?>)
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
    <?php if (isset($is_lengkap) && !$is_lengkap): ?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-warning box-solid animated shake">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-bullhorn"></i> PERHATIAN: Biodata Belum Lengkap!</h3>
            </div>
            <div class="box-body">
                <p>Halo <b><?= session()->get('nama') ?></b>, kami melihat data profil Anda (NIK, Email, atau No.HP) belum dilengkapi. 
                Mohon segera melengkapi biodata diri untuk keperluan pelaporan data ke <b>PDDIKTI</b>.</p>
                <a href="<?= base_url('profile') ?>" class="btn btn-warning btn-sm btn-flat text-bold">LENGKAPI SEKARANG <i class="fa fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
</section>
<?= $this->endSection() ?>