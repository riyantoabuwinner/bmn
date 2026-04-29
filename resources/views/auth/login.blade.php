@extends('adminlte::master')

@section('adminlte_css')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            overflow: hidden;
            background: #fff;
        }
        .login-container {
            display: flex;
            height: 100vh;
            width: 100%;
        }
        /* Left Side - Form */
        .login-form-side {
            width: 40%;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            position: relative;
            z-index: 2;
        }
        .login-form-wrapper {
            width: 100%;
            max-width: 400px;
        }
        .login-header h2 {
            font-weight: 700;
            color: #333;
            font-size: 28px;
            margin-bottom: 5px;
        }
        .login-header p {
            color: #888;
            font-size: 14px;
            margin-bottom: 15px;
        }
        .form-control {
            height: 45px;
            border-radius: 8px;
            border: 1px solid #eee;
            background: #f8f9fa;
            padding-left: 15px;
            font-size: 14px;
            transition: all 0.3s;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            background: #fff;
        }
        .input-group-text {
            border: none;
            background: transparent;
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            pointer-events: none;
        }
        .form-group {
            position: relative;
            margin-bottom: 12px;
        }
        .btn-login {
            height: 45px;
            border-radius: 8px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            font-weight: 600;
            font-size: 16px;
            letter-spacing: 0.5px;
            box-shadow: 0 10px 20px rgba(118, 75, 162, 0.2);
            transition: all 0.3s;
            margin-top: 5px;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 25px rgba(118, 75, 162, 0.3);
            background: linear-gradient(135deg, #5a6fd6 0%, #673ab7 100%);
        }
        .captcha-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
        }
        .captcha-image {
            border-radius: 8px;
            overflow: hidden;
            flex-grow: 1;
            height: 55px;
            border: 1px solid #eee;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .captcha-image img {
            max-width: 100%;
            height: auto;
            display: block;
        }
        .btn-refresh {
            width: 55px;
            height: 55px;
            border-radius: 8px;
            background: #f8f9fa;
            border: 1px solid #eee;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #764ba2;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-refresh:hover {
            background: #eee;
            color: #667eea;
        }
        .custom-control-label {
            font-size: 14px;
            color: #666;
            cursor: pointer;
        }
        .forgot-password {
            color: #764ba2;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
        }
        
        /* Right Side - Illustration */
        .login-image-side {
            width: 60%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: white;
            padding: 40px;
            overflow: hidden;
        }
        /* Abstract Shapes */
        .shape {
            position: absolute;
            opacity: 0.1;
            border-radius: 50%;
        }
        .shape-1 { width: 400px; height: 400px; background: #fff; top: -100px; right: -100px; }
        .shape-2 { width: 300px; height: 300px; background: #fff; bottom: -50px; left: -50px; }
        .shape-3 { width: 150px; height: 150px; border: 20px solid #fff; top: 20%; left: 20%; animation: float 6s infinite ease-in-out; }
        
        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(10deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }

        .hero-content {
            position: relative;
            z-index: 10;
            text-align: center;
            max-width: 500px;
        }
        .hero-title {
            font-size: 42px;
            font-weight: 800;
            margin-bottom: 20px;
            line-height: 1.2;
            text-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .hero-subtitle {
            font-size: 18px;
            opacity: 0.9;
            font-weight: 300;
            line-height: 1.6;
        }
        .hero-illustration {
            position: relative;
            width: 100%;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        .central-icon {
            font-size: 180px;
            color: rgba(255, 255, 255, 0.9);
            filter: drop-shadow(0 10px 20px rgba(0,0,0,0.2));
            z-index: 2;
            animation: float 6s infinite ease-in-out;
        }
        .floating-icon {
            position: absolute;
            color: rgba(255, 255, 255, 0.6);
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            animation: float 8s infinite ease-in-out;
        }
        .icon-1 { font-size: 40px; width: 80px; height: 80px; top: 10%; right: 20%; animation-delay: 1s; }
        .icon-2 { font-size: 35px; width: 70px; height: 70px; bottom: 20%; left: 15%; animation-delay: 2s; }
        .icon-3 { font-size: 30px; width: 60px; height: 60px; top: 20%; left: 20%; animation-delay: 3s; }
        .icon-4 { font-size: 45px; width: 90px; height: 90px; bottom: 10%; right: 15%; animation-delay: 0.5s; }

        @media (max-width: 768px) {
            .login-form-side { width: 100%; padding: 40px; }
            .login-image-side { display: none; }
        }
    </style>
@stop

@section('body')
    <div class="login-container">
        <!-- Left Side: Form -->
        <div class="login-form-side">
            <div class="login-form-wrapper">
                <div class="login-header text-center">
                    <div style="margin-bottom: 20px; display: inline-block; background: #fff; padding: 12px; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                        <img src="{{ asset('img/logo_uinssc.png') }}" alt="Logo" style="height: 55px; width: auto;">
                    </div>
                    <h2 class="notranslate" translate="no" style="font-weight: 800; letter-spacing: -1px; font-size: 32px; color: #1e1b4b;"><span class="bmn-fixed"></span> <span class="core-fixed" style="color: #dc2626 !important; font-style: italic !important;"></span></h2>
                    <p class="notranslate" translate="no" style="color: #6366f1; font-weight: 500; font-size: 13px; margin-bottom: 5px;">Centralized Organization of Resource Ecosystem for <span class="bmn-fixed"></span></p>
                    <p class="notranslate" translate="no" style="color: #94a3b8; font-size: 12px; margin-bottom: 30px;">UIN <span class="siber-fixed"></span> Syekh Nurjati Cirebon</p>
                </div>

            @if (session('status'))
                <div class="alert alert-success mb-3" style="border-radius: 10px;">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label style="font-size: 13px; font-weight: 600; color: #555; margin-bottom: 8px; display: block;">Email Address</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                           placeholder="name@example.com" value="{{ old('email') }}" required autofocus>
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label style="font-size: 13px; font-weight: 600; color: #555; margin-bottom: 8px; display: block;">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                           placeholder="Masukkan password anda" required>
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Captcha -->
                <div class="form-group">
                    <label style="font-size: 13px; font-weight: 600; color: #555; margin-bottom: 8px; display: block;">Captcha</label>
                    <div class="captcha-container">
                        <div class="captcha-image" id="captcha-img">
                            {!! captcha_img('flat') !!}
                        </div>
                        <button type="button" class="btn-refresh" id="refresh-captcha">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                    <input type="text" name="captcha" class="form-control @error('captcha') is-invalid @enderror" 
                           placeholder="Masukkan kode di atas" required>
                    @error('captcha')
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                        <label class="custom-control-label" for="remember">Ingat Saya</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-password">Lupa Password?</a>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-login">
                    Masuk Sekarang
                </button>
                
                <style>
                    .bmn-fixed::after { content: "BMN"; }
                    .siber-fixed::after { content: "Siber"; }
                    .core-fixed::after { content: "Core!"; color: #dc2626 !important; font-style: italic !important; }
                </style>
                <p class="text-center mt-4 text-muted" style="font-size: 13px;">
                    &copy; 2026 PUSTIKOM <span class="notranslate" translate="no">UIN Syekh Nurjati Cirebon</span>. All Rights Reserved.
                </p>
            </form>
            </div>
        </div>

        <!-- Right Side: Illustration -->
        <div class="login-image-side">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
            
            <div class="hero-content">
                <div class="hero-illustration">
                    <div class="central-icon">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <div class="floating-icon icon-1">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <div class="floating-icon icon-2">
                        <i class="fas fa-chair"></i>
                    </div>
                    <div class="floating-icon icon-3">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="floating-icon icon-4">
                        <i class="fas fa-building"></i>
                    </div>
                </div>
                     
                <h1 class="hero-title notranslate" translate="no" style="font-size: 52px;"><span class="bmn-fixed"></span> <span class="core-fixed" style="color: #dc2626 !important; font-style: italic !important;"></span></h1>
                <p class="hero-subtitle notranslate" translate="no" style="font-weight: 600; font-size: 20px; margin-bottom: 10px;">
                    Centralized Organization of Resource Ecosystem for <span class="bmn-fixed"></span>
                </p>
                <p class="notranslate" translate="no" style="font-size: 16px; opacity: 0.8; letter-spacing: 1px;">
                    UIN <span class="siber-fixed"></span> Syekh Nurjati Cirebon
                </p>
            </div>
        </div>
    </div>
@stop

@section('adminlte_js')
<script>
    document.getElementById('refresh-captcha').onclick = function() {
        fetch('/refresh-captcha')
            .then(response => response.json())
            .then(data => {
                document.getElementById('captcha-img').innerHTML = data.captcha;
            });
    };
</script>
@stop
