<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Universitas Fikrul Hanif</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/dist/img/favicon.ico') ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('assets/dist/img/favicon.ico') ?>">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="<?= base_url('assets/plugins/bootstrap5/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/plugins/fontawesome6/css/all.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/plugins/aos/aos.css') ?>" rel="stylesheet">

    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
            overflow: hidden;
            font-family: 'Poppins', sans-serif;
        }

        /* Container untuk Vanta JS */
        #vanta-canvas {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
        }

        .login-wrapper {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-card {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 900px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            color: #fff;
            display: flex;
            gap: 40px;
            align-items: center;
        }

        /* Left Section - Logo */
        .logo-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        /* Logo Container with Animation */
        .logo-container {
            position: relative;
            width: 280px;
            height: 280px;
            margin: 0 auto 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .logo-img {
            width: 270px;
            height: 270px;
            object-fit: contain;
            position: relative;
            z-index: 2;
            animation: logoFloat 3s ease-in-out infinite;
            filter: drop-shadow(0 10px 20px rgba(56, 189, 248, 0.3));
        }

        /* Floating Animation */
        @keyframes logoFloat {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-15px);
            }
        }

        /* Rotating Ring 1 */
        .ring-1 {
            position: absolute;
            width: 260px;
            height: 260px;
            border: 3px solid rgba(56, 189, 248, 0.3);
            border-radius: 50%;
            animation: rotateRing1 8s linear infinite;
        }

        @keyframes rotateRing1 {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        /* Rotating Ring 2 */
        .ring-2 {
            position: absolute;
            width: 300px;
            height: 300px;
            border: 3px dashed rgba(56, 189, 248, 0.2);
            border-radius: 50%;
            animation: rotateRing2 12s linear infinite reverse;
        }

        @keyframes rotateRing2 {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        /* Pulsing Glow */
        .glow-pulse {
            position: absolute;
            width: 280px;
            height: 280px;
            background: radial-gradient(circle, rgba(56, 189, 248, 0.2) 0%, transparent 70%);
            border-radius: 50%;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 0.5;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }
        }

        /* Orbiting Dots */
        .orbit-dot {
            position: absolute;
            width: 10px;
            height: 10px;
            background: #38bdf8;
            border-radius: 50%;
            box-shadow: 0 0 15px rgba(56, 189, 248, 0.8);
        }

        .orbit-dot-1 {
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            animation: orbitDot1 4s linear infinite;
        }

        .orbit-dot-2 {
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            animation: orbitDot2 4s linear infinite;
        }

        .orbit-dot-3 {
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            animation: orbitDot3 4s linear infinite;
        }

        .orbit-dot-4 {
            top: 50%;
            right: 0;
            transform: translateY(-50%);
            animation: orbitDot4 4s linear infinite;
        }

        @keyframes orbitDot1 {
            0%, 100% { top: 0; left: 50%; }
            25% { top: 0; left: 100%; }
            50% { top: 100%; left: 100%; }
            75% { top: 100%; left: 0; }
        }

        @keyframes orbitDot2 {
            0%, 100% { bottom: 0; left: 50%; }
            25% { bottom: 100%; left: 50%; }
            50% { bottom: 100%; left: 0; }
            75% { bottom: 0; left: 0; }
        }

        @keyframes orbitDot3 {
            0%, 100% { top: 50%; left: 0; }
            25% { top: 0; left: 0; }
            50% { top: 0; left: 100%; }
            75% { top: 50%; left: 100%; }
        }

        @keyframes orbitDot4 {
            0%, 100% { top: 50%; right: 0; }
            25% { top: 100%; right: 0; }
            50% { top: 100%; right: 100%; }
            75% { top: 50%; right: 100%; }
        }

        .logo-text {
            text-align: center;
            margin-top: 10px;
        }

        .logo-text h4 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #fff;
            margin: 0;
            letter-spacing: 0.5px;
        }

        .logo-text p {
            font-size: 0.85rem;
            color: #94a3b8;
            margin: 5px 0 0 0;
        }

        /* Right Section - Form */
        .form-section {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .form-section h3 {
            font-weight: 600;
            letter-spacing: 1px;
            margin-bottom: 5px;
            color: #fff;
            font-size: 1.8rem;
        }

        .brand-text {
            color: #38bdf8;
            font-size: 1rem;
            font-weight: 500;
            margin-bottom: 25px;
            display: inline-block;
            letter-spacing: 1px;
            font-family: 'Poppins', sans-serif;
            border-right: 2px solid #38bdf8;
            white-space: nowrap;
            overflow: hidden;
            animation: typewriter 8s steps(30) infinite, blink 0.75s step-end infinite;
        }

        @keyframes typewriter {
            0% {
                width: 0;
            }
            20% {
                width: 30ch;
            }
            60% {
                width: 30ch;
            }
            80%, 100% {
                width: 0;
            }
        }

        @keyframes blink {
            from, to {
                border-color: transparent;
            }
            50% {
                border-color: #38bdf8;
            }
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 500;
            color: #e2e8f0;
            margin-bottom: 8px;
        }

        .input-group-text {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #38bdf8;
            border-radius: 10px 0 0 10px;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            padding: 12px;
            border-radius: 0 10px 10px 0;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6) !important;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: #38bdf8;
            color: #fff;
            box-shadow: none;
        }

        /* Toggle Password Styling */
        .password-toggle {
            cursor: pointer;
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            color: #94a3b8;
            transition: 0.3s;
        }

        .password-toggle:hover {
            color: #38bdf8;
        }

        .btn-login {
            background: #38bdf8;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            color: #0f172a;
            width: 100%;
            margin-top: 20px;
            transition: all 0.3s;
            box-shadow: 0 10px 15px -3px rgba(56, 189, 248, 0.4);
        }

        .btn-login:hover {
            background: #0ea5e9;
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(56, 189, 248, 0.5);
        }

        .alert {
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid rgba(239, 68, 68, 0.4);
            color: #fca5a5;
            font-size: 0.85rem;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .footer-text {
            text-align: center;
            margin-top: 20px;
            font-size: 0.8rem;
            color: aliceblue;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .login-card {
                flex-direction: column;
                max-width: 420px;
                padding: 30px;
            }

            .logo-container {
                width: 200px;
                height: 200px;
            }

            .logo-img {
                width: 180px;
                height: 180px;
            }

            .ring-1 {
                width: 180px;
                height: 180px;
            }

            .ring-2 {
                width: 220px;
                height: 220px;
            }

            .glow-pulse {
                width: 200px;
                height: 200px;
            }

            .form-section h3 {
                font-size: 1.5rem;
            }

            .logo-text h4 {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>

    <div id="vanta-canvas"></div>

    <div class="login-wrapper">
        <div class="login-card" data-aos="fade-up">
            <!-- Left Section - Logo with Animations -->
            <div class="logo-section">
                <div class="logo-container">
                    <div class="glow-pulse"></div>
                    <div class="ring-1"></div>
                    <div class="ring-2"></div>
                    <div class="orbit-dot orbit-dot-1"></div>
                    <div class="orbit-dot orbit-dot-2"></div>
                    <div class="orbit-dot orbit-dot-3"></div>
                    <div class="orbit-dot orbit-dot-4"></div>
                    <img src="<?= base_url('assets/dist/img/Logobgremove.png') ?>" alt="Logo Universitas" class="logo-img">
                </div>
                <div class="logo-text">
                    <h4>UNIVERSITAS FIKRUL HANIF</h4>
                    <p>Sistem Informasi Akademik</p>
                </div>
            </div>

            <!-- Right Section - Login Form -->
            <div class="form-section">
                <div class="text-center">
                    <h3>PORTAL <span style="color: #38bdf8;">AKADEMIK</span></h3>
                    <span class="brand-text">Silahkan <span style="color: aliceblue;">Login</span> Terlebih Dahulu...</span>
                </div>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger animate__animated animate__headShake">
                        <i class="fa fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('login/process') ?>" method="post">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                            <input type="text" name="username" class="form-control" placeholder="Masukkan Username" required autocomplete="off">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group position-relative">
                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            <input type="password" name="password" id="passwordInput" class="form-control" placeholder="Masukkan Password" required style="border-radius: 0 10px 10px 0;">
                            <i class="fa fa-eye password-toggle" id="togglePassword"></i>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-login">
                        LOGIN <i class="fa fa-arrow-right ms-2"></i>
                    </button>
                </form>

                <div class="footer-text">
                    &copy; <?= date('Y') ?> Universitas Fikrul Hanif
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="<?= base_url('assets/plugins/bootstrap5/js/bootstrap.bundle.min.js') ?>"></script>
    
    <script src="<?= base_url('assets/plugins/vanta/three.min.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/vanta/vanta.globe.min.js') ?>"></script>

    <script src="<?= base_url('assets/plugins/aos/aos.js') ?>"></script>

    <script>
        // Inisialisasi AOS
        AOS.init({ duration: 1000, once: true });

        // Inisialisasi Vanta JS Globe
        VANTA.GLOBE({
            el: "#vanta-canvas",
            mouseControls: true,
            touchControls: true,
            gyroControls: false,
            minHeight: 200.00,
            minWidth: 200.00,
            scale: 1.00,
            scaleMobile: 1.00,
            color: 0x38bdf8,       /* Warna garis globe */
            color2: 0xffffff,      /* Warna titik */
            backgroundColor: 0x0f172a, /* Warna background (Deep Navy) */
            size: 1.10
        });

        // Toggle Password View
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#passwordInput');

        togglePassword.addEventListener('click', function (e) {
            // Toggle tipe input
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // Toggle icon
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>