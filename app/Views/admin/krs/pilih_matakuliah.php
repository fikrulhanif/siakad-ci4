<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<section class="content-header">
    <h1>
        Pilih Mata Kuliah
        <small><?= $mhs['nama_mhs'] ?> - <?= $taAktif['tahun_ajaran'] ?> (<?= $taAktif['semester'] ?>)</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= base_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?= base_url('admin/krs') ?>">Kelola KRS</a></li>
        <li class="active">Pilih Mata Kuliah</li>
    </ol>
</section>

<section class="content">
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fa fa-warning"></i> <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- KOLOM KIRI: Form Pilih Mata Kuliah -->
        <div class="col-md-9">
            <?php if (empty($jadwal)): ?>
                <div class="alert alert-info">
                    <h4><i class="icon fa fa-info"></i> Info!</h4>
                    Semua mata kuliah yang tersedia sudah diambil atau tidak ada jadwal tersedia untuk semester ini.
                </div>
                <a href="<?= base_url('admin/krs') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Kembali</a>
            <?php else: ?>
                
                <form method="post" action="<?= base_url('admin/krs/store') ?>" id="formKrs">
                    <input type="hidden" name="nim" value="<?= $mhs['nim'] ?>">
                    <input type="hidden" name="id_tahun" value="<?= $taAktif['id_tahun'] ?>">
                    <input type="hidden" name="bypass_kapasitas" value="<?= $bypassKapasitas ? '1' : '0' ?>">

                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <?php
                            // Ambil list semester unik dari jadwal yang tersedia
                            $listSemester = array_unique(array_column($jadwal, 'smt'));
                sort($listSemester);
                foreach ($listSemester as $index => $smt):
                    ?>
                                <li class="<?= ($smt == $semesterMhs) ? 'active' : ($index == 0 && !in_array($semesterMhs, $listSemester) ? 'active' : '') ?>">
                                    <a href="#tab_<?= $smt ?>" data-toggle="tab">
                                        <i class="fa fa-book"></i> Semester <?= $smt ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                        <div class="tab-content">
                            <?php foreach ($listSemester as $index => $smt): ?>
                                <div class="tab-pane <?= ($smt == $semesterMhs) ? 'active' : ($index == 0 && !in_array($semesterMhs, $listSemester) ? 'active' : '') ?>" id="tab_<?= $smt ?>">
                                    
                                    <div class="alert alert-warning" style="margin: 10px;">
                                        <i class="fa fa-warning"></i> 
                                        <strong>Mode Admin:</strong>
                                        <?php if ($bypassKapasitas): ?>
                                            <span class="label label-danger">Bypass Kapasitas AKTIF</span> - Anda dapat menambahkan mahasiswa ke kelas yang penuh.
                                        <?php else: ?>
                                            Bypass kapasitas tidak aktif. Kelas penuh tidak dapat dipilih.
                                        <?php endif; ?>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped table-bordered">
                                            <thead>
                                                <tr class="bg-navy">
                                                    <th width="30" class="text-center">Pilih</th>
                                                    <th>Mata Kuliah</th>
                                                    <th>Dosen & Kelas</th>
                                                    <th>Waktu & Ruang</th>
                                                    <th width="150" class="text-center">Kapasitas</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($jadwal as $j):
                                                    if ($j['smt'] == $smt):
                                                        $isPenuh = $j['terisi'] >= $j['kapasitas'];
                                                        $disabled = (!$bypassKapasitas && $isPenuh) ? 'disabled' : '';
                                                        $rowClass = $isPenuh ? 'warning' : '';
                                                        ?>
                                                    <tr class="<?= $rowClass ?>">
                                                        <td class="text-center">
                                                            <div class="checkbox" style="margin: 0;">
                                                                <label>
                                                                    <input type="checkbox" name="id_jadwal[]" 
                                                                           value="<?= $j['id_jadwal'] ?>" 
                                                                           class="checkbox-jadwal"
                                                                           data-sks="<?= $j['sks'] ?>"
                                                                           data-hari="<?= $j['hari'] ?>"
                                                                           data-jam="<?= $j['jam'] ?>"
                                                                           data-jam-selesai="<?= $j['jam_selesai'] ?>"
                                                                           data-nama="<?= $j['nama_mk'] ?>"
                                                                           <?= $disabled ?>>
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <strong class="text-blue"><?= $j['nama_mk'] ?></strong>
                                                            <?php if ($j['is_wajib'] == 1): ?>
                                                                <span class="label label-danger">Wajib</span>
                                                            <?php else: ?>
                                                                <span class="label label-info">Pilihan</span>
                                                            <?php endif; ?>
                                                            <br>
                                                            <small class="text-muted"><?= $j['kd_mk'] ?> | <b><?= $j['sks'] ?> SKS</b></small>
                                                        </td>
                                                        <td>
                                                            <?= $j['nama_dosen'] ?><br>
                                                            <span class="label label-info">Kelas <?= $j['kelas'] ?></span>
                                                        </td>
                                                        <td>
                                                            <small>
                                                                <i class="fa fa-calendar"></i> <?= $j['hari'] ?>, 
                                                                <?= date('H:i', strtotime($j['jam'])) ?> - <?= date('H:i', strtotime($j['jam_selesai'])) ?><br>
                                                                <i class="fa fa-map-marker"></i> Ruang: <?= $j['ruang'] ?>
                                                            </small>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php
                                                                    $persenKuota = ($j['kapasitas'] > 0) ? ($j['terisi'] / $j['kapasitas']) * 100 : 0;
                                                    $colorKuota = $persenKuota >= 90 ? 'danger' : ($persenKuota >= 70 ? 'warning' : 'success');
                                                    ?>
                                                            <div style="margin-bottom: 8px;">
                                                                <b style="font-size: 16px;"><?= $j['terisi'] ?> / <?= $j['kapasitas'] ?></b>
                                                            </div>
                                                            <div class="progress" style="margin-bottom: 5px; height: 20px;">
                                                                <div class="progress-bar progress-bar-<?= $colorKuota ?>" role="progressbar" 
                                                                     style="width: <?= $persenKuota ?>%;">
                                                                </div>
                                                            </div>
                                                            <?php if ($isPenuh): ?>
                                                                <span class="label label-danger"><i class="fa fa-ban"></i> Penuh</span>
                                                            <?php elseif ($persenKuota >= 90): ?>
                                                                <span class="label label-warning"><i class="fa fa-exclamation-triangle"></i> Hampir Penuh</span>
                                                            <?php else: ?>
                                                                <span class="label label-success"><i class="fa fa-check"></i> Tersedia</span>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endif; endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="box-footer">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="bypass_bentrok" value="1" id="bypassBentrok">
                                        <strong>Bypass Bentrok Jadwal</strong> - Izinkan input meskipun ada bentrok waktu
                                    </label>
                                </div>
                                <small class="text-muted">Centang ini jika mahasiswa perlu mengambil mata kuliah yang bentrok (misal: kelas pengganti)</small>
                            </div>

                            <button type="submit" class="btn btn-success btn-lg pull-right" id="btnSubmit">
                                <i class="fa fa-save"></i> Simpan KRS
                            </button>
                            <a href="<?= base_url('admin/krs') ?>" class="btn btn-default btn-lg">
                                <i class="fa fa-times"></i> Batal
                            </a>
                            <?php if ($krsMhs): ?>
                                <a href="<?= base_url('admin/krs/detail/' . $krsMhs['id_krs']) ?>" class="btn btn-info btn-lg">
                                    <i class="fa fa-eye"></i> Lihat KRS yang Sudah Ada
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            <?php endif; ?>
        </div>

        <!-- KOLOM KANAN: Info Mahasiswa & Ringkasan SKS -->
        <div class="col-md-3">
            <!-- Info Mahasiswa -->
            <div class="box box-solid box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-user"></i> Info Mahasiswa</h3>
                </div>
                <div class="box-body">
                    <table class="table table-condensed" style="margin-bottom: 0;">
                        <tr>
                            <td><strong>NIM</strong></td>
                            <td><?= $mhs['nim'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Nama</strong></td>
                            <td><?= $mhs['nama_mhs'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Prodi</strong></td>
                            <td><?= $mhs['nama_prodi'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Semester</strong></td>
                            <td><span class="label label-primary"><?= $semesterMhs ?></span></td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Ringkasan SKS -->
            <div class="box box-solid box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-calculator"></i> Ringkasan SKS</h3>
                </div>
                <div class="box-body text-center">
                    <h1 id="total-sks-tampil" style="font-size: 60px; margin: 10px 0; font-weight: bold;"><?= $totalSksTerambil ?></h1>
                    <p class="text-muted">Total SKS Terpilih</p>
                    <hr>
                    <p>Batas Maksimal (Admin): <b><?= $maxSks ?> SKS</b></p>
                    <div class="progress progress-xs active">
                        <div id="progress-sks" class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" 
                             style="width: <?= ($totalSksTerambil / $maxSks) * 100 ?>%"></div>
                    </div>
                    <small class="text-muted">Sudah diambil: <?= $totalSksTerambil ?> SKS</small>
                </div>
            </div>

            <!-- Alert Info -->
            <div class="alert alert-info">
                <small>
                    <i class="fa fa-info-circle"></i> 
                    Mahasiswa berada di semester <b><?= $semesterMhs ?></b>. 
                    Admin dapat mengambil mata kuliah hingga semester <b><?= $semesterMhs + 4 ?></b>.
                </small>
            </div>

            <?php if ($bypassKapasitas): ?>
                <div class="alert alert-danger">
                    <small>
                        <i class="fa fa-warning"></i> 
                        <strong>Bypass Kapasitas Aktif!</strong><br>
                        Anda dapat menambahkan mahasiswa ke kelas yang sudah penuh. Gunakan dengan bijak.
                    </small>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<script>
$(document).ready(function() {
    const maxSks = <?= $maxSks ?>;
    const sksTerambil = <?= $totalSksTerambil ?>;
    const bypassBentrok = $('#bypassBentrok');

    // Hitung SKS saat checkbox berubah
    $('.checkbox-jadwal').on('change', function() {
        const checkboxSekarang = $(this);
        
        // Cek bentrok jika bypass tidak dicentang
        if (!bypassBentrok.is(':checked')) {
            let bentrok = false;
            let selected = [];

            $('.checkbox-jadwal:checked').each(function() {
                let item = {
                    id: $(this).val(),
                    hari: $(this).data('hari'),
                    jamMulai: $(this).data('jam'),
                    jamSelesai: $(this).data('jam-selesai'),
                    nama: $(this).data('nama')
                };

                // Cek bentrok dengan yang sudah dipilih
                selected.forEach(function(s) {
                    if (s.hari === item.hari) {
                        if (item.jamMulai < s.jamSelesai && item.jamSelesai > s.jamMulai) {
                            bentrok = true;
                            Swal.fire({
                                icon: 'warning',
                                title: 'Jadwal Bentrok!',
                                html: 'Matakuliah <b>' + item.nama + '</b> bentrok dengan <b>' + s.nama + '</b> pada hari ' + s.hari + '<br>(' + item.jamMulai + '-' + item.jamSelesai + ' vs ' + s.jamMulai + '-' + s.jamSelesai + ')<br><br><small>Centang "Bypass Bentrok Jadwal" jika ingin tetap input.</small>'
                            });
                        }
                    }
                });
                selected.push(item);
            });

            if (bentrok) {
                checkboxSekarang.prop('checked', false);
                hitungTotalSks();
                return false;
            }
        }
        
        hitungTotalSks();
    });

    function hitungTotalSks() {
        let total = sksTerambil;
        $('.checkbox-jadwal:checked').each(function() {
            total += parseInt($(this).data('sks'));
        });

        $('#total-sks-tampil').text(total);
        
        let persen = (total / maxSks) * 100;
        $('#progress-sks').css('width', persen + '%');

        if (total > maxSks) {
            $('#total-sks-tampil').css('color', 'red');
            $('#progress-sks').removeClass('progress-bar-success').addClass('progress-bar-danger');
            $('#btnSubmit').prop('disabled', true);
            
            Swal.fire({
                icon: 'error',
                title: 'Batas SKS Terlampaui',
                text: 'Total SKS tidak boleh lebih dari ' + maxSks + ' SKS!',
            });
        } else {
            $('#total-sks-tampil').css('color', 'black');
            $('#progress-sks').removeClass('progress-bar-danger').addClass('progress-bar-success');
            $('#btnSubmit').prop('disabled', false);
        }
    }
});
</script>
<?= $this->endSection() ?>
