<div x-data="accessibilityWidget()" x-init="init()" class="relative">
    <!-- Floating Button -->
    <button @click="toggleMenu()" class="acc-widget-btn" title="Aksesibilitas">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-accessibility"><circle cx="16" cy="4" r="1"/><path d="m18 19 1-7-6 1"/><path d="m5 8 3-3 5.5 3-2.36 3.5"/><path d="M4.24 14.5a5 5 0 0 0 6.88 6"/><path d="M13.76 17.5a5 5 0 0 0-6.88-6"/></svg>
        <span x-show="Object.values(settings).some(v => v !== false && v !== 0)" class="absolute top-0 right-0 block h-3 w-3 rounded-full bg-red-500 border-2 border-white"></span>
    </button>

    <!-- Menu -->
    <div x-show="isOpen" @click.away="isOpen = false" x-transition class="acc-menu" :class="{ 'show': isOpen }">
        <div class="acc-header">
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="16" cy="4" r="1"/><path d="m18 19 1-7-6 1"/><path d="m5 8 3-3 5.5 3-2.36 3.5"/><path d="M4.24 14.5a5 5 0 0 0 6.88 6"/><path d="M13.76 17.5a5 5 0 0 0-6.88-6"/></svg>
                <span>Aksesibilitas</span>
            </div>
            <button @click="isOpen = false" class="text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>

        <div class="acc-grid">
            <!-- Perbesar Teks -->
            <div @click="toggleOption('textSize')" class="acc-item" :class="{ 'active': settings.textSize > 0 }">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 15 4-8 4 8"/><path d="M4 13h6"/><circle cx="18" cy="12" r="3"/><path d="M21 9v6"/></svg>
                <span>Perbesar Teks</span>
            </div>

            <!-- Grayscale -->
            <div @click="toggleOption('grayscale')" class="acc-item" :class="{ 'active': settings.grayscale }">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8Z"/><path d="M12 4a8 8 0 0 0 0 16z"/></svg>
                <span>Grayscale</span>
            </div>

            <!-- Kontras Tinggi -->
            <div @click="toggleOption('highContrast')" class="acc-item" :class="{ 'active': settings.highContrast }">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="13.5" cy="6.5" r=".5"/><circle cx="17.5" cy="10.5" r=".5"/><circle cx="8.5" cy="7.5" r=".5"/><circle cx="6.5" cy="12.5" r=".5"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.92 0 1.5-.58 1.5-1.5 0-.43-.17-.83-.44-1.14-.27-.31-.44-.72-.44-1.18 0-.92.78-1.5 1.7-1.5h2.18c2.76 0 5-2.24 5-5 0-5.22-4.22-9.22-9.5-9.22z"/></svg>
                <span>Kontras Tinggi</span>
            </div>

            <!-- Garis Link -->
            <div @click="toggleOption('underlineLinks')" class="acc-item" :class="{ 'active': settings.underlineLinks }">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                <span>Garis Link</span>
            </div>

            <!-- Font Standar -->
            <div @click="toggleOption('standardFont')" class="acc-item" :class="{ 'active': settings.standardFont }">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="15" y2="18"/></svg>
                <span>Font Standar</span>
            </div>

            <!-- Kursor Besar -->
            <div @click="toggleOption('bigCursor')" class="acc-item" :class="{ 'active': settings.bigCursor }">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 3 7.07 16.97 2.51-7.39 7.39-2.51L3 3z"/><path d="m13 13 6 6"/></svg>
                <span>Kursor Besar</span>
            </div>

            <!-- Spasi Baris -->
            <div @click="toggleOption('lineSpacing')" class="acc-item" :class="{ 'active': settings.lineSpacing }">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 8 4-4 4 4"/><path d="m3 16 4 4 4-4"/><path d="M17 6h4"/><path d="M17 12h4"/><path d="M17 18h4"/><path d="M7 4v16"/></svg>
                <span>Spasi Baris</span>
            </div>

            <!-- Hapus Animasi -->
            <div @click="toggleOption('noAnimations')" class="acc-item" :class="{ 'active': settings.noAnimations }">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                <span>Hapus Animasi</span>
            </div>

            <!-- Dengarkan Teks -->
            <div @click="toggleOption('textToSpeech')" class="acc-item" :class="{ 'active': settings.textToSpeech }">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 18v-6a9 9 0 0 1 18 0v6"/><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"/></svg>
                <span>Dengarkan Teks</span>
            </div>

            <!-- Mode Gelap -->
            <div @click="toggleDarkMode()" class="acc-item" :class="{ 'active': isDarkMode }">
                <svg x-show="!isDarkMode" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/></svg>
                <svg x-show="isDarkMode" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M22 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/></svg>
                <span x-text="isDarkMode ? 'Mode Terang' : 'Mode Gelap'"></span>
            </div>

            <!-- Fullscreen -->
            <div @click="toggleFullscreen()" class="acc-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3H5a2 2 0 0 0-2 2v3"/><path d="M21 8V5a2 2 0 0 0-2-2h-3"/><path d="M3 16v3a2 2 0 0 0 2 2h3"/><path d="M16 21h3a2 2 0 0 0 2-2v-3"/></svg>
                <span>Layar Penuh</span>
            </div>

            <!-- Google Translate Dropdown -->
            <div class="acc-item acc-lang-item">
                <div class="flex flex-col items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m5 8 6 6"/><path d="m4 14 6-6 2-3"/><path d="M2 5h12"/><path d="M7 2h1"/><path d="m22 22-5-10-5 10"/><path d="M14 18h6"/></svg>
                    <span>Bahasa</span>
                </div>
                <div class="acc-lang-grid">
                    <button @click="changeLanguage('id')" class="lang-btn" :class="{ 'active': currentLang === 'id' }">ID</button>
                    <button @click="changeLanguage('en')" class="lang-btn" :class="{ 'active': currentLang === 'en' }">EN</button>
                    <button @click="changeLanguage('ar')" class="lang-btn" :class="{ 'active': currentLang === 'ar' }">AR</button>
                </div>
            </div>

            <!-- Atur Ulang -->
            <div @click="resetSettings()" class="acc-item acc-reset">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
                <span>Atur Ulang</span>
            </div>
        </div>
    </div>
    <div id="google_translate_element" style="position: absolute; top: -9999px; left: -9999px; visibility: hidden;"></div>
</div>

<script>
function accessibilityWidget() {
    if (window.accessibilityWidgetInstance) return window.accessibilityWidgetInstance;

    const widget = {
        isOpen: false,
        isDarkMode: false,
        currentLang: 'id',
        settings: {
            textSize: 0,
            grayscale: false,
            highContrast: false,
            underlineLinks: false,
            standardFont: false,
            bigCursor: false,
            lineSpacing: false,
            noAnimations: false,
            textToSpeech: false,
        },
        utterance: null,

        init() {
            // Already set in factory
            // Dark Mode Init
            this.isDarkMode = localStorage.getItem('dark_mode') === 'true';
            this.applyDarkMode();

            // Language Init
            this.currentLang = localStorage.getItem('goog_lang') || 'id';
            this.loadGoogleTranslate();

            // Load settings from localStorage first (for speed)
            const saved = localStorage.getItem('accessibility_settings');
            if (saved) {
                this.settings = JSON.parse(saved);
                this.applyAll();
            }

            // If logged in, load from backend
            @auth
                const backendSettings = @json(auth()->user()->accessibility_settings);
                if (backendSettings) {
                    this.settings = backendSettings;
                    this.applyAll();
                    localStorage.setItem('accessibility_settings', JSON.stringify(this.settings));
                }
            @endauth

            this.setupTextToSpeech();
            this.ensureTranslatable();
            this.updateNavFlag();
        },

        updateNavFlag() {
            const lang = this.currentLang;
            const navFlag = document.getElementById('current-nav-flag');
            if (navFlag) {
                const map = { 'id': 'id', 'en': 'gb', 'ar': 'sa' };
                navFlag.src = `https://flagcdn.com/w20/${map[lang] || 'id'}.png`;
            }
        },

        ensureTranslatable() {
            // Remove 'notranslate' from elements that should be translated
            document.querySelectorAll('.notranslate').forEach(el => {
                // Keep it for icons or elements that specifically shouldn't be translated
                if (!el.classList.contains('fa') && !el.classList.contains('fas') && !el.classList.contains('fab')) {
                    el.classList.remove('notranslate');
                }
            });
            document.querySelectorAll('[translate="no"]').forEach(el => {
                el.removeAttribute('translate');
            });
        },

        toggleDarkMode() {
            this.isDarkMode = !this.isDarkMode;
            localStorage.setItem('dark_mode', this.isDarkMode);
            this.applyDarkMode();
        },

        applyDarkMode() {
            if (this.isDarkMode) {
                document.documentElement.classList.add('dark');
                document.body.classList.add('dark-mode'); // For AdminLTE
            } else {
                document.documentElement.classList.remove('dark');
                document.body.classList.remove('dark-mode');
            }
        },

        toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
            }
        },

        loadGoogleTranslate() {
            if (!window.googleTranslateElementInit) {
                window.googleTranslateElementInit = () => {
                    new google.translate.TranslateElement({
                        pageLanguage: 'id',
                        includedLanguages: 'id,en,ar',
                        multilanguagePage: true,
                    }, 'google_translate_element');
                };
                const script = document.createElement('script');
                script.src = '//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
                document.head.appendChild(script);
            }
        },

        changeLanguage(lang) {
            this.currentLang = lang;
            localStorage.setItem('goog_lang', lang);
            
            // Try multiple ways to find the combo
            let combo = document.querySelector('.goog-te-combo');
            
            if (combo) {
                combo.value = lang;
                combo.dispatchEvent(new Event('change'));
                
                // Update AdminLTE nav flag
                const navFlag = document.getElementById('current-nav-flag');
                if (navFlag) {
                    const map = { 'id': 'id', 'en': 'gb', 'ar': 'sa' };
                    navFlag.src = `https://flagcdn.com/w20/${map[lang] || 'id'}.png`;
                }

                // If it's ID, we might need to "reset" the translation
                if (lang === 'id') {
                    const restoreBtn = document.querySelector('.goog-te-banner-frame button');
                    if (restoreBtn) restoreBtn.click();
                }
            } else {
                // If script not ready, retry for up to 5 seconds
                if (!window.retryCount) window.retryCount = 0;
                if (window.retryCount < 10) {
                    window.retryCount++;
                    setTimeout(() => this.changeLanguage(lang), 500);
                } else {
                    console.error('Google Translate combo not found after retries');
                    window.retryCount = 0;
                }
            }
        },

        toggleMenu() {
            this.isOpen = !this.isOpen;
        },

        toggleOption(option) {
            if (option === 'textSize') {
                this.settings.textSize = (this.settings.textSize + 1) % 3;
            } else {
                this.settings[option] = !this.settings[option];
            }
            
            this.applyAll();
            this.saveSettings();

            if (option === 'textToSpeech' && !this.settings.textToSpeech) {
                window.speechSynthesis.cancel();
            }
        },

        applyAll() {
            const body = document.body;
            const html = document.documentElement;
            
            // Text Size (on HTML for REM scaling)
            html.classList.remove('acc-text-lg', 'acc-text-xl');
            if (this.settings.textSize === 1) html.classList.add('acc-text-lg');
            if (this.settings.textSize === 2) html.classList.add('acc-text-xl');

            // Toggle Classes (on Body)
            const toggles = [
                'grayscale', 'highContrast', 'underlineLinks', 
                'standardFont', 'bigCursor', 'lineSpacing', 'noAnimations'
            ];
            
            toggles.forEach(opt => {
                const className = 'acc-' + opt.replace(/[A-Z]/g, m => "-" + m.toLowerCase());
                if (this.settings[opt]) {
                    body.classList.add(className);
                } else {
                    body.classList.remove(className);
                }
            });
        },

        resetSettings() {
            this.settings = {
                textSize: 0,
                grayscale: false,
                highContrast: false,
                underlineLinks: false,
                standardFont: false,
                bigCursor: false,
                lineSpacing: false,
                noAnimations: false,
                textToSpeech: false,
            };
            this.applyAll();
            this.saveSettings();
            window.speechSynthesis.cancel();
        },

        saveSettings() {
            const settingsJson = JSON.stringify(this.settings);
            localStorage.setItem('accessibility_settings', settingsJson);

            @auth
            fetch('{{ route("profile.accessibility") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ settings: this.settings })
            });
            @endauth
        },

        setupTextToSpeech() {
            document.addEventListener('click', (e) => {
                if (this.settings.textToSpeech) {
                    const target = e.target.closest('a, button, h1, h2, h3, p, span, label');
                    if (target && !target.closest('.acc-menu') && !target.closest('.acc-widget-btn')) {
                        const text = target.innerText || target.getAttribute('alt') || target.getAttribute('title');
                        if (text && text.trim().length > 0) {
                            this.speak(text);
                        }
                    }
                }
            }, true);
        },

        speak(text) {
            window.speechSynthesis.cancel();
            const utterance = new SpeechSynthesisUtterance(text);
            
            // Map currentLang to BCP 47 language tags
            const langMap = {
                'id': 'id-ID',
                'en': 'en-GB',
                'ar': 'ar-SA'
            };
            
            utterance.lang = langMap[this.currentLang] || 'id-ID';
            
            // Optional: fine-tune pitch and rate for better experience
            utterance.pitch = 1;
            utterance.rate = 1;
            
            window.speechSynthesis.speak(utterance);
        }
    };

    window.accessibilityWidgetInstance = widget;
    return widget;
}
</script>
