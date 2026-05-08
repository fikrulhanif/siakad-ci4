<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<section class="content-header">
    <h1>
        <i class="fa fa-users"></i> User Management
        <small>Kelola Akun Pengguna Sistem</small>
    </h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-shield"></i> Manajemen Pengguna</h3>
        </div>
        <div class="box-body">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab_admin" data-toggle="tab">
                            <i class="fa fa-user-secret"></i> Admin
                            <span class="badge bg-red"><?= count($adminUsers) ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="#tab_mahasiswa" data-toggle="tab">
                            <i class="fa fa-graduation-cap"></i> Mahasiswa
                            <span class="badge bg-blue"><?= count($mahasiswaUsers) ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="#tab_dosen" data-toggle="tab">
                            <i class="fa fa-briefcase"></i> Dosen
                            <span class="badge bg-green"><?= count($dosenUsers) ?></span>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- TAB ADMIN -->
                    <div class="tab-pane active" id="tab_admin">
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-success btn-flat" data-toggle="modal" data-target="#modalTambahAdmin">
                                    <i class="fa fa-plus"></i> Tambah Admin Baru
                                </button>
                                <hr>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" id="tableAdmin" style="width: 100%;">
                                <thead class="bg-red">
                                    <tr>
                                        <th width="5%" class="text-center">No</th>
                                        <th width="20%">Username</th>
                                        <th width="10%">Role</th>
                                        <th width="20%">Dibuat</th>
                                        <th width="20%">Terakhir Update</th>
                                        <th width="15%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
foreach ($adminUsers as $user): ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td>
                                            <strong><?= esc($user['username']) ?></strong>
                                            <?php if ($user['id_user'] == session()->get('id_user')): ?>
                                                <span class="label label-info">You</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><span class="label label-danger">ADMIN</span></td>
                                        <td><small><i class="fa fa-clock-o"></i> <?= date('d/m/Y H:i', strtotime($user['created_at'])) ?></small></td>
                                        <td><small><i class="fa fa-refresh"></i> <?= date('d/m/Y H:i', strtotime($user['updated_at'])) ?></small></td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button class="btn btn-warning btn-xs btn-flat" 
                                                        data-toggle="modal" 
                                                        data-target="#modalResetPassword"
                                                        data-id="<?= $user['id_user'] ?>"
                                                        data-username="<?= esc($user['username']) ?>"
                                                        data-role="Admin"
                                                        title="Reset Password">
                                                    <i class="fa fa-key"></i>
                                                </button>
                                                <button class="btn btn-info btn-xs btn-flat" 
                                                        data-toggle="modal" 
                                                        data-target="#modalChangeUsername"
                                                        data-id="<?= $user['id_user'] ?>"
                                                        data-username="<?= esc($user['username']) ?>"
                                                        title="Ubah Username">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <?php if ($user['id_user'] != session()->get('id_user')): ?>
                                                <button class="btn btn-danger btn-xs btn-flat btn-delete-admin"
                                                        data-url="<?= site_url('admin/user-management/delete-admin/' . $user['id_user']) ?>"
                                                        data-name="<?= esc($user['username']) ?>"
                                                        title="Hapus Admin">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- TAB MAHASISWA -->
                    <div class="tab-pane" id="tab_mahasiswa">
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> 
                            <strong>Info:</strong> Akun mahasiswa dibuat otomatis saat menambah data mahasiswa. 
                            Username default = NIM, Password default = NIM.
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" id="tableMahasiswa" style="width: 100%;">
                                <thead class="bg-blue">
                                    <tr>
                                        <th width="5%" class="text-center">No</th>
                                        <th width="10%">NIM</th>
                                        <th width="20%">Nama Mahasiswa</th>
                                        <th width="10%">Username</th>
                                        <th width="15%">Prodi</th>
                                        <th width="8%" class="text-center">Angkatan</th>
                                        <th width="10%" class="text-center">Status</th>
                                        <th width="12%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
foreach ($mahasiswaUsers as $user): ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><strong class="text-primary"><?= $user['nim'] ?></strong></td>
                                        <td><?= esc($user['nama_mhs']) ?></td>
                                        <td><code style="background: #f4f4f4; padding: 2px 6px; border-radius: 3px; font-size: 11px;"><?= esc($user['username']) ?></code></td>
                                        <td><span class="label label-info" style="font-size: 11px;"><?= $user['nama_prodi'] ?></span></td>
                                        <td class="text-center"><span class="badge bg-blue"><?= $user['angkatan'] ?></span></td>
                                        <td class="text-center">
                                            <?php if ($user['status'] === 'aktif'): ?>
                                                <span class="label label-success"><i class="fa fa-check-circle"></i> Aktif</span>
                                            <?php else: ?>
                                                <span class="label label-danger"><i class="fa fa-times-circle"></i> Non-Aktif</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button class="btn btn-warning btn-xs btn-flat" 
                                                        data-toggle="modal" 
                                                        data-target="#modalResetPassword"
                                                        data-id="<?= $user['id_user'] ?>"
                                                        data-username="<?= esc($user['username']) ?>"
                                                        data-role="Mahasiswa"
                                                        title="Reset Password">
                                                    <i class="fa fa-key"></i>
                                                </button>
                                                <button class="btn btn-info btn-xs btn-flat" 
                                                        data-toggle="modal" 
                                                        data-target="#modalChangeUsername"
                                                        data-id="<?= $user['id_user'] ?>"
                                                        data-username="<?= esc($user['username']) ?>"
                                                        title="Ubah Username">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- TAB DOSEN -->
                    <div class="tab-pane" id="tab_dosen">
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> 
                            <strong>Info:</strong> Akun dosen dibuat otomatis saat menambah data dosen. 
                            Username default = NIDN, Password default = NIDN.
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" id="tableDosen" style="width: 100%;">
                                <thead class="bg-green">
                                    <tr>
                                        <th width="5%" class="text-center">No</th>
                                        <th width="12%">NIDN</th>
                                        <th width="30%">Nama Dosen</th>
                                        <th width="15%">Username</th>
                                        <th width="25%">Prodi</th>
                                        <th width="13%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
foreach ($dosenUsers as $user): ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><strong class="text-success"><?= $user['nidn'] ?></strong></td>
                                        <td><?= esc($user['nama_dosen']) ?></td>
                                        <td><code style="background: #f4f4f4; padding: 2px 6px; border-radius: 3px; font-size: 11px;"><?= esc($user['username']) ?></code></td>
                                        <td><span class="label label-success" style="font-size: 11px;"><?= $user['nama_prodi'] ?></span></td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button class="btn btn-warning btn-xs btn-flat" 
                                                        data-toggle="modal" 
                                                        data-target="#modalResetPassword"
                                                        data-id="<?= $user['id_user'] ?>"
                                                        data-username="<?= esc($user['username']) ?>"
                                                        data-role="Dosen"
                                                        title="Reset Password">
                                                    <i class="fa fa-key"></i>
                                                </button>
                                                <button class="btn btn-info btn-xs btn-flat" 
                                                        data-toggle="modal" 
                                                        data-target="#modalChangeUsername"
                                                        data-id="<?= $user['id_user'] ?>"
                                                        data-username="<?= esc($user['username']) ?>"
                                                        title="Ubah Username">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Tambah Admin -->
<div class="modal fade" id="modalTambahAdmin">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-user-plus"></i> Tambah Admin Baru</h4>
            </div>
            <form action="<?= site_url('admin/user-management/create-admin') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Username <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-control" required 
                               placeholder="Masukkan username">
                    </div>
                    <div class="form-group">
                        <label>Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" required 
                               minlength="6" placeholder="Minimal 6 karakter">
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password <span class="text-danger">*</span></label>
                        <input type="password" name="confirm_password" class="form-control" required 
                               minlength="6" placeholder="Ulangi password">
                    </div>
                    <div class="alert alert-warning">
                        <i class="fa fa-warning"></i> <strong>Perhatian:</strong> Simpan username dan password dengan aman!
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Reset Password -->
<div class="modal fade" id="modalResetPassword">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-key"></i> Reset Password</h4>
            </div>
            <form action="<?= site_url('admin/user-management/reset-password') ?>" method="post">
                <input type="hidden" name="id_user" id="reset_id_user">
                <div class="modal-body">
                    <div class="alert alert-info">
                        <strong>User:</strong> <span id="reset_username"></span> (<span id="reset_role"></span>)
                    </div>
                    <div class="form-group">
                        <label>Password Baru <span class="text-danger">*</span></label>
                        <input type="password" name="new_password" class="form-control" required 
                               minlength="6" placeholder="Minimal 6 karakter">
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password <span class="text-danger">*</span></label>
                        <input type="password" name="confirm_password" class="form-control" required 
                               minlength="6" placeholder="Ulangi password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fa fa-key"></i> Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Change Username -->
<div class="modal fade" id="modalChangeUsername">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-edit"></i> Ubah Username</h4>
            </div>
            <form action="<?= site_url('admin/user-management/change-username') ?>" method="post">
                <input type="hidden" name="id_user" id="change_id_user">
                <div class="modal-body">
                    <div class="alert alert-info">
                        <strong>Username Saat Ini:</strong> <span id="change_current_username"></span>
                    </div>
                    <div class="form-group">
                        <label>Username Baru <span class="text-danger">*</span></label>
                        <input type="text" name="new_username" class="form-control" required 
                               placeholder="Masukkan username baru">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info">
                        <i class="fa fa-save"></i> Ubah Username
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    // Initialize DataTables for each tab
    $('#tableAdmin').DataTable();
    $('#tableMahasiswa').DataTable();
    $('#tableDosen').DataTable();

    // Modal Reset Password
    $('#modalResetPassword').on('show.bs.modal', function(e) {
        const button = $(e.relatedTarget);
        const id = button.data('id');
        const username = button.data('username');
        const role = button.data('role');
        
        $('#reset_id_user').val(id);
        $('#reset_username').text(username);
        $('#reset_role').text(role);
    });

    // Modal Change Username
    $('#modalChangeUsername').on('show.bs.modal', function(e) {
        const button = $(e.relatedTarget);
        const id = button.data('id');
        const username = button.data('username');
        
        $('#change_id_user').val(id);
        $('#change_current_username').text(username);
    });

    // Delete Admin with SweetAlert
    $('.btn-delete-admin').on('click', function(e) {
        e.preventDefault();
        const url = $(this).data('url');
        const name = $(this).data('name');
        
        Swal.fire({
            title: 'Apakah Anda yakin?',
            html: `Admin <b>${name}</b> akan dihapus permanen!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Menghapus...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                window.location.href = url;
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
