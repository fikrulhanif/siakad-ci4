<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.css') ?>">

<section class="content-header">
    <h1><i class="fa fa-book"></i> Data Mata Kuliah</h1>
</section>

<section class="content">

    <?php if (session()->getFlashdata('success')): ?>
        <div class="flash-data" data-flashdata="<?= session()->getFlashdata('success') ?>" data-type="success"></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="flash-data" data-flashdata="<?= session()->getFlashdata('error') ?>" data-type="error"></div>
    <?php endif; ?>

    <div class="box box-primary shadow">
        <div class="box-header with-border">
            <div class="row">
                <div class="col-md-6">
                    <button class="btn btn-success btn-flat" data-toggle="modal" data-target="#modalTambah">
                        <i class="fa fa-plus"></i> Tambah Mata Kuliah
                    </button>
                </div>
                <div class="col-md-6">
                    <form action="<?= site_url('admin/matakuliah') ?>" method="get" class="form-inline pull-right">
                        <div class="input-group">
                            <span class="input-group-addon bg-gray"><i class="fa fa-filter"></i> Filter Semester</span>
                            <select name="filter_smt" class="form-control" onchange="this.form.submit()">
                                <option value="">Semua Semester</option>
                                <?php for ($i = 1; $i <= 8; $i++): ?>
                                    <option value="<?= $i ?>" <?= (isset($_GET['filter_smt']) && $_GET['filter_smt'] == $i) ? 'selected' : '' ?>>
                                        Semester <?= $i ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                            <?php if (isset($_GET['filter_smt']) && $_GET['filter_smt'] != ''): ?>
                                <span class="input-group-btn">
                                    <a href="<?= site_url('admin/matakuliah') ?>" class="btn btn-default" title="Reset Filter">
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
                    <thead class="bg-navy">
                        <tr>
                            <th width="30" class="text-center">No</th>
                            <th class="text-center">Kode MK</th>
                            <th>Nama Mata Kuliah</th>
                            <th width="60" class="text-center">SKS</th>
                            <th width="60" class="text-center">Smt</th>
                            <th>Prodi yang Bisa Akses</th>
                            <th width="80" class="text-center">Jumlah Prodi</th>
                            <th width="100" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
foreach ($matakuliah as $m) :
    $safe_id = str_replace([' ', '/', '-', '.'], '', $m['kd_mk']);
    ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td class="text-center"><span class="label label-primary"><?= $m['kd_mk'] ?></span></td>
                            <td><strong><?= esc($m['nama_mk']) ?></strong></td>
                            <td class="text-center"><span class="badge bg-green"><?= $m['sks'] ?></span></td>
                            <td class="text-center"><span class="badge bg-blue"><?= $m['smt'] ?></span></td>
                            <td>
                                <?php if ($m['prodi_list']): ?>
                                    <span class="label label-info"><?= $m['prodi_list'] ?></span>
                                <?php else: ?>
                                    <span class="label label-success"><i class="fa fa-check-circle"></i> Semua Prodi (Umum)</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if ($m['jml_prodi'] > 0): ?>
                                    <span class="badge bg-blue"><?= $m['jml_prodi'] ?> Prodi</span>
                                <?php else: ?>
                                    <span class="badge bg-green">Semua</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button title="Edit" class="btn btn-warning btn-sm btn-flat" data-toggle="modal" data-target="#edit<?= $safe_id ?>">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <a href="<?= site_url('admin/matakuliah/delete/' . $m['kd_mk']) ?>" class="btn btn-danger btn-sm btn-flat btn-hapus" title="Hapus">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="edit<?= $safe_id ?>">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-orange">
                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                        <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Mata Kuliah</h4>
                                    </div>
                                    <form action="<?= site_url('admin/matakuliah/update/' . $m['kd_mk']) ?>" method="post">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Kode MK</label>
                                                <input type="text" class="form-control" value="<?= $m['kd_mk'] ?>" readonly>
                                                <small class="text-muted">Kode MK tidak dapat diubah</small>
                                            </div>
                                            <div class="form-group">
                                                <label>Nama Mata Kuliah <span class="text-danger">*</span></label>
                                                <input type="text" name="nama_mk" class="form-control" value="<?= esc($m['nama_mk']) ?>" required>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>SKS <span class="text-danger">*</span></label>
                                                        <input type="number" name="sks" class="form-control" value="<?= $m['sks'] ?>" min="1" max="6" required>
                                                        <small class="text-muted">Jumlah SKS (1-6)</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Semester Default <span class="text-danger">*</span></label>
                                                        <select name="smt" class="form-control" required>
                                                            <option value="">-- Pilih Semester --</option>
                                                            <?php for ($i = 1; $i <= 8; $i++): ?>
                                                                <option value="<?= $i ?>" <?= $m['smt'] == $i ? 'selected' : '' ?>>Semester <?= $i ?></option>
                                                            <?php endfor; ?>
                                                        </select>
                                                        <small class="text-muted">Semester default (bisa diubah per prodi)</small>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Prodi yang Bisa Akses -->
                                            <div class="form-group">
                                                <label>Prodi yang Bisa Akses Mata Kuliah Ini</label>
                                                <div class="well" style="background: #f9f9f9; max-height: 300px; overflow-y: auto;">
                                                    <?php
                                                    // Get prodi yang sudah terdaftar
                                                    $db = \Config\Database::connect();
    $prodiTerdaftar = $db->table('matakuliah_prodi')
        ->where('kd_mk', $m['kd_mk'])
        ->get()->getResultArray();

    $prodiMap = [];
    foreach ($prodiTerdaftar as $pt) {
        $prodiMap[$pt['id_prodi']] = [
            'smt_prodi' => $pt['smt_prodi'],
            'is_wajib' => $pt['is_wajib']
        ];
    }

    foreach ($prodi as $p):
        $isChecked = isset($prodiMap[$p['id_prodi']]);
        $smt = $isChecked ? $prodiMap[$p['id_prodi']]['smt_prodi'] : '';
        $wajib = $isChecked ? $prodiMap[$p['id_prodi']]['is_wajib'] : 1;
        ?>
                                                    <div class="checkbox" style="margin-bottom: 15px;">
                                                        <label style="font-weight: bold;">
                                                            <input type="checkbox" name="prodi_akses[]" value="<?= $p['id_prodi'] ?>" 
                                                                   class="prodi-checkbox-edit-<?= $safe_id ?>" data-prodi="<?= $p['id_prodi'] ?>"
                                                                   <?= $isChecked ? 'checked' : '' ?>>
                                                            <?= $p['nama_prodi'] ?>
                                                        </label>
                                                        
                                                        <div class="prodi-detail-edit-<?= $safe_id ?>-<?= $p['id_prodi'] ?>" 
                                                             style="<?= $isChecked ? '' : 'display:none;' ?> margin-left: 25px; margin-top: 10px; padding: 10px; background: white; border-left: 3px solid #f39c12;">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label>Semester:</label>
                                                                    <input type="number" name="smt_prodi_<?= $p['id_prodi'] ?>" 
                                                                           class="form-control input-sm" min="1" max="8" 
                                                                           value="<?= $smt ?>" placeholder="1-8">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>Status:</label>
                                                                    <select name="is_wajib_<?= $p['id_prodi'] ?>" class="form-control input-sm">
                                                                        <option value="1" <?= $wajib == 1 ? 'selected' : '' ?>>Wajib</option>
                                                                        <option value="0" <?= $wajib == 0 ? 'selected' : '' ?>>Pilihan</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php endforeach; ?>
                                                </div>
                                                <small class="text-muted">
                                                    <i class="fa fa-info-circle"></i> 
                                                    Jika tidak ada yang dipilih, mata kuliah ini akan menjadi <strong>Mata Kuliah Umum</strong>.
                                                </small>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-gray-light">
                                            <button type="button" class="btn btn-default pull-left btn-flat" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-warning btn-flat"><i class="fa fa-save"></i> Update Data</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <script>
                        $(document).ready(function() {
                            $('.prodi-checkbox-edit-<?= $safe_id ?>').on('change', function() {
                                const prodiId = $(this).data('prodi');
                                if ($(this).is(':checked')) {
                                    $(`.prodi-detail-edit-<?= $safe_id ?>-${prodiId}`).slideDown();
                                } else {
                                    $(`.prodi-detail-edit-<?= $safe_id ?>-${prodiId}`).slideUp();
                                }
                            });
                        });
                        </script>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambah">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-green">
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Tambah Mata Kuliah</h4>
                </div>
                <form action="<?= site_url('admin/matakuliah/store') ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Kode MK <span class="text-danger">*</span></label>
                            <input type="text" name="kd_mk" class="form-control" placeholder="Contoh: MK001" required>
                        </div>
                        <div class="form-group">
                            <label>Nama Mata Kuliah <span class="text-danger">*</span></label>
                            <input type="text" name="nama_mk" class="form-control" placeholder="Masukkan Nama Mata Kuliah" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>SKS <span class="text-danger">*</span></label>
                                    <input type="number" name="sks" class="form-control" placeholder="Jumlah SKS" min="1" max="6" required>
                                    <small class="text-muted">Jumlah SKS (1-6)</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Semester Default <span class="text-danger">*</span></label>
                                    <select name="smt" class="form-control" required>
                                        <option value="">-- Pilih Semester --</option>
                                        <?php for ($i = 1; $i <= 8; $i++): ?>
                                            <option value="<?= $i ?>">Semester <?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <small class="text-muted">Semester default (bisa diubah per prodi)</small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Prodi yang Bisa Akses -->
                        <div class="form-group">
                            <label>Prodi yang Bisa Akses Mata Kuliah Ini</label>
                            <div class="well" style="background: #f9f9f9;">
                                <?php foreach ($prodi as $p): ?>
                                <div class="checkbox" style="margin-bottom: 15px;">
                                    <label style="font-weight: bold;">
                                        <input type="checkbox" name="prodi_akses[]" value="<?= $p['id_prodi'] ?>" 
                                               class="prodi-checkbox" data-prodi="<?= $p['id_prodi'] ?>">
                                        <?= $p['nama_prodi'] ?>
                                    </label>
                                    
                                    <div class="prodi-detail" id="detail-<?= $p['id_prodi'] ?>" 
                                         style="display:none; margin-left: 25px; margin-top: 10px; padding: 10px; background: white; border-left: 3px solid #3c8dbc;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Semester di Prodi Ini:</label>
                                                <input type="number" name="smt_prodi_<?= $p['id_prodi'] ?>" 
                                                       class="form-control input-sm" min="1" max="8" 
                                                       placeholder="1-8">
                                                <small class="text-muted">Semester berapa mata kuliah ini diajarkan</small>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Status:</label>
                                                <select name="is_wajib_<?= $p['id_prodi'] ?>" class="form-control input-sm">
                                                    <option value="1">Wajib</option>
                                                    <option value="0">Pilihan</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <small class="text-muted">
                                <i class="fa fa-info-circle"></i> 
                                <strong>Pilih minimal 1 prodi.</strong> Jika tidak ada yang dipilih, mata kuliah ini akan menjadi 
                                <strong>Mata Kuliah Umum</strong> (semua prodi bisa akses).
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer bg-gray-light">
                        <button type="button" class="btn btn-default pull-left btn-flat" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-save"></i> Simpan Mata Kuliah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>

<style>
    .shadow { box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24); }
    .btn-flat { border-radius: 0; }
    .modal-content { border-radius: 5px; overflow: hidden; }
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
    $(document).ready(function() {
        // DataTables
        $('#example1').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
            },
            "pageLength": 25,
            "order": [[1, 'asc']]
        });

        // Toggle detail input saat checkbox dicentang (untuk modal tambah)
        $('.prodi-checkbox').on('change', function() {
            const prodiId = $(this).data('prodi');
            if ($(this).is(':checked')) {
                $(`#detail-${prodiId}`).slideDown();
            } else {
                $(`#detail-${prodiId}`).slideUp();
            }
        });

        // Flash Message SweetAlert
        const flashData = $('.flash-data').data('flashdata');
        const type = $('.flash-data').data('type');
        if (flashData) {
            Swal.fire({
                icon: type,
                title: type === 'success' ? 'Berhasil!' : 'Gagal!',
                text: flashData,
                showConfirmButton: false,
                timer: 2000
            });
        }

        // Delete Confirmation
        $('.btn-hapus').on('click', function(e) {
            e.preventDefault();
            const href = $(this).attr('href');

            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Mata kuliah ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = href;
                }
            })
        });
    });
</script>
<?= $this->endSection() ?>
