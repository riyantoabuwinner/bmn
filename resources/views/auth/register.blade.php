@extends('adminlte::master')

@section('adminlte_css')
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Outfit', sans-serif;
            height: 100vh;
            overflow: hidden;
            background: #fff;
        }
        .register-container {
            display: flex;
            height: 100vh;
            width: 100%;
        }
        
        /* Left Side - Form */
        .register-form-side {
            width: 40%;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 0 60px;
            position: relative;
            z-index: 2;
            box-shadow: 10px 0 30px rgba(0,0,0,0.05);
            overflow-y: auto;
        }
        
        .register-logo-container {
            margin-bottom: 30px; 
            display: inline-flex; 
            align-items: center;
            gap: 15px;
        }
        .register-logo-container img { height: 50px; width: auto; }
        .register-logo-container span { font-size: 24px; font-weight: 700; color: #1e293b; letter-spacing: -0.5px; }

        .register-header h2 {
            font-weight: 800;
            color: #1e293b;
            font-size: 28px;
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }
        .register-header p {
            color: #64748b;
            font-size: 15px;
            margin-bottom: 30px;
            line-height: 1.5;
        }
        
        .form-group { position: relative; margin-bottom: 20px; }
        
        .form-control {
            height: 52px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            padding-left: 50px; /* Space for icon */
            font-size: 15px;
            transition: all 0.3s;
            color: #334155;
            width: 100%;
        }
        .form-control:focus {
            border-color: #4F46E5;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
            background: #fff;
            outline: none;
        }
        
        .input-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 16px;
            pointer-events: none;
            transition: color 0.3s;
        }
        .form-control:focus + .input-icon { color: #4F46E5; }
        
        .btn-register {
            height: 54px;
            border-radius: 12px;
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            border: none;
            font-weight: 600;
            font-size: 16px;
            color: white;
            letter-spacing: 0.5px;
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
            transition: all 0.3s;
            margin-top: 10px;
            cursor: pointer;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(79, 70, 229, 0.4);
        }
        
        .login-link {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
            color: #64748b;
        }
        .login-link a {
            color: #4F46E5;
            font-weight: 600;
            text-decoration: none;
        }
        .login-link a:hover { text-decoration: underline; }

        /* Right Side - Illustration */
        .register-image-side {
            width: 60%;
            background: linear-gradient(135deg, #1e1b4b, #312e81); /* Deep Indigo */
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: white;
            padding: 40px;
            overflow: hidden;
        }
        
        /* Background Noise/Pattern */
        .register-image-side::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.05'/%3E%3C/svg%3E");
            opacity: 0.2;
        }

        /* Abstract Shapes */
        .circle-glow {
            position: absolute;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(124, 58, 237, 0.2) 0%, rgba(0,0,0,0) 70%);
            border-radius: 50%;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
        }

        .illustration-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 30px;
            padding: 60px;
            text-align: center;
            max-width: 500px;
            position: relative;
            z-index: 10;
            box-shadow: 0 25px 50px rgba(0,0,0,0.2);
            animation: float 6s infinite ease-in-out;
        }

        .illustration-icon {
            font-size: 80px;
            margin-bottom: 30px;
            background: linear-gradient(135deg, #A855F7, #EC4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 10px 20px rgba(168, 85, 247, 0.3));
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        @media (max-width: 992px) {
            .register-form-side { width: 100%; padding: 40px 30px; }
            .register-image-side { display: none; }
        }
        /* Force Accessibility Button Position */
        .acc-widget-btn {
            position: fixed !important;
            bottom: 90px !important;
            right: 20px !important;
            width: 50px !important;
            height: 50px !important;
            background-color: #2563eb !important;
            border: 3px solid white !important;
            border-radius: 50% !important;
            z-index: 10001 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: white !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2) !important;
        }
        .acc-menu {
            bottom: 150px !important;
            z-index: 10002 !important;
        }
    </style>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
@stop

@section('body')
    <x-accessibility-widget />
    <x-ai-chat-bot />
    <div class="register-container">
        <!-- Left Side: Form -->
        <div class="register-form-side">
            <div class="register-logo-container">
                <img src="{{ asset('img/logo_uinssc.png') }}" alt="Logo">
                <span>BMN System</span>
            </div>
            
            <div class="register-header">
                <h2>Buat Akun Baru</h2>
                <p>Silahkan lengkapi formulir di bawah ini untuk mendaftar akun baru.</p>
            </div>

            <form action="{{ route('register') }}" method="post">
                @csrf
                
                <div class="form-group">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Nama Lengkap" autofocus>
                    <i class="fas fa-user input-icon"></i>
                    @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email">
                    <i class="fas fa-envelope input-icon"></i>
                    @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                    <i class="fas fa-lock input-icon"></i>
                    @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password">
                    <i class="fas fa-lock input-icon"></i>
                </div>
                
                <div class="form-group" style="margin-bottom: 25px;">
                    <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.key', '1x00000000000000000000AA') }}"></div>
                    @error('cf-turnstile-response')
                        <span class="text-danger small">Verifikasi keamanan gagal. Silakan coba lagi.</span>
                    @enderror
                </div>

                <button type="submit" class="btn-register">
                    {{ __('adminlte::adminlte.register') }} <i class="fas fa-arrow-right"></i>
                </button>
            </form>

            <div class="login-link">
                {{ __('adminlte::adminlte.i_already_have_a_membership') }}
                <a href="{{ route('login') }}">Masuk</a>
            </div>
        </div>
        
        <!-- Right Side: Illustration -->
        <div class="register-image-side">
            <div class="circle-glow"></div>
            <div class="illustration-card">
                <div class="illustration-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3 style="font-size: 28px; font-weight: 700; margin-bottom: 15px;">Aman & Terpercaya</h3>
                <p style="font-size: 16px; opacity: 0.8; line-height: 1.6; color: #e2e8f0;">
                    Sistem Manajemen Aset Negara yang terintegrasi. <br>
                    Kami menjaga data Anda dengan standar keamanan tertinggi.
                </p>
            </div>
        </div>
    </div>
@stop
