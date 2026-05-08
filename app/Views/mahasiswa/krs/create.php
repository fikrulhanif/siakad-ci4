<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<section class="content-header">
    <h1>Pilih Mata Kuliah - <?= $taAktif['tahun_ajaran'] ?> (<?= $taAktif['semester'] ?>)</h1>
    <ol class="breadcrumb">
        <li><a href="<?= site_url('mahasiswa/dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?= site_url('mahasiswa/krs') ?>">KRS</a></li>
        <li class="active">Pilih Matakuliah</li>
    </ol>
</section>

<section class="content">
    <div class="row">  
        <div class="col-md-9">
            <?php if (empty($jadwal)) : ?>
                <div class="alert alert-info">
                    <h4><i class="icon fa fa-info"></i> Info!</h4>
                    Semua mata kuliah yang tersedia sudah Anda ambil atau tidak ada jadwal tersedia untuk semester ini.
                </div>
                <a href="<?= site_url('mahasiswa/krs') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Kembali</a>
            <?php else : ?>
                
                <form action="<?= site_url('mahasiswa/krs/store') ?>" method="post">
                    <input type="hidden" name="id_tahun" value="<?= $taAktif['id_tahun'] ?>">
                    
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <?php
                            // Ambil list semester unik dari jadwal yang tersedia
                            $listSemester = array_unique(array_column($jadwal, 'smt'));
                sort($listSemester);
                foreach ($listSemester as $index => $smt) :
                    ?>
                                <li class="<?= ($smt == $semesterMhs) ? 'active' : ($index == 0 && !in_array($semesterMhs, $listSemester) ? 'active' : '') ?>">
                                    <a href="#tab_<?= $smt ?>" data-toggle="tab">Semester <?= $smt ?></a>
                                </li>   
                            <?php endforeach; ?>
                        </ul>
                        
                        <div class="tab-content">
                            <?php foreach ($listSemester as $index => $smt) : ?>
                                <div class="tab-pane <?= ($smt == $semesterMhs) ? 'active' : ($index == 0 && !in_array($semesterMhs, $listSemester) ? 'active' : '') ?>" id="tab_<?= $smt ?>">
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
                                                <?php foreach ($jadwal as $j) :
                                                    if ($j['smt'] == $smt) :
                                                        $penuh = ($j['terisi'] >= $j['kouta']);
                                                        ?>
                                                    <tr class="<?= $penuh ? 'danger text-muted' : '' ?>">
                                                        <td class="text-center">
                                                            <?php if (!$penuh) : ?>
                                                                <div class="checkbox" style="margin: 0;">
                                                                    <label>
                                                                        <input type="checkbox" name="id_jadwal[]" 
                                                                            value="<?= $j['id_jadwal'] ?>" 
                                                                            data-sks="<?= $j['sks'] ?>" 
                                                                            data-hari="<?= $j['hari'] ?>" 
                                                                            data-jam="<?= $j['jam'] ?>"
                                                                            data-jam-selesai="<?= $j['jam_selesai'] ?>"
                                                                            data-nama="<?= $j['nama_mk'] ?>"
                                                                            class="sks-checkbox">
                                                                    </label>
                                                                </div>
                                                            <?php else : ?>
                                                                <i class="fa fa-times-circle text-danger" title="Penuh"></i>
                                                            <?php endif; ?>
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
                                                            $persenKuota = ($j['kouta'] > 0) ? ($j['terisi'] / $j['kouta']) * 100 : 0;
                                                    $colorKuota = $persenKuota >= 90 ? 'danger' : ($persenKuota >= 70 ? 'warning' : 'success');
                                                    ?>
                                                            <div style="margin-bottom: 8px;">
                                                                <b style="font-size: 16px;"><?= $j['terisi'] ?> / <?= $j['kouta'] ?></b>
                                                            </div>
                                                            <div class="progress" style="margin-bottom: 5px; height: 20px;">
                                                                <div class="progress-bar progress-bar-<?= $colorKuota ?>" role="progressbar" 
                                                                     style="width: <?= $persenKuota ?>%;">
                                                                </div>
                                                            </div>
                                                            <?php if ($penuh): ?>
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
                            <button type="submit" id="btn-simpan" class="btn btn-success btn-lg pull-right">
                                <i class="fa fa-save"></i> Tambahkan ke KRS
                            </button>
                            <a href="<?= site_url('mahasiswa/krs') ?>" class="btn btn-default btn-lg">Batal</a>
                        </div>
                    </div>
                </form>
            <?php endif; ?>
        </div>

        <div class="col-md-3">
            <div class="box box-solid box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Ringkasan SKS</h3>
                </div>
                <div class="box-body text-center">
                    <h1 id="total-sks-tampil" style="font-size: 60px; margin: 10px 0; font-weight: bold;"><?= $totalSksTerambil ?></h1>
                    <p class="text-muted">Total SKS Terpilih</p>
                    <hr>
                    <p>Batas Maksimal: <b>24 SKS</b></p>
                    <div class="progress progress-xs active">
                        <div id="progress-sks" class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" style="width: <?= ($totalSksTerambil / 24) * 100 ?>%"></div>
                    </div>
                </div>
            </div>

            <div class="box box-warning">
                <div class="box-body">
                    <p style="margin: 0;"><i class="fa fa-info-circle"></i> <strong>Informasi Semester</strong></p>
                    <hr style="margin: 10px 0;">
                    <p style="margin: 0;">Anda saat ini berada di <strong>Semester <?= $semesterMhs ?></strong>.</p>
                    <p style="margin: 5px 0 0 0;"><small>Anda dapat mengambil mata kuliah semester bawah untuk mengulang, atau semester atas sesuai aturan akademik.</small></p>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.css') ?>">
<script src="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<script>
$(document).ready(function() {
    let sksLama = parseInt(<?= $totalSksTerambil ?>);

    $('.sks-checkbox').on('change', function() {
        let selected = [];
        let bentrok = false;
        let checkboxSekarang = $(this);

        // 1. Validasi Bentrok Real-time di Frontend
        $('.sks-checkbox:checked').each(function() {
            let item = {
                id: $(this).val(),
                hari: $(this).data('hari'),
                jamMulai: $(this).data('jam'),
                jamSelesai: $(this).data('jam-selesai'),
                nama: $(this).data('nama')
            };

            // Cek apakah item ini bentrok dengan yang sudah masuk ke array 'selected'
            selected.forEach(function(s) {
                if (s.hari === item.hari) {
                    // LOGIKA IRISAN WAKTU JS:
                    // (Mulai1 < Selesai2) AND (Selesai1 > Mulai2)
                    if (item.jamMulai < s.jamSelesai && item.jamSelesai > s.jamMulai) {
                        bentrok = true;
                        Swal.fire({
                            icon: 'warning',
                            title: 'Jadwal Bentrok!',
                            html: 'Matakuliah <b>' + item.nama + '</b> bentrok dengan <b>' + s.nama + '</b> pada hari ' + s.hari + '<br>(' + item.jamMulai + '-' + item.jamSelesai + ' vs ' + s.jamMulai + '-' + s.jamSelesai + ')'
                        });
                    }
                }
            });
            selected.push(item);
        });

        if (bentrok) {
            checkboxSekarang.prop('checked', false);
            updateSks(); // Hitung ulang SKS setelah centang dibatalkan
            return false;
        }
        updateSks();
    });
    
        function updateSks(){
                    let sksBaru = 0;
        $('.sks-checkbox:checked').each(function() {
            sksBaru += parseInt($(this).data('sks'));
        });
        
        let totalTotal = sksLama + sksBaru;
        $('#total-sks-tampil').text(totalTotal);
        
        let persen = (totalTotal / 24) * 100;
        $('#progress-sks').css('width', persen + '%');
        
        if(totalTotal > 24) {
            $('#total-sks-tampil').css('color', 'red');
            $('#progress-sks').removeClass('progress-bar-success').addClass('progress-bar-danger');
            $('#btn-simpan').attr('disabled', true);
            
            Swal.fire({
                icon: 'error',
                title: 'Batas SKS Terlampaui',
                text: 'Total SKS (Sudah diambil + Baru) tidak boleh lebih dari 24!',
            });
        } else {
            $('#total-sks-tampil').css('color', 'black');
            $('#progress-sks').removeClass('progress-bar-danger').addClass('progress-bar-success');
            $('#btn-simpan').attr('disabled', false);
        }
    }
});
</script>
<?= $this->endSection() ?>