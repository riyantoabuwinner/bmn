<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMN Core - Centralized Organization of Resource Ecosystem for BMN</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Accessibility & App Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary: #4F46E5;
            --secondary: #7C3AED;
            --accent: #F59E0B;
            --dark: #1F2937;
            --light: #F9FAFB;
            --glass: rgba(255, 255, 255, 0.1);
        }

        /* Dark Mode Colors */
        .dark {
            --light: #111827;
            --dark: #F9FAFB;
            --glass: rgba(0, 0, 0, 0.3);
        }
        .dark body {
            background-color: #111827;
            color: #F9FAFB;
        }
        .dark .navbar {
            background: rgba(17, 24, 39, 0.8);
            border-bottom-color: rgba(255, 255, 255, 0.1);
        }
        .dark .nav-links a, .dark .logo span, .dark .lang-btn-current, .dark .action-btn {
            color: #E5E7EB;
        }
        .dark .lang-dropdown {
            background: #1F2937;
            border-color: #374151;
        }
        .dark .lang-dropdown a {
            color: #E5E7EB;
        }
        .dark .lang-dropdown a:hover {
            background: #374151;
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
            justify-content: center;
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
            gap: 15px;
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

        .logo span:not(.core-fixed) {
            background: linear-gradient(135deg, #4338ca, #7C3AED);
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
            margin-right: 2.5rem;
            transition: color 0.3s;
            position: relative;
            font-size: 0.95rem;
        }
        
        .nav-links a:last-child { margin-right: 0; }
        .nav-links a:hover { color: #7C3AED; }

        .btn {
            padding: 0.7rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 0.95rem;
            height: 45px;
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

        /* Hero Section */
        .hero {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 140px 0 80px;
            background: #1e1b4b;
            background-image: 
                radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), 
                radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(339,49%,30%,1) 0, transparent 50%);
            position: relative;
            overflow: hidden;
        }

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
            content: '';
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
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 4rem;
            align-items: center;
            position: relative;
            z-index: 2;
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
            perspective: 2000px;
        }

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

        .platform {
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #1e1b4b, #312e81);
            border-radius: 40px;
            box-shadow: 0 0 0 1px rgba(124, 58, 237, 0.5), 0 50px 100px rgba(0,0,0,0.6), inset 0 0 80px rgba(30, 27, 75, 0.8);
            transform: translateZ(0);
        }

        .glass-sheet {
            position: absolute;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(167, 139, 250, 0.3);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2); 
            transform-style: preserve-3d;
        }

        .sheet-1 { width: 90%; height: 90%; top: 5%; left: 5%; transform: translateZ(20px); }
        .sheet-2 { width: 40%; height: 50%; top: 15%; right: 10%; transform: translateZ(50px); background: rgba(124, 58, 237, 0.1); border: 1px solid rgba(139, 92, 246, 0.4); }
        .sheet-3 { width: 35%; height: 60%; bottom: 15%; left: 10%; transform: translateZ(40px); background: rgba(79, 70, 229, 0.1); border: 1px solid rgba(99, 102, 241, 0.4); }

        .floating-icon {
            position: absolute;
            width: 60px; height: 60px;
            background: linear-gradient(135deg, #4F46E5, #4338ca);
            border-radius: 15px;
            display: flex; justify-content: center; align-items: center;
            font-size: 24px; color: white; 
            box-shadow: 0 10px 20px rgba(79, 70, 229, 0.4);
            transform: translateZ(80px);
            animation: bounce 4s infinite ease-in-out;
        }

        .icon-1 { top: -40px; right: 10%; animation-delay: 0s; }
        .icon-2 { bottom: 10%; left: -50px; animation-delay: 1s; }
        .icon-3 { top: -20px; left: 45%; transform: translateZ(180px) !important; animation-delay: 2s; }
        .icon-4 { top: -30px; left: 5%; animation-delay: 0.5s; }
        .icon-5 { bottom: -30px; right: 5%; animation-delay: 1.5s; }

        @keyframes bounce {
            0%, 100% { transform: translateZ(80px); }
            50% { transform: translateZ(100px); }
        }

        /* Skyscraper 3D - Fixed Solid Box Construction */
        .building-3d {
            position: absolute;
            transform-style: preserve-3d;
            pointer-events: none;
        }
        
        /* Container size = Base (Luas Lantai) */
        .building-3d.b-1 { width: 60px; height: 60px; bottom: 40%; left: 20%; }
        .building-3d.b-2 { width: 50px; height: 50px; bottom: 30%; left: 55%; }

        .b-side {
            position: absolute;
            background: rgba(30, 27, 75, 0.95);
            border: 1px solid rgba(255,255,255,0.1);
        }

        /* Building 1 - Tall */
        .b-1 .b-front, .b-1 .b-back { width: 60px; height: 280px; }
        .b-1 .b-left, .b-1 .b-right { width: 60px; height: 280px; }
        .b-1 .b-top { width: 60px; height: 60px; transform: translateZ(280px); }

        /* Building 2 - Medium */
        .b-2 .b-front, .b-2 .b-back { width: 50px; height: 180px; }
        .b-2 .b-left, .b-2 .b-right { width: 50px; height: 180px; }
        .b-2 .b-top { width: 50px; height: 50px; transform: translateZ(180px); }

        /* Solid Box Logic */
        .b-front { bottom: 0; transform-origin: bottom; transform: rotateX(-90deg); background: linear-gradient(to top, #1e1b4b, #312e81); }
        .b-back  { top: 0; transform-origin: top; transform: rotateX(90deg); }
        .b-left  { bottom: 0; left: 0; transform-origin: bottom left; transform: rotateX(-90deg) rotateY(-90deg); }
        .b-right { bottom: 0; right: 0; transform-origin: bottom right; transform: rotateX(-90deg) rotateY(90deg); background: #4338ca; }
        
        .b-top { top: 0; left: 0; background: #06b6d4; box-shadow: 0 0 40px rgba(6, 182, 212, 0.5); border: 1px solid rgba(255,255,255,0.3); }
        .b-2 .b-top { background: #a855f7; box-shadow: 0 0 40px rgba(168, 85, 247, 0.5); }
        .b-2 .b-right { background: #7c3aed; }

        /* Window Patterns */
        .b-side::after {
            content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0;
            background-image: linear-gradient(rgba(255,255,255,0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 8px 12px;
        }

        /* Ikon Warna-Warni (Colorful Icons) */
        .icon-1 { top: -50px; right: 10%; background: linear-gradient(135deg, #3b82f6, #1d4ed8); } /* Biru Cerah */
        .icon-2 { bottom: 5%; left: -60px; background: linear-gradient(135deg, #a855f7, #7e22ce); } /* Ungu */
        .icon-3 { top: -10px; left: 45%; background: linear-gradient(135deg, #ec4899, #be185d); transform: translateZ(200px) !important; } /* Pink/Rose */
        .icon-4 { top: -40px; left: 5%; background: linear-gradient(135deg, #10b981, #047857); } /* Hijau */
        .icon-5 { bottom: -40px; right: 5%; background: linear-gradient(135deg, #f59e0b, #d97706); } /* Oranye/Emas */

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
            0%, 100% { transform: translate(-50%, -50%) translateZ(10px) scale(1); opacity: 0.8; }
            50% { transform: translate(-50%, -50%) translateZ(10px) scale(1.1); opacity: 0.4; }
        }

        /* Nav Accessibility Group */
        .nav-accessibility-group {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-right: 1.5rem;
        }
        .action-btn {
            background: none;
            border: 1px solid #e5e7eb;
            color: #4B5563;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .action-btn:hover {
            border-color: #7C3AED;
            color: #7C3AED;
            background: rgba(124, 58, 237, 0.05);
        }

        .lang-selector { position: relative; }
        .lang-btn-current {
            background: none;
            border: 1px solid #e5e7eb;
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
        }
        .lang-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: 1px solid #f3f4f6;
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            min-width: 160px;
            z-index: 2000;
            margin-top: 10px;
            overflow: hidden;
        }
        .lang-dropdown a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            text-decoration: none;
            color: #4B5563;
            font-size: 0.95rem;
            transition: background 0.3s;
        }
        .lang-dropdown img { width: 22px; height: auto; border-radius: 2px; }
        .lang-dropdown a:hover { background: #f3f4f6; color: #7C3AED; }

        /* Features Section */
        .features { padding: 6rem 5%; background: #fff; }
        .section-title { text-align: center; margin-bottom: 4rem; }
        .section-title h2 { font-size: 2.5rem; color: var(--dark); font-weight: 700; margin-bottom: 1rem; }
        .section-title p { color: #6B7280; max-width: 600px; margin: 0 auto; }
        .feature-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2.5rem; }
        .feature-card { padding: 2.5rem; border-radius: 20px; background: linear-gradient(145deg, #ffffff, #f9fafb); border: 1px solid rgba(0,0,0,0.05); transition: all 0.4s ease; position: relative; overflow: hidden; z-index: 1; }
        .feature-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
        .feature-icon { width: 70px; height: 70px; background: linear-gradient(135deg, #e0e7ff, #ede9fe); border-radius: 18px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; color: var(--primary); margin-bottom: 1.5rem; transition: all 0.4s; }
        .feature-card:hover .feature-icon { background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; transform: rotateY(180deg); }
        .feature-card h3 { font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem; color: var(--dark); }
        .feature-card p { color: #6B7280; line-height: 1.6; }

        /* Stats Section */
        .stats { background: linear-gradient(135deg, #1e1b4b, #312e81); color: white; padding: 5rem 5%; text-align: center; position: relative; }
        .stats-grid { display: flex; justify-content: space-around; flex-wrap: wrap; max-width: 1200px; margin: 0 auto; position: relative; z-index: 2; }
        .stat-item h3 { font-size: 3rem; font-weight: 800; margin-bottom: 0.5rem; background: linear-gradient(to right, #a5b4fc, #fff); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .stat-item p { font-size: 1.1rem; color: #c7d2fe; }

        /* Dropdown Menu */
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #ffffff;
            min-width: 220px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.1);
            z-index: 1000;
            border-radius: 12px;
            padding: 10px 0;
            top: 100%;
            left: 0;
            border: 1px solid rgba(0,0,0,0.05);
            animation: fadeIn 0.3s ease;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }
        .dropdown-content a {
            color: #1e1b4b !important;
            padding: 12px 20px !important;
            text-decoration: none;
            display: block !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            transition: all 0.2s;
            background: transparent !important;
            text-align: left !important;
        }
        .dropdown-content a:hover {
            background-color: #f8fafc !important;
            color: #4338ca !important;
            padding-left: 25px !important;
        }
        .nav-links a i {
            font-size: 10px;
            margin-left: 5px;
        }

        /* Section Styles */
        .section-about {
            padding: 100px 0;
            background: #ffffff;
        }
        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
        }
        .workflow-card {
            background: #f8fafc;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 20px;
            border: 1px solid #e2e8f0;
            position: relative;
            transition: transform 0.3s;
        }
        .workflow-card:hover {
            transform: translateY(-5px);
        }
        .step-number {
            width: 40px;
            height: 40px;
            background: #4338ca;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            margin-bottom: 15px;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Footer */
        .footer { background: white; padding: 4rem 5% 2rem; border-top: 1px solid #e5e7eb; }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 4rem; margin-bottom: 3rem; }
        .footer-logo { display: flex; align-items: center; font-weight: 800; font-size: 1.5rem; margin-bottom: 1.5rem; }
        .footer-logo img { height: 40px; margin-right: 10px; }
        .footer p { color: #6B7280; line-height: 1.6; max-width: 300px; }
        .footer h4 { font-weight: 700; margin-bottom: 1.5rem; }
        .footer-links a { display: block; color: #6B7280; text-decoration: none; margin-bottom: 0.8rem; transition: color 0.3s; }
        .footer-links a:hover { color: var(--primary); }
        .copyright { text-align: center; padding-top: 2rem; border-top: 1px solid #f3f4f6; color: #9CA3AF; font-size: 0.9rem; }

        @media (max-width: 992px) {
            .hero-container { grid-template-columns: 1fr; text-align: center; }
            .hero h1 { font-size: 3rem; }
            .nav-links { display: none; }
            .footer-grid { grid-template-columns: 1fr; gap: 2rem; }
        }
        .bmn-fixed::after { content: "BMN"; }
        .siber-fixed::after { content: "Siber"; }
        .core-fixed::after { content: "Core!"; color: #dc2626 !important; -webkit-text-fill-color: #dc2626 !important; font-style: italic !important; }
        .instansi-fixed::after { content: "UIN Siber Syekh Nurjati Cirebon"; }
    </style>
</head>
<body>
    <x-accessibility-widget />

    <nav class="navbar">
        <div class="container">
            <a href="#" class="logo">
                <img src="{{ asset('img/logo_uinssc.png') }}" alt="Logo">
                <span class="notranslate" translate="no" style="display: flex; flex-direction: column; line-height: 1.2;">
                    <span style="font-size: 2rem; font-weight: 800;"><span class="bmn-fixed"></span> <span class="core-fixed" style="color: #dc2626 !important; font-style: italic !important;"></span></span>
                    <small class="instansi-fixed" style="font-size: 0.95rem; font-weight: 600; background: linear-gradient(135deg, #4338ca, #7C3AED); -webkit-background-clip: text; -webkit-text-fill-color: transparent; text-transform: uppercase;"></small>
                </span>
            </a>
            <div class="nav-links">
                <a href="{{ url('/') }}">Beranda</a>
                <div class="dropdown">
                    <a href="javascript:void(0)">Tentang Kami <i class="fas fa-chevron-down"></i></a>
                    <div class="dropdown-content">
                        <a href="#tentang">Tentang BMN Core!</a>
                        <a href="#alur-kerja">Alur Kerja</a>
                    </div>
                </div>
                <div class="dropdown">
                    <a href="javascript:void(0)">Fitur <i class="fas fa-chevron-down"></i></a>
                    <div class="dropdown-content">
                        <a href="{{ route('features.show', 'master') }}">Master Data & Organisasi</a>
                        <a href="{{ route('features.show', 'aset') }}">Manajemen Aset Tetap</a>
                        <a href="{{ route('features.show', 'persediaan') }}">Aset Lancar / Persediaan</a>
                        <a href="{{ route('features.show', 'rkbmn') }}">Perencanaan (RKBMN)</a>
                        <a href="{{ route('features.show', 'wasdal') }}">Wasdal & Portofolio</a>
                        <a href="{{ route('features.show', 'laporan') }}">Laporan & Monitoring</a>
                    </div>
                </div>
                <a href="#hubungi-kami">Hubungi Kami</a>
            </div>

            <div class="nav-accessibility-group" x-data="{ 
                langOpen: false,
                currentFlag: localStorage.getItem('goog_lang') || 'id',
                get flagUrl() {
                    const map = { 'id': 'id', 'en': 'gb', 'ar': 'sa' };
                    return `https://flagcdn.com/w20/${map[this.currentFlag] || 'id'}.png`;
                }
            }">
                <!-- Dark Mode Toggle -->
                <button @click="window.accessibilityWidget().toggleDarkMode()" class="action-btn" title="Mode Gelap/Terang">
                    <i class="fas fa-moon"></i>
                </button>
                
                <!-- Fullscreen Toggle -->
                <button @click="window.accessibilityWidget().toggleFullscreen()" class="action-btn" title="Layar Penuh">
                    <i class="fas fa-expand"></i>
                </button>

                <!-- Language Selector -->
                <div class="lang-selector" @click.away="langOpen = false">
                    <button class="lang-btn-current" @click="langOpen = !langOpen" title="Pilih Bahasa">
                        <img :src="flagUrl" style="width: 20px; border-radius: 2px;" alt="Flag">
                    </button>
                    <div class="lang-dropdown" x-show="langOpen" x-transition style="display: none;">
                        <a href="javascript:void(0)" @click="window.accessibilityWidget().changeLanguage('id'); currentFlag = 'id'; langOpen = false">
                            <img src="https://flagcdn.com/w20/id.png" alt="ID"> Indonesia
                        </a>
                        <a href="javascript:void(0)" @click="window.accessibilityWidget().changeLanguage('en'); currentFlag = 'en'; langOpen = false">
                            <img src="https://flagcdn.com/w20/gb.png" alt="EN"> Bahasa inggris
                        </a>
                        <a href="javascript:void(0)" @click="window.accessibilityWidget().changeLanguage('ar'); currentFlag = 'ar'; langOpen = false">
                            <img src="https://flagcdn.com/w20/sa.png" alt="AR"> Arab
                        </a>
                    </div>
                </div>
            </div>

            <div class="auth-buttons">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline" style="border: 2px solid #dc2626; color: #dc2626;">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-primary" style="background: linear-gradient(135deg, #4338ca, #7C3AED); color: white; border: none;">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-container">
            <div class="hero-content" data-aos="fade-up">
                <h1>Manajemen Aset Digital<br><span>Standar Masa Depan</span></h1>
                <p>Platform terintegrasi untuk pengelolaan Barang Milik Negara (BMN) yang presisi, transparan, dan akuntabel.</p>
                <div class="cta-group">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">Akses Dashboard &rarr;</a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary">Mulai Sekarang &rarr;</a>
                    @endauth
                </div>
            </div>
            <div class="hero-image" data-aos="fade-left">
                <div class="scene">
                    <div class="platform"></div>
                    <div class="glass-sheet sheet-1"></div>
                    <div class="glass-sheet sheet-2"></div>
                    <div class="glass-sheet sheet-3"></div>
                    <div class="building-3d b-1">
                        <div class="b-side b-front"></div>
                        <div class="b-side b-back"></div>
                        <div class="b-side b-left"></div>
                        <div class="b-side b-right"></div>
                        <div class="b-top"></div>
                    </div>
                    <div class="building-3d b-2">
                        <div class="b-side b-front"></div>
                        <div class="b-side b-back"></div>
                        <div class="b-side b-left"></div>
                        <div class="b-side b-right"></div>
                        <div class="b-top"></div>
                    </div>
                    <div class="floating-icon icon-1" title="Gedung & Bangunan"><i class="fas fa-building"></i></div>
                    <div class="floating-icon icon-2" title="Kendaraan Dinas"><i class="fas fa-car"></i></div>
                    <div class="floating-icon icon-3" title="Perangkat IT"><i class="fas fa-laptop"></i></div>
                    <div class="floating-icon icon-4" title="Peralatan Kantor"><i class="fas fa-chair"></i></div>
                    <div class="floating-icon icon-5" title="Distribusi Barang"><i class="fas fa-truck"></i></div>
                </div>
            </div>
        </div>
    </section>

    <section class="features">
        <div class="section-title" data-aos="fade-up">
            <h2>Fitur Utama Sistem</h2>
            <p>Ekosistem manajemen aset yang komprehensif untuk tata kelola BMN yang lebih baik.</p>
        </div>
        <div class="feature-grid">
            <div id="fitur-master" class="feature-card" data-aos="fade-up">
                <div class="feature-icon"><i class="fas fa-sitemap"></i></div>
                <h3>Master Data & Organisasi</h3>
                <p>Manajemen unit kerja, hak akses pengguna, dan kategorisasi aset secara hierarkis.</p>
            </div>
            <div id="fitur-aset" class="feature-card" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-icon"><i class="fas fa-boxes"></i></div>
                <h3>Manajemen Aset Tetap</h3>
                <p>Pengelolaan lengkap untuk Tanah, Gedung, Peralatan, dan Mesin dengan tracking SIMAN v2.</p>
            </div>
            <div id="fitur-persediaan" class="feature-card" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-icon"><i class="fas fa-dolly-flatbed"></i></div>
                <h3>Aset Lancar / Persediaan</h3>
                <p>Monitoring stok persediaan secara real-time dengan sistem opname yang akurat.</p>
            </div>
            <div id="fitur-rkbmn" class="feature-card" data-aos="fade-up">
                <div class="feature-icon"><i class="fas fa-calendar-alt"></i></div>
                <h3>Perencanaan (RKBMN)</h3>
                <p>Penyusunan rencana kebutuhan, pengadaan, hingga pemeliharaan aset tahunan.</p>
            </div>
            <div id="fitur-wasdal" class="feature-card" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                <h3>Wasdal & Portofolio</h3>
                <p>Pengawasan, pengendalian, dan manajemen portofolio aset untuk optimalisasi pemanfaatan.</p>
            </div>
            <div id="fitur-laporan" class="feature-card" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-icon"><i class="fas fa-file-invoice"></i></div>
                <h3>Laporan & Monitoring</h3>
                <p>Dashboard analitik dan laporan otomatis untuk audit serta rekonsiliasi internal maupun eksternal.</p>
            </div>
        </div>
    </section>

    <!-- Hubungi Kami Section -->
    <section id="hubungi-kami" style="padding: 100px 0; background: #ffffff;">
        <div class="container">
            <div class="section-title text-center" data-aos="fade-up" style="margin-bottom: 60px;">
                <h2 style="font-size: 2.5rem; color: #1e1b4b; font-weight: 800; margin-bottom: 15px;">Hubungi Kami</h2>
                <p style="color: #64748b; font-size: 1.1rem;">Kami siap membantu Anda mengelola ekosistem BMN dengan lebih baik.</p>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 50px;">
                <!-- Info Kontak -->
                <div data-aos="fade-right">
                    <div style="background: linear-gradient(135deg, #1e1b4b 0%, #4338ca 100%); padding: 40px; border-radius: 30px; color: white; height: 100%;">
                        <h3 style="font-size: 1.8rem; font-weight: 700; margin-bottom: 30px;">Informasi Kontak</h3>
                        
                        <div style="margin-bottom: 30px; display: flex; align-items: start; gap: 20px;">
                            <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h4 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 5px;">Alamat Kantor</h4>
                                <p style="font-size: 0.95rem; opacity: 0.8; line-height: 1.5;">Gedung PUSTIKOM Lantai 2, UIN Siber Syekh Nurjati Cirebon<br>Jl. Perjuangan, Kota Cirebon</p>
                            </div>
                        </div>

                        <div style="margin-bottom: 30px; display: flex; align-items: start; gap: 20px;">
                            <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <h4 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 5px;">Email Support</h4>
                                <p style="font-size: 0.95rem; opacity: 0.8;">pustikom@syekhnurjati.ac.id</p>
                            </div>
                        </div>

                        <div style="margin-bottom: 30px; display: flex; align-items: start; gap: 20px;">
                            <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div>
                                <h4 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 5px;">WhatsApp Center</h4>
                                <p style="font-size: 0.95rem; opacity: 0.8;">+62 812-XXXX-XXXX</p>
                            </div>
                        </div>
                        
                        <div style="margin-top: 50px; padding-top: 30px; border-top: 1px solid rgba(255,255,255,0.1);">
                            <p style="font-size: 0.9rem; opacity: 0.7;">Jam Operasional:</p>
                            <p style="font-size: 0.95rem; font-weight: 500;">Senin - Jumat: 08:00 - 16:00 WIB</p>
                        </div>
                    </div>
                </div>

                <!-- Formulir Pesan -->
                <div data-aos="fade-left">
                    <div style="background: #f8fafc; padding: 40px; border-radius: 30px; border: 1px solid #e2e8f0;">
                        <h3 style="font-size: 1.8rem; font-weight: 700; color: #1e1b4b; margin-bottom: 30px;">Kirim Pesan</h3>
                        <form action="#" method="POST">
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                                <div>
                                    <label style="display: block; font-size: 0.9rem; font-weight: 600; color: #475569; margin-bottom: 8px;">Nama Lengkap</label>
                                    <input type="text" placeholder="Masukkan nama" style="width: 100%; padding: 12px 20px; border-radius: 12px; border: 1px solid #cbd5e1; outline: none; transition: 0.3s;" onfocus="this.style.borderColor='#4338ca'; this.style.boxShadow='0 0 0 4px rgba(67, 56, 202, 0.1)'" onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none'">
                                </div>
                                <div>
                                    <label style="display: block; font-size: 0.9rem; font-weight: 600; color: #475569; margin-bottom: 8px;">Alamat Email</label>
                                    <input type="email" placeholder="name@example.com" style="width: 100%; padding: 12px 20px; border-radius: 12px; border: 1px solid #cbd5e1; outline: none; transition: 0.3s;" onfocus="this.style.borderColor='#4338ca'; this.style.boxShadow='0 0 0 4px rgba(67, 56, 202, 0.1)'" onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none'">
                                </div>
                            </div>
                            <div style="margin-bottom: 20px;">
                                <label style="display: block; font-size: 0.9rem; font-weight: 600; color: #475569; margin-bottom: 8px;">Subjek Pesan</label>
                                <input type="text" placeholder="Apa yang ingin Anda tanyakan?" style="width: 100%; padding: 12px 20px; border-radius: 12px; border: 1px solid #cbd5e1; outline: none; transition: 0.3s;" onfocus="this.style.borderColor='#4338ca'; this.style.boxShadow='0 0 0 4px rgba(67, 56, 202, 0.1)'" onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none'">
                            </div>
                            <div style="margin-bottom: 30px;">
                                <label style="display: block; font-size: 0.9rem; font-weight: 600; color: #475569; margin-bottom: 8px;">Isi Pesan</label>
                                <textarea rows="5" placeholder="Tuliskan pesan Anda di sini..." style="width: 100%; padding: 12px 20px; border-radius: 12px; border: 1px solid #cbd5e1; outline: none; transition: 0.3s; resize: none;" onfocus="this.style.borderColor='#4338ca'; this.style.boxShadow='0 0 0 4px rgba(67, 56, 202, 0.1)'" onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none'"></textarea>
                            </div>
                            <button type="submit" style="width: 100%; background: #4338ca; color: white; padding: 15px; border-radius: 12px; border: none; font-weight: 700; font-size: 1rem; cursor: pointer; transition: 0.3s; box-shadow: 0 10px 20px rgba(67, 56, 202, 0.2);">
                                <i class="fas fa-paper-plane" style="margin-right: 10px;"></i> Kirim Pesan Sekarang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Tentang BMN Core! Section -->
    <section id="tentang" class="section-about">
        <div class="container">
            <div class="about-grid">
                <div class="about-content">
                    <span class="badge" style="background: #eef2ff; color: #4338ca; padding: 8px 20px; border-radius: 50px; font-weight: 600; font-size: 14px; margin-bottom: 20px; display: inline-block;">Identitas & Tujuan</span>
                    <h2 style="font-size: 2.5rem; color: #1e1b4b; font-weight: 800; margin-bottom: 25px; line-height: 1.2;">Apa itu <span style="background: linear-gradient(135deg, #4338ca, #7C3AED); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">BMN Core!</span>?</h2>
                    <p style="font-size: 1.1rem; color: #64748b; line-height: 1.8; margin-bottom: 20px;">
                        <strong>BMN Core!</strong> (Centralized Organization of Resource Ecosystem for BMN) adalah platform manajemen aset digital terpadu yang dirancang khusus untuk mengelola Barang Milik Negara (BMN) di lingkungan instansi pendidikan tinggi.
                    </p>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 30px;">
                        <div class="feature-small">
                            <h4 style="color: #1e1b4b; font-weight: 700; margin-bottom: 10px;"><i class="fas fa-bullseye" style="color: #4338ca; margin-right: 10px;"></i>Untuk Apa?</h4>
                            <p style="font-size: 0.95rem; color: #64748b;">Mewujudkan tata kelola aset yang akuntabel, transparan, dan efisien melalui sistem digital terpusat.</p>
                        </div>
                        <div class="feature-small">
                            <h4 style="color: #1e1b4b; font-weight: 700; margin-bottom: 10px;"><i class="fas fa-check-circle" style="color: #4338ca; margin-right: 10px;"></i>Manfaat</h4>
                            <p style="font-size: 0.95rem; color: #64748b;">Mempermudah monitoring, pelaporan, dan pemeliharaan aset secara real-time dari satu pintu.</p>
                        </div>
                    </div>
                </div>
                <div class="about-image" style="background: linear-gradient(135deg, #4338ca, #7C3AED); border-radius: 30px; padding: 40px; color: white;">
                    <h3 style="font-weight: 800; margin-bottom: 20px;">Kenapa BMN Core!?</h3>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 15px; display: flex; align-items: start;"><i class="fas fa-check" style="margin-top: 5px; margin-right: 15px;"></i> Mengatasi kerumitan pencatatan manual yang rentan kesalahan.</li>
                        <li style="margin-bottom: 15px; display: flex; align-items: start;"><i class="fas fa-check" style="margin-top: 5px; margin-right: 15px;"></i> Standarisasi data sesuai dengan kebutuhan SIMAN v2.</li>
                        <li style="margin-bottom: 15px; display: flex; align-items: start;"><i class="fas fa-check" style="margin-top: 5px; margin-right: 15px;"></i> Mempercepat proses pengambilan keputusan terkait manajemen aset.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Alur Kerja Section -->
    <section id="alur-kerja" style="padding: 100px 0; background: #f8fafc;">
        <div class="container">
            <div class="text-center" style="margin-bottom: 60px;">
                <h2 style="font-size: 2.5rem; color: #1e1b4b; font-weight: 800; margin-bottom: 15px;">Alur Kerja Sistem</h2>
                <p style="color: #64748b; font-size: 1.1rem;">Bagaimana BMN Core! mengelola ekosistem aset Anda</p>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                <div class="workflow-card text-center">
                    <div class="step-number" style="margin: 0 auto 20px;">1</div>
                    <h4 style="font-weight: 700; color: #1e1b4b;">Inisialisasi Data</h4>
                    <p style="font-size: 0.95rem; color: #64748b;">Sinkronisasi data awal dari sistem pusat (SIMAN) ke dalam database lokal BMN Core!.</p>
                </div>
                <div class="workflow-card text-center">
                    <div class="step-number" style="margin: 0 auto 20px;">2</div>
                    <h4 style="font-weight: 700; color: #1e1b4b;">Pengolahan & Monitoring</h4>
                    <p style="font-size: 0.95rem; color: #64748b;">Aset dikelola berdasarkan modul (PSP, BAST, Pemeliharaan) dengan tracking status real-time.</p>
                </div>
                <div class="workflow-card text-center">
                    <div class="step-number" style="margin: 0 auto 20px;">3</div>
                    <h4 style="font-weight: 700; color: #1e1b4b;">Pelaporan & Rekonsiliasi</h4>
                    <p style="font-size: 0.95rem; color: #64748b;">Sistem menghasilkan laporan otomatis untuk kebutuhan audit dan rekonsiliasi data pusat.</p>
                </div>
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
                <p>Sistem informasi terdepan untuk tata kelola Barang Milik Negara.</p>
            </div>
            <div class="footer-links">
                <h4>Navigasi</h4>
                <a href="#">Beranda</a>
                <a href="#fitur">Fitur</a>
            </div>
            <div class="footer-links">
                <h4>Bantuan</h4>
                <a href="#">FAQ</a>
                <a href="#">Hubungi Admin</a>
            </div>
        </div>
        <div class="copyright">@2026 PUSTIKOM <span class="notranslate" translate="no">UIN Syekh Nurjati Cirebon</span>. All Rights Reserved</div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ duration: 800, once: true });</script>
</body>
</html>
