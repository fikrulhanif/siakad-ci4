<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $title ?? 'Dashboard' ?> - Universitas Fikrul Hanif</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="<?= base_url('assets/dist/img/favicon.ico') ?>">
  <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('assets/dist/img/favicon.ico') ?>">

  <!-- CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/bower_components/font-awesome/css/font-awesome.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/dist/css/AdminLTE.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/dist/css/skins/_all-skins.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/bower_components/select2/dist/css/select2.min.css') ?>">
  
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/css/dataTables.bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/css/responsive.bootstrap.min.css') ?>">
  
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.css') ?>">
  
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700">
  
  <!-- Custom CSS for UI Improvements -->
  <style>
    /* Loading Overlay */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    .loading-overlay.active {
        display: flex;
    }
    .loading-spinner {
        border: 5px solid #f3f3f3;
        border-top: 5px solid #3498db;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Smooth Transitions */
    .btn, .form-control, .box {
        transition: all 0.3s ease;
    }

    /* Button Hover Effects */
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    .btn:active {
        transform: translateY(0);
    }

    /* Form Focus Effects */
    .form-control:focus {
        border-color: #3c8dbc;
        box-shadow: 0 0 0 0.2rem rgba(60, 141, 188, 0.25);
    }

    /* Tooltip Custom Style */
    .tooltip-inner {
        background-color: #333;
        color: #fff;
        border-radius: 4px;
        padding: 8px 12px;
        font-size: 13px;
    }
    .tooltip.top .tooltip-arrow {
        border-top-color: #333;
    }

    /* Success Animation */
    @keyframes successPulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }
    .success-pulse {
        animation: successPulse 0.5s ease;
    }

    /* Skeleton Loading */
    .skeleton {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
        border-radius: 4px;
    }
    @keyframes loading {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #999;
    }
    .empty-state i {
        font-size: 64px;
        margin-bottom: 20px;
        opacity: 0.3;
    }
    .empty-state p {
        font-size: 16px;
        margin-bottom: 20px;
    }

    /* Badge Improvements */
    .badge {
        font-weight: 600;
        padding: 4px 8px;
        border-radius: 3px;
    }

    /* Table Row Hover */
    .table-hover tbody tr:hover {
        background-color: #f5f5f5;
        cursor: pointer;
    }

    /* Sticky Table Header */
    .table-sticky thead th {
        position: sticky;
        top: 0;
        background-color: #fff;
        z-index: 10;
        box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
    }

    /* Form Validation Styles */
    .form-control.is-valid {
        border-color: #28a745;
        padding-right: calc(1.5em + .75rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(.375em + .1875rem) center;
        background-size: calc(.75em + .375rem) calc(.75em + .375rem);
    }
    .form-control.is-invalid {
        border-color: #dc3545;
        padding-right: calc(1.5em + .75rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(.375em + .1875rem) center;
        background-size: calc(.75em + .375rem) calc(.75em + .375rem);
    }
    .invalid-feedback, .valid-feedback {
        display: block;
        margin-top: 0.25rem;
        font-size: 80%;
    }
    .invalid-feedback {
        color: #dc3545;
    }
    .valid-feedback {
        color: #28a745;
    }
  </style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
</div>

<div class="wrapper">

  <!-- HEADER -->
  <header class="main-header">
    <a href="<?= base_url('/') ?>" class="logo">
      <span class="logo-mini"><b>U</b>FH</span>
      <span class="logo-lg"><b>Univ</b>FikrulHanif</span>
    </a>
    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li><a href="#" id="btnLogout"><i class="fa fa-sign-out"></i> Logout</a></li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- SIDEBAR -->
  <?= $this->include('layout/sidebar') ?>


  <!-- CONTENT WRAPPER -->
  <div class="content-wrapper">
    <?= $this->renderSection('content') ?>
  </div>

  <!-- FOOTER -->
  <footer class="main-footer text-center">
    <strong>&copy; <?= date('Y') ?> Universitas Fikrul Hanif - Sistem Informasi Akademik</strong>
  </footer>

</div>

<!-- JS -->
<script src="<?= base_url('assets/bower_components/jquery/dist/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/dist/js/adminlte.min.js') ?>"></script>

<!-- DataTables -->
<script src="<?= base_url('assets/plugins/datatables/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables/js/dataTables.bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables/js/dataTables.responsive.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables/js/responsive.bootstrap.min.js') ?>"></script>

<!-- SweetAlert2 -->
<script src="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>

<!-- Global DataTables Config -->
<script>
// Default DataTables config untuk bahasa Indonesia
$.extend(true, $.fn.dataTable.defaults, {
    language: {
        "sEmptyTable": "Tidak ada data yang tersedia",
        "sInfo": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        "sInfoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
        "sInfoFiltered": "(disaring dari _MAX_ total data)",
        "sInfoPostFix": "",
        "sInfoThousands": ".",
        "sLengthMenu": "Tampilkan _MENU_ data",
        "sLoadingRecords": "Sedang memuat...",
        "sProcessing": "Sedang memproses...",
        "sSearch": "Cari:",
        "sZeroRecords": "Tidak ditemukan data yang sesuai",
        "oPaginate": {
            "sFirst": "Pertama",
            "sLast": "Terakhir",
            "sNext": "Selanjutnya",
            "sPrevious": "Sebelumnya"
        },
        "oAria": {
            "sSortAscending": ": aktifkan untuk mengurutkan kolom naik",
            "sSortDescending": ": aktifkan untuk mengurutkan kolom turun"
        }
    },
    responsive: true,
    pageLength: 10,
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
    dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
         "<'row'<'col-sm-12'tr>>" +
         "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    order: [[0, 'asc']]
});
</script>

<!-- Global SweetAlert Helper -->
<script>
// Helper function untuk konfirmasi delete
function confirmDelete(url, itemName = 'data ini') {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        html: `<b>${itemName}</b> akan dihapus permanen!`,
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
}

// Helper function untuk toast notification
function showToast(icon, message) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    Toast.fire({
        icon: icon,
        title: message
    });
}

// Helper function untuk loading saat submit form
function showLoading(message = 'Menyimpan data...') {
    Swal.fire({
        title: message,
        text: 'Mohon tunggu sebentar',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
}
</script>

<?= $this->renderSection('script') ?>

<!-- Flash Messages dengan SweetAlert -->
<script>
<?php if (session()->getFlashdata('success')): ?>
    showToast('success', '<?= addslashes(session()->getFlashdata('success')) ?>');
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    showToast('error', '<?= addslashes(session()->getFlashdata('error')) ?>');
<?php endif; ?>

<?php if (session()->getFlashdata('warning')): ?>
    showToast('warning', '<?= addslashes(session()->getFlashdata('warning')) ?>');
<?php endif; ?>

<?php if (session()->getFlashdata('info')): ?>
    showToast('info', '<?= addslashes(session()->getFlashdata('info')) ?>');
<?php endif; ?>

<?php if (session()->getFlashdata('log_success')): ?>
    Swal.fire({
        icon: 'success',
        title: 'Login Berhasil!',
        text: '<?= addslashes(session()->getFlashdata('log_success')) ?>',
        showConfirmButton: false,
        timer: 2000
    });
<?php endif; ?>
</script>

<!-- Logout Confirmation -->
<script>
const btnLogout = document.getElementById('btnLogout');
if (btnLogout) {
    btnLogout.addEventListener('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Yakin ingin logout?',
            text: "Session Anda akan berakhir dan harus login kembali.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Logout',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading('Logging out...');
                window.location.href = "<?= site_url('logout') ?>";
            }
        });
    });
}
</script>

<!-- Global UI Improvements -->
<script>
$(document).ready(function() {
    // 1. Initialize Bootstrap Tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // 2. Auto-focus first input in forms
    $('form').each(function() {
        const firstInput = $(this).find('input:not([type="hidden"]):not([readonly]):first, textarea:first, select:first').first();
        if (firstInput.length) {
            setTimeout(() => firstInput.focus(), 100);
        }
    });
    
    // 3. Form Submit Loading
    $('form').on('submit', function(e) {
        const form = $(this);
        
        // Skip if form has data-no-loading attribute
        if (form.attr('data-no-loading')) {
            return true;
        }
        
        // Disable submit button to prevent double submit
        form.find('button[type="submit"]').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Memproses...');
        
        // Show loading overlay
        $('#loadingOverlay').addClass('active');
    });
    
    // 4. Confirm before leaving page with unsaved changes
    let formChanged = false;
    
    // Only track changes for forms that don't auto-submit (exclude navigation forms)
    $('form input, form textarea, form select').on('change', function() {
        const $form = $(this).closest('form');
        
        // Ignore if form has data-no-confirm attribute or if the changed element has onchange="this.form.submit()"
        if ($form.attr('data-no-confirm') || $(this).attr('onchange')) {
            return;
        }
        
        formChanged = true;
    });
    
    $('form').on('submit', function() {
        formChanged = false;
    });
    
    $(window).on('beforeunload', function() {
        if (formChanged) {
            return 'Anda memiliki perubahan yang belum disimpan. Yakin ingin meninggalkan halaman?';
        }
    });
    
    // 5. Keyboard Shortcuts
    $(document).on('keydown', function(e) {
        // Ctrl/Cmd + S: Prevent default save and trigger form submit
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            const form = $('form:visible').first();
            if (form.length) {
                form.submit();
                showToast('info', 'Menyimpan data...');
            }
        }
        
        // Esc: Close modals
        if (e.key === 'Escape') {
            $('.modal').modal('hide');
            Swal.close();
        }
    });
    
    // 6. Auto-hide alerts after 5 seconds
    $('.alert:not(.alert-permanent)').delay(5000).fadeOut('slow');
    
    // 7. Smooth scroll to top button
    if ($('.back-to-top').length === 0) {
        $('body').append('<a href="#" class="back-to-top" style="display:none; position:fixed; bottom:20px; right:20px; background:#3c8dbc; color:#fff; width:40px; height:40px; text-align:center; line-height:40px; border-radius:50%; z-index:9999;"><i class="fa fa-arrow-up"></i></a>');
    }
    
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn();
        } else {
            $('.back-to-top').fadeOut();
        }
    });
    
    $('.back-to-top').click(function(e) {
        e.preventDefault();
        $('html, body').animate({scrollTop: 0}, 600);
        return false;
    });
    
    // 8. Add loading state to buttons with data-loading attribute
    $('[data-loading]').on('click', function() {
        const btn = $(this);
        const originalText = btn.html();
        const loadingText = btn.data('loading') || 'Memproses...';
        
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> ' + loadingText);
        
        // Restore after 5 seconds (fallback)
        setTimeout(() => {
            btn.prop('disabled', false).html(originalText);
        }, 5000);
    });
    
    // 9. Confirm links with data-confirm attribute
    $('[data-confirm]').on('click', function(e) {
        e.preventDefault();
        const link = $(this);
        const message = link.data('confirm') || 'Apakah Anda yakin?';
        const url = link.attr('href');
        
        Swal.fire({
            title: 'Konfirmasi',
            text: message,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading();
                window.location.href = url;
            }
        });
    });
    
    // 10. Number input validation
    $('input[type="number"]').on('keypress', function(e) {
        // Allow: backspace, delete, tab, escape, enter
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
            // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
            (e.keyCode === 67 && (e.ctrlKey === true || e.metaKey === true)) ||
            (e.keyCode === 86 && (e.ctrlKey === true || e.metaKey === true)) ||
            (e.keyCode === 88 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    
    // 11. Email validation on blur
    $('input[type="email"]').on('blur', function() {
        const email = $(this).val();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (email && !emailRegex.test(email)) {
            $(this).addClass('is-invalid');
            if ($(this).next('.invalid-feedback').length === 0) {
                $(this).after('<div class="invalid-feedback">Format email tidak valid</div>');
            }
        } else {
            $(this).removeClass('is-invalid').addClass('is-valid');
            $(this).next('.invalid-feedback').remove();
        }
    });
    
    // 12. Required field validation on blur
    $('input[required], textarea[required], select[required]').on('blur', function() {
        const field = $(this);
        if (!field.val() || field.val().trim() === '') {
            field.addClass('is-invalid');
            if (field.next('.invalid-feedback').length === 0) {
                field.after('<div class="invalid-feedback">Field ini wajib diisi</div>');
            }
        } else {
            field.removeClass('is-invalid').addClass('is-valid');
            field.next('.invalid-feedback').remove();
        }
    });
    
    // Remove validation on input
    $('input, textarea, select').on('input change', function() {
        $(this).removeClass('is-invalid is-valid');
        $(this).next('.invalid-feedback, .valid-feedback').remove();
    });
});

// Helper: Show loading overlay
function showLoadingOverlay() {
    $('#loadingOverlay').addClass('active');
}

// Helper: Hide loading overlay
function hideLoadingOverlay() {
    $('#loadingOverlay').removeClass('active');
}

// Helper: Disable form
function disableForm(formSelector) {
    $(formSelector).find('input, textarea, select, button').prop('disabled', true);
}

// Helper: Enable form
function enableForm(formSelector) {
    $(formSelector).find('input, textarea, select, button').prop('disabled', false);
}
</script>


</body>
</html>
