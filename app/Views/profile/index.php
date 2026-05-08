<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
    /* Background Page - Sedikit gelap & soft (tidak putih menyilaukan) */
    .content-wrapper { 
        background-color: #e2e5eaff !important; 
    }

    /* Card Styling */
    .profile-card, .nav-tabs-custom {
        border-radius: 15px !important;
        border: none !important;
        box-shadow: 0 10px 25px rgba(0,0,0,0.25) !important;
        overflow: hidden;
        background: #f2efefff !important;
    }

    /* Box Profile Sidebar */
    .box-profile {
        padding-top: 30px !important;
        background: linear-gradient(to bottom, #f8f9fa 0%, #ffffff 100%);
    }

    .profile-user-img {
        border: 4px solid #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        width: 130px !important;
        height: 130px !important;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .profile-user-img:hover {
        transform: scale(1.05);
    }

    /* Tabs Styling */
    .nav-tabs-custom > .nav-tabs {
        background: #f4f7f9 !important;
        border-bottom: 1px solid #ddd !important;
    }

    .nav-tabs-custom > .nav-tabs > li > a {
        color: #777;
        font-weight: 600;
        padding: 15px 25px;
        transition: all 0.3s;
    }

    .nav-tabs-custom > .nav-tabs > li.active {
        border-top-color: #3c8dbc !important;
    }

    .nav-tabs-custom > .nav-tabs > li.active > a {
        background: #fff !important;
        color: #3c8dbc !important;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    /* Section Header */
    .page-header {
        font-size: 14px;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: #555;
        border-bottom: 2px solid #3c8dbc;
        display: inline-block;
        margin-bottom: 25px;
        padding-bottom: 5px;
        font-weight: 800;
    }

    /* Input Styling */
    .form-control {
        border-radius: 8px !important;
        border: 1px solid #d2d6de;
        padding: 10px 15px;
        height: auto;
        transition: all 0.3s;
    }

    .form-control:focus {
        border-color: #3c8dbc;
        box-shadow: 0 0 8px rgba(60, 141, 188, 0.2);
    }

    .input-group-addon {
        background-color: #f9f9f9 !important;
        border-radius: 8px 0 0 8px !important;
        border-right: none;
    }

    /* Label Styling */
    .control-label {
        color: #444;
        font-weight: 600 !important;
        padding-top: 10px !important;
    }

    /* Button Styling */
    .btn-flat {
        border-radius: 8px !important;
        padding: 10px 25px;
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }

    /* Custom Radio styling */
    .radio-group {
        display: flex;
        gap: 20px;
        padding-top: 7px;
    }

    /* Badge Role */
    .role-badge {
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 11px;
        background: #e1f0ff;
        color: #007bff;
        font-weight: 700;
    }
</style>

<section class="content">
    <div class="row">
        <div class="col-md-4">
            <div class="box profile-card">
                <div class="box-body box-profile text-center">
                    <?php
                    $pathFoto = session()->get('foto') ? base_url('uploads/profile/' . session()->get('foto')) : base_url('assets/dist/img/default.jpeg');
?>
                    <img class="profile-user-img img-responsive img-circle center-block" src="<?= $pathFoto ?>" alt="User profile picture">
                    
                    <h3 class="profile-username" style="font-weight: 700; color: #333; margin-top: 20px;"><?= $user['nama'] ?? 'Administrator' ?></h3>
                    <div style="margin-bottom: 25px;">
                        <span class="role-badge"><i class="fa fa-shield"></i> <?= strtoupper(session()->get('role')) ?></span>
                    </div>

                    <ul class="list-group list-group-unbordered text-left" style="padding: 0 15px;">
                        <li class="list-group-item" style="border-top: none;">
                            <i class="fa fa-id-card-o text-muted"></i> <b>ID Nomor</b> 
                            <span class="pull-right text-bold" style="color: #3c8dbc;"><?= $user['nim'] ?? ($user['nidn'] ?? '-') ?></span>
                        </li>
                        <li class="list-group-item">
                            <i class="fa fa-graduation-cap text-muted"></i> <b>Program Studi</b> 
                            <span class="pull-right text-muted"><?= $user['nama_prodi'] ?? '-' ?></span>
                        </li>
                    </ul>

                    <div style="padding: 15px;">
                        <form action="<?= base_url('profile/updateFoto') ?>" method="post" enctype="multipart/form-data">
                            <div class="form-group text-left">
                                <label style="font-size: 12px; color: #888;"><i class="fa fa-image"></i> GANTI FOTO PROFIL</label>
                                <input type="file" name="foto" class="form-control" accept="image/*" required onchange="this.form.submit()">
                                <small class="text-muted" style="display:block; margin-top:5px italic;">*Format: JPG/PNG, Maks 2MB</small>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#biodata" data-toggle="tab"><i class="fa fa-id-card"></i> BIODATA LENGKAP</a>
                    </li>
                    <li>
                        <a href="#password" data-toggle="tab"><i class="fa fa-key"></i> KEAMANAN AKUN</a>
                    </li>
                </ul>
                <div class="tab-content" style="padding: 30px;">
                    
                    <div class="active tab-pane flash-anim" id="biodata">
                        <?php if (session()->get('role') != 'admin'): ?>
                        <form action="<?= base_url('profile/updateBiodata') ?>" method="post" class="form-horizontal">
                            <h4 class="page-header">Informasi Dasar</h4>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">NIK (No. KTP)</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                        <input type="text" name="nik" class="form-control" value="<?= $user['nik'] ?? '' ?>" placeholder="16 Digit NIK" maxlength="16">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Tempat & Tgl Lahir</label>
                                <div class="col-sm-5">
                                    <input type="text" name="tempat_lahir" class="form-control" value="<?= $user['tempat_lahir'] ?? '' ?>" placeholder="Tempat Lahir">
                                </div>
                                <div class="col-sm-4">
                                    <input type="date" name="tgl_lahir" class="form-control" value="<?= $user['tgl_lahir'] ?? '' ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Jenis Kelamin</label>
                                <div class="col-sm-9">
                                    <div class="radio-group">
                                        <label style="cursor: pointer; font-weight: 500;">
                                            <input type="radio" name="jenkel" value="L" <?= ($user['jenkel'] ?? '') == 'L' ? 'checked' : '' ?>> Laki-laki
                                        </label>
                                        <label style="cursor: pointer; font-weight: 500;">
                                            <input type="radio" name="jenkel" value="P" <?= ($user['jenkel'] ?? '') == 'P' ? 'checked' : '' ?>> Perempuan
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Agama</label>
                                <div class="col-sm-9">
                                    <select name="agama" class="form-control">
                                        <option value="">-- Pilih Agama --</option>
                                        <?php $agamas = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu'];
                            foreach ($agamas as $ag): ?>
                                            <option value="<?= $ag ?>" <?= ($user['agama'] ?? '') == $ag ? 'selected' : '' ?>><?= $ag ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <h4 class="page-header" style="margin-top: 40px;">Kontak & Alamat</h4>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Email Aktif</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                                        <input type="email" name="email" class="form-control" value="<?= $user['email'] ?? '' ?>" placeholder="nama@email.com">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Nomor WhatsApp</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-whatsapp"></i></span>
                                        <input type="text" name="no_hp" class="form-control" value="<?= $user['no_hp'] ?? '' ?>" placeholder="08xxxxxxx">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Alamat Lengkap</label>
                                <div class="col-sm-9">
                                    <textarea name="alamat" class="form-control" rows="3" placeholder="Jl. Nama Jalan, No Rumah, Kelurahan, Kecamatan..."><?= $user['alamat'] ?? '' ?></textarea>
                                </div>
                            </div>

                            <div class="form-group" style="margin-top: 30px;">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-check-circle"></i> SIMPAN PERUBAHAN</button>
                                </div>
                            </div>
                        </form>
                        <?php else: ?>
                            <div class="text-center" style="padding: 60px 0;">
                                <img src="<?= base_url('assets/dist/img/admin-badge.png') ?>" style="width: 100px; opacity: 0.5;">
                                <h4 style="color: #999; margin-top: 20px;">Mode Administrator Tidak Memiliki Biodata</h4>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="tab-pane flash-anim" id="password">
                        <form action="<?= base_url('profile/updatePassword') ?>" method="post" class="form-horizontal">
                            <div class="alert alert-info" style="border: none; border-left: 5px solid #3c8dbc; background: #f0f8ff; color: #3c8dbc;">
                                <i class="fa fa-lock"></i> <b>Tips Keamanan:</b> Gunakan minimal 8 karakter dengan kombinasi huruf dan angka.
                            </div>
                            
                            <div class="form-group" style="margin-top: 30px;">
                                <label class="col-sm-3 control-label">Password Saat Ini</label>
                                <div class="col-sm-9">
                                    <input type="password" name="pass_lama" class="form-control" required placeholder="Konfirmasi password lama">
                                </div>
                            </div>
                            <hr style="border-top: 1px dashed #eee;">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Password Baru</label>
                                <div class="col-sm-9">
                                    <input type="password" name="pass_baru" class="form-control" required placeholder="Masukkan password baru">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Ulangi Password</label>
                                <div class="col-sm-9">
                                    <input type="password" name="konfirmasi" class="form-control" required placeholder="Ketik ulang password baru">
                                </div>
                            </div>
                            <div class="form-group" style="margin-top: 30px;">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-refresh"></i> GANTI PASSWORD</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<script>
    $(document).ready(function() {
        // Efek transisi antar tab agar lebih smooth
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $('.tab-pane').addClass('animated fadeIn');
        });

        <?php if (session()->getFlashdata('success')) : ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= session()->getFlashdata('success') ?>',
                timer: 2500,
                showConfirmButton: false,
                background: '#fff',
                iconColor: '#28a745'
            });
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '<?= session()->getFlashdata('error') ?>',
                confirmButtonColor: '#d33'
            });
        <?php endif; ?>
    });
</script>
<?= $this->endSection() ?>