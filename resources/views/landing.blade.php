<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'BMN System') }} - Sistem Manajemen Aset Terintegrasi</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #4F46E5;
            --secondary: #7C3AED;
            --accent: #F59E0B;
            --dark: #1F2937;
            --light: #F9FAFB;
            --glass: rgba(255, 255, 255, 0.1);
        }
        
        body {
            font-family: 'Outfit', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
            color: var(--dark);
            overflow-x: hidden;
        }

        /* Navbar */
        .navbar {
            display: flex;
            justify-content: center; /* Centered container */
            align-items: center;
            padding: 1rem 0;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .auth-buttons {
            display: flex;
            align-items: center;
            gap: 15px; /* Consistent spacing */
        }

        .logo {
            display: flex;
            align-items: center;
            font-weight: 800;
            font-size: 1.6rem;
            color: var(--dark);
            text-decoration: none;
            letter-spacing: -0.5px;
        }

        .logo span {
            background: linear-gradient(135deg, #4338ca, #7C3AED); /* Deep Purple */
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .logo img {
            height: 45px;
            margin-right: 12px;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
        }

        .nav-links {
            display: flex;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: #4B5563;
            font-weight: 500;
            margin-right: 2.5rem; /* Spacing between links */
            transition: color 0.3s;
            position: relative;
            font-size: 0.95rem;
        }
        
        .nav-links a:last-child { margin-right: 0; }

        .nav-links a:hover { color: #7C3AED; }

        .btn {
            padding: 0.7rem 1.5rem; /* Adjusted padding */
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            display: flex; /* Flex to align content */
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 0.95rem;
            height: 45px; /* Fixed height for alignment */
            box-sizing: border-box;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4F46E5, #7C3AED);
            color: white;
            box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3);
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(79, 70, 229, 0.4);
        }
        
        .btn-outline {
            background: white;
            color: #4F46E5;
            border: 1px solid #E0E7FF;
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        }

        .btn-outline:hover {
            border-color: #4F46E5;
            color: #4338ca;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px rgba(0,0,0,0.05);
        }

        /* Hero Section - Deep Luxury Purple */
        .hero {
            display: flex; /* Fallback */
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 140px 0 80px;
            background: #1e1b4b; /* Deep background foundation */
            background-image: 
                radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), 
                radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(339,49%,30%,1) 0, transparent 50%);
            position: relative;
            overflow: hidden;
        }

        /* Luxury Noise Texture */
        .hero::after {
            content: "";
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.05'/%3E%3C/svg%3E");
            opacity: 0.15;
            pointer-events: none;
            z-index: 1;
        }

        .hero::before {
            content: ''; /* decorative glow */
            position: absolute;
            top: -200px;
            right: -100px;
            width: 800px;
            height: 800px;
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.4), rgba(79, 70, 229, 0.4));
            border-radius: 50%;
            filter: blur(120px);
            z-index: 0;
            opacity: 0.6;
        }

        .hero-container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            display: grid; /* Use Grid for better layout control */
            grid-template-columns: 1.2fr 1fr; /* Text larger than image */
            gap: 4rem;
            align-items: center;
            position: relative;
            z-index: 2; /* Above texture */
        }

        .hero-content {
            z-index: 10;
        }

        .hero h1 {
            font-size: 4rem;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            color: white; 
            font-weight: 800;
            letter-spacing: -1.5px;
        }
        
        .hero h1 span {
             background: linear-gradient(135deg, #A5B4FC, #C4B5FD); 
             -webkit-background-clip: text;
             -webkit-text-fill-color: transparent;
        }

        .hero p {
            font-size: 1.25rem;
            color: #E0E7FF; 
            margin-bottom: 3rem;
            line-height: 1.6;
            font-weight: 300;
            opacity: 0.9;
            max-width: 90%;
        }

        .cta-group {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        
        /* Specific override for hero buttons to fix full-width issue */
        .cta-group .btn {
            width: auto !important; 
            min-width: 160px;
        }

        .hero-image {
            position: relative;
            width: 100%;
            height: 600px;
            display: flex;
            align-items: center;
            justify-content: center;
            perspective: 2000px; /* Deep perspective */
        }

        .hero-image {
            position: relative;
            width: 100%;
            height: 600px;
            display: flex;
            align-items: center;
            justify-content: center;
            perspective: 2000px; /* Deep perspective */
        }

        /* Ultra-Luxury 3D Scene CSS */
        .scene {
            width: 500px;
            height: 400px;
            position: relative;
            transform-style: preserve-3d;
            transform: rotateX(60deg) rotateZ(-30deg) translateZ(-50px);
            animation: floatScene 8s ease-in-out infinite;
        }

        @keyframes floatScene {
            0%, 100% { transform: rotateX(60deg) rotateZ(-30deg) translateZ(-50px); }
            50% { transform: rotateX(60deg) rotateZ(-30deg) translateZ(-20px); }
        }

        /* Base Platform (Deep Purple) */
        .platform {
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #1e1b4b, #312e81); /* Deep Indigo */
            border-radius: 40px;
            box-shadow: 
                0 0 0 1px rgba(124, 58, 237, 0.5), /* Violet Border */
                0 50px 100px rgba(0,0,0,0.6), /* Deep shadow */
                inset 0 0 80px rgba(30, 27, 75, 0.8); 
            transform: translateZ(0);
        }

        /* Glass Sheets (Modern Glassmorphism) */
        .glass-sheet {
            position: absolute;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(167, 139, 250, 0.3); /* Light Purple Border */
            box-shadow: 0 10px 30px rgba(0,0,0,0.2); 
            transform-style: preserve-3d;
            transition: all 0.5s;
        }

        .sheet-1 { /* Main Dashboard */
            width: 90%; height: 90%;
            top: 5%; left: 5%;
            transform: translateZ(20px);
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0.02));
            border: 1px solid rgba(124, 58, 237, 0.3); 
        }

        .sheet-2 { /* Panel */
            width: 40%; height: 50%;
            top: 15%; right: 10%;
            transform: translateZ(50px);
            background: rgba(124, 58, 237, 0.1); /* Violet Tint */
            border: 1px solid rgba(139, 92, 246, 0.4); 
            box-shadow: 0 0 15px rgba(139, 92, 246, 0.2);
        }

        .sheet-3 { /* Panel */
            width: 35%; height: 60%;
            bottom: 15%; left: 10%;
            transform: translateZ(40px);
            background: rgba(79, 70, 229, 0.1); /* Indigo Tint */
            border: 1px solid rgba(99, 102, 241, 0.4); 
        }

        /* Floating Elements (Gradient Brand Colors) */
        .floating-icon {
            position: absolute;
            width: 60px; height: 60px;
            background: linear-gradient(135deg, #4F46E5, #4338ca); /* Primary Indigo */
            border: none;
            border-radius: 15px;
            display: flex; justify-content: center; align-items: center;
            font-size: 24px; color: white; 
            box-shadow: 0 10px 20px rgba(79, 70, 229, 0.4);
            transform: translateZ(80px);
            animation: bounce 4s infinite ease-in-out;
        }

        .icon-1 { top: -20px; right: 20%; animation-delay: 0s; }
        .icon-2 { bottom: 20%; left: -20px; background: linear-gradient(135deg, #7C3AED, #6D28D9); box-shadow: 0 10px 20px rgba(124, 58, 237, 0.4); animation-delay: 1s; } /* Violet */
        .icon-3 { top: 40%; left: 45%; background: linear-gradient(135deg, #EC4899, #DB2777); box-shadow: 0 10px 20px rgba(236, 72, 153, 0.4); animation-delay: 2s; } /* Pink Accent */

        @keyframes bounce {
            0%, 100% { transform: translateZ(80px); }
            50% { transform: translateZ(100px); }
        }

        /* Holographic Elements (Violet Glow) */
        .hologram-circle {
            position: absolute;
            width: 150px; height: 150px;
            border: 2px solid rgba(139, 92, 246, 0.5); 
            border-radius: 50%;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%) translateZ(10px);
            box-shadow: 0 0 30px rgba(139, 92, 246, 0.3);
            animation: pulseRing 4s infinite linear;
        }

        @keyframes pulseRing {
            0% { transform: translate(-50%, -50%) translateZ(10px) scale(1); opacity: 0.8; }
            50% { transform: translate(-50%, -50%) translateZ(10px) scale(1.1); opacity: 0.4; }
            100% { transform: translate(-50%, -50%) translateZ(10px) scale(1); opacity: 0.8; }
        }

        @keyframes pulse {
            0% { opacity: 0.4; transform: translateZ(60px) scale(1); }
            50% { opacity: 1; transform: translateZ(60px) scale(1.2); }
            100% { opacity: 0.4; transform: translateZ(60px) scale(1); }
        }



        @media (max-width: 992px) {
            .hero-container {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 3rem;
            }
            .hero h1 { font-size: 3rem; }
            .hero p { margin: 0 auto 2rem; max-width: 100%; }
            .cta-group { justify-content: center; }
            .hero-image { order: -1; margin-bottom: 2rem; } /* Image on top mobile */
        }

        /* Features Section */
        .features {
            padding: 6rem 5%;
            background: #fff;
            position: relative;
        }

        .section-title {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-title h2 {
            font-size: 2.5rem;
            color: var(--dark);
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .section-title p {
            color: #6B7280;
            max-width: 600px;
            margin: 0 auto;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2.5rem;
        }

        .feature-card {
            padding: 2.5rem;
            border-radius: 20px;
            background: linear-gradient(145deg, #ffffff, #f9fafb);
            border: 1px solid rgba(0,0,0,0.05);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            opacity: 0;
            z-index: -1;
            transition: opacity 0.4s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .feature-card:hover::before { opacity: 0.03; }

        .feature-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #e0e7ff, #ede9fe);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
            transition: all 0.4s;
        }

        .feature-card:hover .feature-icon {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            transform: rotateY(180deg);
        }

        .feature-card h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .feature-card p {
            color: #6B7280;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }
        
        /* Stats Section */
        .stats {
            background: linear-gradient(135deg, #1e1b4b, #312e81);
            color: white;
            padding: 5rem 5%;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .stats::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .stats-grid {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .stat-item h3 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            background: linear-gradient(to right, #a5b4fc, #fff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .stat-item p {
            font-size: 1.1rem;
            color: #c7d2fe;
            font-weight: 500;
        }

        /* Footer */
        .footer {
            background: white;
            padding: 4rem 5% 2rem;
            border-top: 1px solid #e5e7eb;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 4rem;
            margin-bottom: 3rem;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--dark);
            margin-bottom: 1.5rem;
        }
        
        .footer-logo img { height: 40px; margin-right: 10px; }

        .footer p { color: #6B7280; line-height: 1.6; max-width: 300px; }

        .footer h4 {
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: var(--dark);
        }

        .footer-links a {
            display: block;
            color: #6B7280;
            text-decoration: none;
            margin-bottom: 0.8rem;
            transition: color 0.3s;
        }

        .footer-links a:hover { color: var(--primary); }
        
        .copyright {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid #f3f4f6;
            color: #9CA3AF;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .hero {
                flex-direction: column;
                text-align: center;
                padding-top: 130px;
            }
            .hero-content { margin-bottom: 3rem; }
            .hero-image { width: 90%; }
            .hero h1 { font-size: 2.8rem; }
            .nav-links { display: none; }
            .footer-grid { grid-template-columns: 1fr; gap: 2rem; }
            .stats-grid { flex-direction: column; gap: 2rem; }
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="container">
            <a href="#" class="logo">
                <img src="{{ asset('img/logo_uinssc.png') }}" alt="Logo">
                <span>BMN System</span>
            </a>
            <div class="nav-links">
                <a href="#fitur">Fitur Unggulan</a>
                <a href="#layanan">Layanan</a>
                <a href="#statistik">Statistik</a>
            </div>
            <div class="auth-buttons">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">
                        <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Daftar Akun</a>
                @endauth
            </div>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-container">
            <div class="hero-content" data-aos="fade-up">
                <h1>Manajemen Aset Digital<br><span>Standar Masa Depan</span></h1>
                <p>Platform terintegrasi untuk pengelolaan Barang Milik Negara (BMN) yang presisi, transparan, dan akuntabel. Dilengkapi dengan teknologi QR Code dan pelaporan realtime.</p>
                <div class="cta-group">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">Akses Dashboard &rarr;</a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary">Mulai Sekarang &rarr;</a>
                        <a href="{{ route('login') }}" class="btn btn-outline" style="border:none; margin-left: 10px;">Sudah punya akun?</a>
                    @endauth
                </div>
            </div>

            <div class="hero-image" data-aos="fade-left">
            <div class="hero-image" data-aos="fade-left">
                <!-- Ultra-Luxury CSS 3D Scene (Gold & Obsidian) -->
                <div class="scene">
                    <div class="platform"></div>
                    
                    <!-- Obsidian Layers -->
                    <div class="glass-sheet sheet-1"></div>
                    <div class="glass-sheet sheet-2"></div>
                    <div class="glass-sheet sheet-3"></div>
                    
                    <!-- Golden Halo -->
                    <div class="hologram-circle"></div>

                    <!-- Floating BMN Assets (Gold Finish) -->
                    <div class="floating-icon icon-1" title="Aset Tetap (Gedung)">
                        <i class="fas fa-city"></i>
                    </div>
                    <div class="floating-icon icon-2" title="Aset Bergerak (Transportasi)">
                        <i class="fas fa-car-side"></i>
                    </div>
                    <div class="floating-icon icon-3" title="Inventaris (Elektronik)">
                        <i class="fas fa-laptop"></i>
                    </div>

                    <!-- Luxury Particles (Purple/Pink Glow) -->
                    <div style="position: absolute; top: 20%; left: 20%; width: 6px; height: 6px; background: #A855F7; border-radius: 50%; box-shadow: 0 0 15px #A855F7; transform: translateZ(60px); animation: pulse 3s infinite;"></div>
                    <div style="position: absolute; bottom: 30%; right: 30%; width: 4px; height: 4px; background: #EC4899; border-radius: 50%; box-shadow: 0 0 10px #EC4899; transform: translateZ(70px); animation: pulse 4s infinite;"></div>
                </div>
            </div>
            </div>
        </div>
    </section>

    <section class="features" id="fitur">
        <div class="section-title" data-aos="fade-up">
            <h2>Fitur Unggulan</h2>
            <p>Solusi lengkap untuk kebutuhan inventarisasi dan pelaporan aset negara.</p>
        </div>
        
        <div class="feature-grid">
            <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-icon"><i class="fas fa-boxes"></i></div>
                <h3>Manajemen Aset Tetap</h3>
                <p>Pencatatan detail untuk tanah, gedung, peralatan, dan mesin. Dilengkapi riwayat pemeliharaan dan perhitungan penyusutan otomatis.</p>
            </div>
            
            <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-icon"><i class="fas fa-dolly-flatbed"></i></div>
                <h3>Kontrol Persediaan</h3>
                <p>Monitoring stok aset lancar (ATK/Bahan Habis Pakai) secara realtime dengan notifikasi batas minimum stok.</p>
            </div>
            
            <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-icon"><i class="fas fa-qrcode"></i></div>
                <h3>Digital Tracking (QR)</h3>
                <p>Setiap aset dilengkapi QR Code unik untuk kemudahan identifikasi, audit fisik (opname), dan pelacakan lokasi.</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-icon"><i class="fas fa-chart-pie"></i></div>
                <h3>Pelaporan Cerdas</h3>
                <p>Dashboard analitik interaktif dan export laporan standar sesuai regulasi pengelolaan BMN.</p>
            </div>
        </div>
    </section>

    <section class="services" id="layanan" style="padding: 6rem 5%; background: #f8fafc;">
        <div class="section-title" data-aos="fade-up">
            <h2>Layanan & Transaksi</h2>
            <p>Modul lengkap untuk mendukung siklus hidup aset.</p>
        </div>
        <div class="services-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1.5rem; max-width: 1200px; margin: 0 auto;">
            <div class="service-item" data-aos="fade-up" style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); display: flex; align-items: center;">
                <div style="background: #EEF2FF; padding: 10px; border-radius: 8px; color: var(--primary); margin-right: 15px;"><i class="fas fa-file-import"></i></div>
                <span style="font-weight: 600;">Import Data Aset</span>
            </div>
            <div class="service-item" data-aos="fade-up" data-aos-delay="100" style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); display: flex; align-items: center;">
                <div style="background: #EEF2FF; padding: 10px; border-radius: 8px; color: var(--primary); margin-right: 15px;"><i class="fas fa-truck-loading"></i></div>
                <span style="font-weight: 600;">Mutasi / Transfer</span>
            </div>
            <div class="service-item" data-aos="fade-up" data-aos-delay="200" style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); display: flex; align-items: center;">
                <div style="background: #EEF2FF; padding: 10px; border-radius: 8px; color: var(--primary); margin-right: 15px;"><i class="fas fa-hand-holding-usd"></i></div>
                <span style="font-weight: 600;">Peminjaman Aset</span>
            </div>
            <div class="service-item" data-aos="fade-up" data-aos-delay="300" style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); display: flex; align-items: center;">
                <div style="background: #EEF2FF; padding: 10px; border-radius: 8px; color: var(--primary); margin-right: 15px;"><i class="fas fa-tools"></i></div>
                <span style="font-weight: 600;">Pemeliharaan</span>
            </div>
            <div class="service-item" data-aos="fade-up" data-aos-delay="400" style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); display: flex; align-items: center;">
                <div style="background: #EEF2FF; padding: 10px; border-radius: 8px; color: var(--primary); margin-right: 15px;"><i class="fas fa-trash-alt"></i></div>
                <span style="font-weight: 600;">Penghapusan</span>
            </div>
            <div class="service-item" data-aos="fade-up" data-aos-delay="500" style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); display: flex; align-items: center;">
                <div style="background: #EEF2FF; padding: 10px; border-radius: 8px; color: var(--primary); margin-right: 15px;"><i class="fas fa-file-contract"></i></div>
                <span style="font-weight: 600;">RKBMN (Perencanaan)</span>
            </div>
             <div class="service-item" data-aos="fade-up" data-aos-delay="600" style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); display: flex; align-items: center;">
                <div style="background: #EEF2FF; padding: 10px; border-radius: 8px; color: var(--primary); margin-right: 15px;"><i class="fas fa-shield-alt"></i></div>
                <span style="font-weight: 600;">Audit & Wasdal</span>
            </div>
             <div class="service-item" data-aos="fade-up" data-aos-delay="700" style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); display: flex; align-items: center;">
                <div style="background: #EEF2FF; padding: 10px; border-radius: 8px; color: var(--primary); margin-right: 15px;"><i class="fas fa-print"></i></div>
                <span style="font-weight: 600;">Cetak Label QR</span>
            </div>
        </div>
    </section>

    <section class="stats" id="statistik">
        <div class="stats-grid">
            <div class="stat-item" data-aos="zoom-in">
                <h3>{{ number_format($stats['total_assets']) }}</h3>
                <p>Total Aset Tercatat</p>
            </div>
            <div class="stat-item" data-aos="zoom-in" data-aos-delay="100">
                <h3>{{ $stats['total_units'] }}</h3>
                <p>Unit Kerja Terintegrasi</p>
            </div>
            <div class="stat-item" data-aos="zoom-in" data-aos-delay="200">
                <h3>Rp {{ number_format($stats['total_value'] / 1000000000, 1) }} M</h3>
                <p>Nilai Aset Terkelola</p>
            </div>
        </div>
    </section>

    <footer class="footer" id="kontak">
        <div class="footer-grid">
            <div>
                <a href="#" class="footer-logo">
                    <img src="{{ asset('img/logo_uinssc.png') }}" alt="Logo">
                    BMN System
                </a>
                <p>Sistem informasi terdepan untuk tata kelola Barang Milik Negara yang efisien, transparan, dan modern.</p>
            </div>
            <div class="footer-links">
                <h4>Navigasi</h4>
                <a href="#">Beranda</a>
                <a href="#fitur">Fitur</a>
                <a href="{{ route('login') }}">Masuk Sistem</a>
            </div>
            <div class="footer-links">
                <h4>Bantuan</h4>
                <a href="#">Panduan Penggunaan</a>
                <a href="#">FAQ</a>
                <a href="#">Hubungi Admin</a>
            </div>
        </div>
        <div class="copyright">
            &copy; {{ date('Y') }} UINSSC BMN System. All rights reserved. developed by Antigravity.
        </div>
    </footer>

    <!-- AOS Script -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>
</body>
</html>
