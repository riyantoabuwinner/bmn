<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $feature['title'] }} - BMN Core!</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo_uinssc.png') }}">
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <style>
        :root {
            --primary: #4338ca;
            --primary-dark: #1e1b4b;
            --secondary: #7C3AED;
            --accent: #dc2626;
            --text-main: #1e1b4b;
            --text-muted: #64748b;
            --bg-light: #f8fafc;
            --glass: rgba(255, 255, 255, 0.8);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; color: var(--text-main); background: var(--bg-light); line-height: 1.6; }

        .container { max-width: 1200px; margin: 0 auto; padding: 0 5%; }

        /* Navbar Style (Reused) */
        nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }
        .nav-content { display: flex; justify-content: space-between; align-items: center; }
        .logo { display: flex; align-items: center; text-decoration: none; }
        .logo img { height: 45px; margin-right: 15px; }
        .nav-links a { text-decoration: none; color: var(--text-main); font-weight: 500; margin-left: 2rem; transition: 0.3s; font-size: 15px; }
        .nav-links a:hover { color: var(--primary); }

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
            margin-left: 0 !important;
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

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Hero Section */
        .feature-hero {
            padding: 160px 0 100px;
            background: linear-gradient(135deg, #1e1b4b 0%, #4338ca 100%);
            color: white;
            position: relative;
            overflow: hidden;
        }
        .hero-pattern {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image: radial-gradient(circle at 20% 30%, rgba(255,255,255,0.05) 0%, transparent 20%);
            opacity: 0.5;
        }
        .breadcrumb { margin-bottom: 20px; font-size: 14px; opacity: 0.8; }
        .breadcrumb a { color: white; text-decoration: none; }
        .feature-hero h1 { font-size: 3.5rem; font-weight: 800; margin-bottom: 20px; line-height: 1.1; }
        .feature-hero p { font-size: 1.25rem; opacity: 0.9; max-width: 700px; font-weight: 300; }

        /* Content Section */
        .feature-body { padding: 80px 0; }
        .content-card {
            background: white;
            border-radius: 30px;
            padding: 50px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.03);
            margin-top: -80px;
            position: relative;
            z-index: 10;
        }
        .grid { display: grid; grid-template-columns: 1.5fr 1fr; gap: 60px; }
        
        .main-content h2 { font-size: 2rem; font-weight: 700; margin-bottom: 25px; color: var(--primary-dark); }
        .main-content p { font-size: 1.1rem; color: var(--text-muted); margin-bottom: 30px; line-height: 1.8; }

        .feature-list { list-style: none; }
        .feature-list li {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            background: var(--bg-light);
            padding: 15px 20px;
            border-radius: 15px;
            font-weight: 500;
            transition: 0.3s;
        }
        .feature-list li:hover { transform: translateX(10px); background: #eef2ff; color: var(--primary); }
        .feature-list li i { color: var(--primary); margin-right: 15px; font-size: 18px; }

        .side-card {
            background: linear-gradient(135deg, #f8fafc, #ffffff);
            border-radius: 20px;
            padding: 30px;
            border: 1px solid #e2e8f0;
        }
        .icon-box {
            width: 70px; height: 70px;
            background: var(--primary);
            color: white;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin-bottom: 25px;
            box-shadow: 0 10px 20px rgba(67, 56, 202, 0.2);
        }

        .cta-box {
            margin-top: 40px;
            padding: 40px;
            background: var(--primary-dark);
            border-radius: 20px;
            color: white;
            text-align: center;
        }
        .btn-action {
            display: inline-block;
            padding: 15px 40px;
            background: white;
            color: var(--primary-dark);
            text-decoration: none;
            border-radius: 50px;
            font-weight: 700;
            margin-top: 20px;
            transition: 0.3s;
        }
        .btn-action:hover { transform: scale(1.05); box-shadow: 0 10px 20px rgba(0,0,0,0.2); }

        footer { background: #1e1b4b; color: white; padding: 40px 0; text-align: center; font-size: 14px; margin-top: 50px; }

        @media (max-width: 968px) {
            .grid { grid-template-columns: 1fr; }
            .feature-hero h1 { font-size: 2.5rem; }
            .content-card { padding: 30px; }
        }
        
        /* Protection for Branding */
        .notranslate { font-family: 'Poppins', sans-serif !important; }
        .bmn-fixed::after { content: "BMN"; }
        .siber-fixed::after { content: "Siber"; }
        .core-fixed::after { content: "Core!"; color: #dc2626 !important; -webkit-text-fill-color: #dc2626 !important; font-style: italic !important; }
        .instansi-fixed::after { content: "UIN SIBER SYEKH NURJATI CIREBON"; }
    </style>
</head>
<body>

    <nav>
        <div class="container nav-content">
            <a href="{{ url('/') }}" class="logo">
                <img src="{{ asset('img/logo_uinssc.png') }}" alt="Logo">
                <span class="notranslate" translate="no" style="display: flex; flex-direction: column; line-height: 1.1;">
                    <span style="font-size: 1.2rem; font-weight: 800;"><span class="bmn-fixed"></span> <span class="core-fixed"></span></span>
                    <small class="instansi-fixed" style="font-size: 0.6rem; font-weight: 600; background: linear-gradient(135deg, #4338ca, #7C3AED); -webkit-background-clip: text; -webkit-text-fill-color: transparent; text-transform: uppercase;"></small>
                </span>
            </a>
            <div class="nav-links">
                <a href="{{ url('/') }}">Beranda</a>
                <div class="dropdown">
                    <a href="{{ url('/#tentang') }}">Tentang Kami <i class="fas fa-chevron-down"></i></a>
                    <div class="dropdown-content">
                        <a href="{{ url('/#tentang') }}">Tentang BMN Core!</a>
                        <a href="{{ url('/#alur-kerja') }}">Alur Kerja</a>
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
                <a href="{{ url('/#hubungi-kami') }}">Hubungi Kami</a>
                @auth
                    <a href="{{ route('dashboard') }}" style="background: var(--primary); color: white; padding: 10px 25px; border-radius: 50px;">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" style="color: #dc2626; border: 2px solid #dc2626; padding: 10px 25px; border-radius: 50px;">Masuk</a>
                    <a href="{{ route('register') }}" style="background: linear-gradient(135deg, #4338ca, #7C3AED); color: white; padding: 10px 25px; border-radius: 50px; border: none;">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <header class="feature-hero">
        <div class="hero-pattern"></div>
        <div class="container">
            <div class="breadcrumb" data-aos="fade-right">
                <a href="{{ url('/') }}">Beranda</a> <i class="fas fa-chevron-right" style="font-size: 10px; margin: 0 10px;"></i> <span>Fitur</span>
            </div>
            <h1 data-aos="fade-up">{{ $feature['title'] }}</h1>
            <p data-aos="fade-up" data-aos-delay="100">{{ $feature['description'] }}</p>
        </div>
    </header>

    <main class="feature-body">
        <div class="container">
            <div class="content-card" data-aos="fade-up" data-aos-delay="200">
                <div class="grid">
                    <div class="main-content">
                        <h2>Detail Modul</h2>
                        <p>{{ $feature['content'] }}</p>
                        
                        <h3 style="font-size: 1.3rem; margin-bottom: 20px; color: var(--primary-dark);">Fungsi Utama:</h3>
                        <ul class="feature-list">
                            @foreach($feature['details'] as $detail)
                                <li><i class="fas fa-check-circle"></i> {{ $detail }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="side-content">
                        <div class="side-card">
                            <div class="icon-box">
                                <i class="{{ $feature['icon'] }}"></i>
                            </div>
                            <h4 style="margin-bottom: 15px; font-weight: 700;">Keunggulan Modul</h4>
                            <p style="font-size: 0.95rem; color: var(--text-muted);">Dirancang dengan standar keamanan tinggi dan kemudahan penggunaan (User-Friendly) untuk mendukung operasional BMN yang tanpa hambatan.</p>
                        </div>
                        
                        <div class="cta-box">
                            <h4 style="margin-bottom: 10px;">Siap Mengelola Aset?</h4>
                            <p style="font-size: 0.9rem; opacity: 0.8;">Mulai transformasi digital manajemen aset Anda hari ini bersama BMN Core!.</p>
                            <a href="{{ route('register') }}" class="btn-action">Daftar Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2026 PUSTIKOM <span class="notranslate" translate="no">UIN Syekh Nurjati Cirebon</span>. Seluruh Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true });
    </script>
    <!-- AI Assistant Chat Bot Bubble -->
    <div id="ai-chat-bubble" onclick="toggleChat()" style="position: fixed; bottom: 20px; right: 20px; width: 50px; height: 50px; background: linear-gradient(135deg, #4338ca, #7C3AED); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 22px; cursor: pointer; box-shadow: 0 10px 30px rgba(67, 56, 202, 0.4); z-index: 9999; transition: 0.3s; border: 2px solid rgba(255,255,255,0.2);">
        <i class="fas fa-robot"></i>
        <div style="position: absolute; top: 0; right: 0; width: 12px; height: 12px; background: #10b981; border-radius: 50%; border: 2px solid white;"></div>
    </div>

    <!-- AI Chat Window -->
    <div id="ai-chat-window" style="position: fixed; bottom: 85px; right: 20px; width: 350px; height: 500px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(15px); border-radius: 20px; box-shadow: 0 20px 50px rgba(0,0,0,0.15); display: none; flex-direction: column; z-index: 9999; overflow: hidden; border: 1px solid rgba(255,255,255,0.5); animation: slideUp 0.4s ease;">
        <div style="background: linear-gradient(135deg, #1e1b4b, #4338ca); padding: 20px; color: white; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-robot" style="font-size: 20px;"></i>
                <h4 style="margin: 0; font-size: 1rem;">BMN Core! AI</h4>
            </div>
            <button onclick="toggleChat()" style="background: none; border: none; color: white; cursor: pointer;"><i class="fas fa-times"></i></button>
        </div>
        <div id="chat-messages" style="flex: 1; padding: 15px; overflow-y: auto; display: flex; flex-direction: column; gap: 10px; background: #f8fafc;">
            <div style="background: #eef2ff; padding: 10px 15px; border-radius: 15px 15px 15px 5px; align-self: flex-start; font-size: 0.85rem; color: #1e1b4b;">
                Halo! Ada yang bisa saya bantu tentang modul ini?
            </div>
        </div>
        <div style="padding: 15px; background: white; border-top: 1px solid #e2e8f0;">
            <div style="display: flex; gap: 8px; background: #f1f5f9; padding: 8px; border-radius: 10px;">
                <input type="text" id="user-input" placeholder="Tanya AI..." style="flex: 1; background: none; border: none; outline: none; font-size: 0.85rem;" onkeypress="if(event.key === 'Enter') sendMessage()">
                <button onclick="sendMessage()" style="background: #4338ca; color: white; border: none; width: 35px; height: 35px; border-radius: 8px; cursor: pointer;"><i class="fas fa-paper-plane"></i></button>
            </div>
        </div>
    </div>

    <style>
        @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    </style>

    <script>
        function toggleChat() {
            const win = document.getElementById('ai-chat-window');
            win.style.display = win.style.display === 'none' ? 'flex' : 'none';
        }
        function sendMessage() {
            const input = document.getElementById('user-input');
            const msg = input.value.trim();
            if(!msg) return;
            appendMessage('user', msg);
            input.value = '';
            setTimeout(() => {
                const query = msg.toLowerCase();
                let resp = "Saya adalah asisten AI BMN Core!. Anda bisa bertanya tentang Modul, Regulasi, atau Cara Penggunaan.";
                if(query.includes('modul') || query.includes('fitur')) resp = "Modul yang tersedia: Master Data, Aset Tetap, Persediaan, RKBMN, Wasdal, dan Laporan.";
                if(query.includes('regulasi')) resp = "Sistem ini patuh pada regulasi BMN terbaru dan standar integrasi SIMAN v2.";
                appendMessage('ai', resp);
            }, 700);
        }
        function appendMessage(sender, text) {
            const container = document.getElementById('chat-messages');
            const div = document.createElement('div');
            div.style.cssText = sender === 'user' 
                ? "background: #4338ca; color: white; padding: 10px 15px; border-radius: 15px 15px 5px 15px; align-self: flex-end; font-size: 0.85rem; max-width: 85%;"
                : "background: #eef2ff; color: #1e1b4b; padding: 10px 15px; border-radius: 15px 15px 15px 5px; align-self: flex-start; font-size: 0.85rem; max-width: 85%; border: 1px solid #e0e7ff;";
            div.innerHTML = text;
            container.appendChild(div);
            container.scrollTop = container.scrollHeight;
        }
    </script>
</body>
</html>
