<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<style>
    .table-custom-bordered {
        border: 2px solid #1a1a1a !important;
    }
    .table-custom-bordered thead tr th {
        border-bottom: 2px solid #1a1a1a !important;
        border-right: 1px solid #b1b4b9ff !important;
        text-align: center;
        background-color: #f4f4f4;
    }
    .table-custom-bordered tbody tr td {
        border: 1px solid #b1b4b9ff !important; /* Border antar sel */
    }
    .bg-semester-header {
        background-color: #e7f3ff !important;
        border-top: 2px solid #3c8dbc !important;
        border-bottom: 2px solid #1a1a1a !important;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid bg-navy" style="border-radius: 8px; margin-bottom: 10px; margin-top:10px;">
                <div class="box-body">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <h3 style="margin: 0; font-weight: bold;">
                                <i class="fa fa-calendar-check-o"></i> Daftar Kelas & Jadwal Kuliah
                            </h3>
                            <p style="margin: 5px 0 0 0; opacity: 0.8;">
                                Tahun Akademik: <?= $ta['tahun_ajaran'] ?> - Semester <?= $ta['semester'] ?>
                            </p>
                        </div>
                        <div class="hidden-xs">
                            <i class="fa fa-graduation-cap" style="font-size: 50px; opacity: 0.2;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div style="margin-bottom: 15px; display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="<?= base_url('mahasiswa/daftar-kelas?smt=all') ?>" 
                   class="btn <?= ($smt_aktif == 'all') ? 'btn-primary' : 'btn-default' ?> btn-flat" style="border-radius: 20px; padding: 6px 20px; border: 1px solid #3c8dbc;">
                    <i class="fa fa-list"></i> Semua Semester
                </a>
                <?php foreach ($daftar_smt as $s) : ?>
                    <a href="<?= base_url('mahasiswa/daftar-kelas?smt=' . $s) ?>" 
                       class="btn <?= ($smt_aktif == $s) ? 'btn-primary' : 'btn-default' ?> btn-flat" style="border-radius: 20px; padding: 6px 20px; border: 1px solid #3c8dbc;">
                        Semester <?= $s ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary" style="border-top: 3px solid #3c8dbc;">
                <div class="box-header with-border">
                    <h3 class="box-title text-primary" style="font-weight: bold;">
                        <i class="fa fa-table"></i> 
                        <?= ($smt_aktif == 'all') ? 'Seluruh Jadwal Mata Kuliah' : 'Jadwal Kuliah Semester ' . $smt_aktif ?>
                    </h3>
                </div>
                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-custom-bordered" style="margin-bottom: 0;">
                            <thead>
                                <tr>
                                    <th width="50">NO</th>
                                    <th width="160">HARI / WAKTU</th>
                                    <th>MATA KULIAH</th>
                                    <th width="80">SKS</th>
                                    <th>DOSEN PENGAMPU</th>
                                    <th width="180">KELAS / RUANG</th>
                                    <th width="100">KAPASITAS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $current_smt = null;
$no = 1;
if (empty($jadwal)) : ?>
                                    <tr>
                                        <td colspan="7" class="text-center" style="padding: 40px;">
                                            <i class="fa fa-info-circle fa-3x text-gray"></i><br>
                                            <span class="text-gray">Tidak ada jadwal kuliah yang tersedia untuk filter ini.</span>
                                        </td>
                                    </tr>
                                <?php endif; ?>

                                <?php foreach ($jadwal as $row) :
                                    if ($current_smt !== $row['smt']) :
                                        $current_smt = $row['smt'];
                                        $no = 1;
                                        ?>
                                    <tr class="bg-semester-header">
                                        <td colspan="7" style="padding: 10px 15px;">
                                            <b class="text-primary" style="font-size: 16px;"><i class="fa fa-tags"></i> SEMESTER <?= $current_smt ?></b>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <td class="text-center" style="vertical-align: middle; font-weight: bold;"><?= $no++ ?></td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <span class="label label-primary" style="font-size: 11px;"><?= strtoupper($row['hari']) ?></span><br>
                                        <div style="margin-top: 5px; font-weight: 600; color: #333;">
                                            <?= date('H:i', strtotime($row['jam'])) ?> - <?= date('H:i', strtotime($row['jam_selesai'])) ?>
                                        </div>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <div style="font-weight: bold; color: #333; font-size: 14px;"><?= $row['nama_mk'] ?></div>
                                        <small class="label label-default" style="font-weight: normal;"><?= $row['kd_mk'] ?></small>
                                        <?php if (isset($row['is_wajib']) && $row['is_wajib'] == 0) : ?>
                                            <span class="label label-info" style="font-size: 10px; margin-left: 5px;"><i class="fa fa-star-o"></i> PILIHAN</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <span class="badge bg-purple" style="padding: 5px 10px;"><?= $row['sks'] ?> SKS</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <div style="display: flex; align-items: center;">
                                            <i class="fa fa-user-circle text-gray" style="font-size: 20px; margin-right: 8px;"></i>
                                            <span><?= $row['nama_dosen'] ?></span>
                                        </div>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-default btn-flat" style="font-weight: bold; border: 1px solid #ddd;"><?= $row['kelas'] ?></button>
                                            <button class="btn btn-warning btn-flat" style="border: 1px solid #f39c12;"><?= $row['ruang'] ?></button>
                                        </div>
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <?php
                                        $terisi = isset($row['terisi']) ? (int)$row['terisi'] : 0;
                                    $kapasitas = isset($row['kapasitas']) ? (int)$row['kapasitas'] : 0;
                                    $persentase = $kapasitas > 0 ? ($terisi / $kapasitas) * 100 : 0;

                                    if ($persentase >= 100) {
                                        $badge_class = 'bg-red';
                                        $icon = 'fa-times-circle';
                                    } elseif ($persentase >= 80) {
                                        $badge_class = 'bg-yellow';
                                        $icon = 'fa-exclamation-triangle';
                                    } else {
                                        $badge_class = 'bg-green';
                                        $icon = 'fa-check-circle';
                                    }
                                    ?>
                                        <span class="badge <?= $badge_class ?>" style="padding: 5px 10px; font-size: 11px;">
                                            <i class="fa <?= $icon ?>"></i> <?= $terisi ?>/<?= $kapasitas ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-footer">
                    <p class="text-muted small">* Daftar kelas di atas sesuai dengan kurikulum Tahun Akademik yang aktif.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>