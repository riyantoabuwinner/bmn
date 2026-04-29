<!-- AI Assistant Chat Bot Bubble -->
<div id="ai-chat-bubble" onclick="toggleChat()" style="position: fixed !important; bottom: 20px !important; right: 20px !important; width: 50px !important; height: 50px !important; background: #7c3aed !important; border-radius: 50% !important; display: flex !important; align-items: center !important; justify-content: center !important; color: white !important; font-size: 22px !important; cursor: pointer !important; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2) !important; z-index: 10000 !important; transition: 0.3s !important; border: 3px solid white !important;">
    <i class="fas fa-robot"></i>
    <div style="position: absolute; top: -2px; right: -2px; width: 12px; height: 12px; background: #10b981; border-radius: 50%; border: 2px solid white;"></div>
</div>

<!-- AI Chat Window -->
<div id="ai-chat-window" style="position: fixed !important; bottom: 85px !important; right: 20px !important; width: 380px !important; height: 550px !important; background: rgba(255, 255, 255, 0.95) !important; backdrop-filter: blur(15px) !important; border-radius: 25px !important; box-shadow: 0 20px 50px rgba(0,0,0,0.15) !important; display: none; flex-direction: column !important; z-index: 10001 !important; overflow: hidden !important; border: 1px solid rgba(255,255,255,0.5) !important; animation: slideUp 0.4s ease !important;">
    <!-- Chat Header -->
    <div style="background: linear-gradient(135deg, #1e1b4b, #4338ca); padding: 25px; color: white; display: flex; align-items: center; justify-content: space-between;">
        <div style="display: flex; align-items: center; gap: 15px;">
            <div style="width: 45px; height: 45px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-robot" style="font-size: 24px;"></i>
            </div>
            <div>
                <h4 style="margin: 0; font-weight: 700; font-size: 16px;">BMN Core! Assistant</h4>
                <div style="display: flex; align-items: center; gap: 5px; font-size: 12px; opacity: 0.8;">
                    <span style="width: 8px; height: 8px; background: #10b981; border-radius: 50%;"></span> Online
                </div>
            </div>
        </div>
        <button onclick="toggleChat()" style="background: none; border: none; color: white; cursor: pointer; font-size: 20px; opacity: 0.7; transition: 0.3s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.7">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- Chat Messages -->
    <div id="chat-messages" style="flex: 1; padding: 20px; overflow-y: auto; display: flex; flex-direction: column; gap: 15px; background: #f8fafc;">
        <div style="background: white; padding: 15px; border-radius: 18px 18px 18px 5px; max-width: 85%; align-self: flex-start; box-shadow: 0 2px 10px rgba(0,0,0,0.03); color: #1e1b4b; font-size: 14px; line-height: 1.5;">
            Halo! Saya asisten AI BMN Core!. Ada yang bisa saya bantu terkait pengelolaan Barang Milik Negara?
        </div>
    </div>

    <!-- Chat Input -->
    <div style="padding: 20px; background: white; border-top: 1px solid #e2e8f0;">
        <div style="display: flex; gap: 10px; background: #f1f5f9; padding: 5px; border-radius: 15px;">
            <input type="text" id="chat-input" placeholder="Tanyakan sesuatu..." style="flex: 1; background: none; border: none; padding: 12px 15px; outline: none; font-size: 14px;">
            <button onclick="sendMessage()" style="background: #4338ca; color: white; border: none; width: 45px; height: 45px; border-radius: 12px; cursor: pointer; transition: 0.3s; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>

<style>
    @keyframes slideUp {
        from { transform: translateY(30px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
</style>

<script>
    function toggleChat() {
        const window = document.getElementById('ai-chat-window');
        const bubble = document.getElementById('ai-chat-bubble');
        if (window.style.display === 'none' || window.style.display === '') {
            window.style.display = 'flex';
            bubble.style.transform = 'scale(0.8) rotate(90deg)';
        } else {
            window.style.display = 'none';
            bubble.style.transform = 'scale(1) rotate(0deg)';
        }
    }

    function sendMessage() {
        const input = document.getElementById('chat-input');
        const messagesContainer = document.getElementById('chat-messages');
        const text = input.value.trim();

        if (text === '') return;

        // User message
        const userDiv = document.createElement('div');
        userDiv.style.cssText = 'background: #4338ca; color: white; padding: 15px; border-radius: 18px 18px 5px 18px; max-width: 85%; align-self: flex-end; box-shadow: 0 5px 15px rgba(67, 56, 202, 0.2); font-size: 14px; line-height: 1.5;';
        userDiv.textContent = text;
        messagesContainer.appendChild(userDiv);

        input.value = '';
        messagesContainer.scrollTop = messagesContainer.scrollHeight;

        // Bot typing
        setTimeout(() => {
            const response = getAIResponse(text);
            const botDiv = document.createElement('div');
            botDiv.style.cssText = 'background: white; padding: 15px; border-radius: 18px 18px 18px 5px; max-width: 85%; align-self: flex-start; box-shadow: 0 2px 10px rgba(0,0,0,0.03); color: #1e1b4b; font-size: 14px; line-height: 1.5;';
            botDiv.innerHTML = response;
            messagesContainer.appendChild(botDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }, 1000);
    }

    function getAIResponse(query) {
        const q = query.toLowerCase();
        
        // Knowledge Base
        const kb = [
            { key: ['hi', 'halo', 'siapa', 'tanya'], resp: 'Halo! Saya asisten AI BMN Core!. Saya bisa membantu menjelaskan fitur Master Data, RKBMN, Manajemen Aset, dan regulasi BMN lainnya.' },
            { key: ['master', 'organisasi'], resp: '<b>Modul Master Data</b> mencakup pengelolaan struktur organisasi, data pegawai, dan daftar unit kerja yang terintegrasi untuk mendukung akuntabilitas data.' },
            { key: ['rkbmn', 'perencanaan'], resp: '<b>Modul RKBMN</b> (Rencana Kebutuhan BMN) digunakan untuk menyusun usulan pengadaan dan pemeliharaan barang sesuai siklus anggaran tahunan.' },
            { key: ['aset', 'tetap', 'tanah', 'bangunan'], resp: '<b>Manajemen Aset Tetap</b> meliputi pencatatan (KIB), mutasi, hingga penghapusan aset seperti tanah, gedung, dan peralatan mesin.' },
            { key: ['persediaan', 'lancar'], resp: '<b>Modul Persediaan</b> menangani barang habis pakai seperti ATK dan material pendukung lainnya dengan metode pencatatan yang akurat.' },
            { key: ['wasdal', 'pengawasan'], resp: '<b>Modul Wasdal</b> (Pengawasan dan Pengendalian) memastikan penggunaan BMN sesuai peruntukan dan memonitor masa berlaku dokumen legalitas.' },
            { key: ['regulasi', 'aturan', 'uu'], resp: 'Aplikasi ini mengacu pada <b>PP No. 27 Tahun 2014</b> dan <b>PMK No. 181/PMK.06/2016</b> tentang Penatausahaan BMN.' }
        ];

        for (let item of kb) {
            if (item.key.some(k => q.includes(k))) return item.resp;
        }

        return "Maaf, saya belum memahami pertanyaan tersebut secara spesifik. Silakan hubungi admin di menu 'Hubungi Kami' untuk bantuan lebih lanjut.";
    }

    document.getElementById('chat-input').addEventListener('keypress', function (e) {
        if (e.key === 'Enter') sendMessage();
    });
</script>
