<?php

return [

    /*
     |--------------------------------------------------------------------------
     | Title
     |--------------------------------------------------------------------------
     |
     | Here you can change the default title of your admin panel.
     |
     | For detailed instructions you can look the title section here:
     | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
     |
     */

    'title' => 'BMN System',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
     |--------------------------------------------------------------------------
     | Favicon
     |--------------------------------------------------------------------------
     |
     | Here you can activate the favicon.
     |
     | For detailed instructions you can look the favicon section here:
     | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
     |
     */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
     |--------------------------------------------------------------------------
     | Google Fonts
     |--------------------------------------------------------------------------
     |
     | Here you can allow or not the use of external google fonts. Disabling the
     | google fonts may be useful if your admin panel internet access is
     | restricted somehow.
     |
     | For detailed instructions you can look the google fonts section here:
     | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
     |
     */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
     |--------------------------------------------------------------------------
     | Admin Panel Logo
     |--------------------------------------------------------------------------
     |
     | Here you can change the logo of your admin panel.
     |
     | For detailed instructions you can look the logo section here:
     | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
     |
     */

    'logo' => '<b>BMN</b> System',
    'logo_img' => 'img/logo_uinssc.png',
    'logo_img_class' => 'brand-image elevation-3',
    'logo_img_xl' => false,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'BMN Logo',

    /*
     |--------------------------------------------------------------------------
     | Authentication Logo
     |--------------------------------------------------------------------------
     |
     | Here you can setup an alternative logo to use on your login and register
     | screens. When disabled, the admin panel logo will be used instead.
     |
     | For detailed instructions you can look the auth logo section here:
     | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
     |
     */

    'auth_logo' => [
        'enabled' => true,
        'img' => [
            'path' => 'img/logo_uinssc.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 80,
            'height' => 80,
        ],
    ],

    /*
     |--------------------------------------------------------------------------
     | Preloader Animation
     |--------------------------------------------------------------------------
     |
     | Here you can change the preloader animation configuration. Currently, two
     | modes are supported: 'fullscreen' for a fullscreen preloader animation
     | and 'cwrapper' to attach the preloader animation into the content-wrapper
     | element and avoid overlapping it with the sidebars and the top navbar.
     |
     | For detailed instructions you can look the preloader section here:
     | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
     |
     */

    'preloader' => [
        'enabled' => true,
        'mode' => 'fullscreen',
        'img' => [
            'path' => 'img/logo_uinssc.png',
            'alt' => 'BMN System Preloader',
            'effect' => 'animation__shake',
            'width' => 100,
            'height' => 100,
        ],
    ],

    /*
     |--------------------------------------------------------------------------
     | User Menu
     |--------------------------------------------------------------------------
     |
     | Here you can activate and change the user menu.
     |
     | For detailed instructions you can look the user menu section here:
     | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
     |
     */

    'usermenu_enabled' => true,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => true,
    'usermenu_desc' => true,
    'usermenu_profile_url' => true,

    /*
     |--------------------------------------------------------------------------
     | Layout
     |--------------------------------------------------------------------------
     |
     | Here we change the layout of your admin panel.
     |
     | For detailed instructions you can look the layout section here:
     | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
     |
     */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
     |--------------------------------------------------------------------------
     | Authentication Views Classes
     |--------------------------------------------------------------------------
     |
     | Here you can change the look and behavior of the authentication views.
     |
     | For detailed instructions you can look the auth classes section here:
     | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
     |
     */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
     |--------------------------------------------------------------------------
     | Admin Panel Classes
     |--------------------------------------------------------------------------
     |
     | Here you can change the look and behavior of the admin panel.
     |
     | For detailed instructions you can look the admin panel classes here:
     | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
     |
     */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
     |--------------------------------------------------------------------------
     | Sidebar
     |--------------------------------------------------------------------------
     |
     | Here we can modify the sidebar of the admin panel.
     |
     | For detailed instructions you can look the sidebar section here:
     | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
     |
     */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
     |--------------------------------------------------------------------------
     | Control Sidebar (Right Sidebar)
     |--------------------------------------------------------------------------
     |
     | Here we can modify the right sidebar aka control sidebar of the admin panel.
     |
     | For detailed instructions you can look the right sidebar section here:
     | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
     |
     */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
     |--------------------------------------------------------------------------
     | URLs
     |--------------------------------------------------------------------------
     |
     | Here we can modify the url settings of the admin panel.
     |
     | For detailed instructions you can look the urls section here:
     | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
     |
     */

    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,
    'disable_darkmode_routes' => false,

    /*
     |--------------------------------------------------------------------------
     | Laravel Asset Bundling
     |--------------------------------------------------------------------------
     |
     | Here we can enable the Laravel Asset Bundling option for the admin panel.
     | Currently, the next modes are supported: 'mix', 'vite' and 'vite_js_only'.
     | When using 'vite_js_only', it's expected that your CSS is imported using
     | JavaScript. Typically, in your application's 'resources/js/app.js' file.
     | If you are not using any of these, leave it as 'false'.
     |
     | For detailed instructions you can look the asset bundling section here:
     | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
     |
     */

    'laravel_asset_bundling' => false,
    'laravel_css_path' => 'css/app.css',
    'laravel_js_path' => 'js/app.js',

    /*
     |--------------------------------------------------------------------------
     | Menu Items
     |--------------------------------------------------------------------------
     |
     | Here we can modify the sidebar/top navigation of the admin panel.
     |
     | For detailed instructions you can look here:
     | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
     |
     */

    'menu' => [
        // Navbar items:
        [
            'type' => 'navbar-search',
            'text' => 'search',
            'topnav_right' => true,
        ],
        [
            'type' => 'fullscreen-widget',
            'topnav_right' => true,
        ],
        [
            'type' => 'darkmode-widget',
            'topnav_right' => true,
        ],

        // Sidebar items:
        [
            'text' => 'Dashboard',
            'url' => 'dashboard',
            'icon' => 'fas fa-fw fa-tachometer-alt',
        ],

        ['header' => 'MASTER DATA', 'role' => ['superadmin', 'admin', 'admin_rektorat', 'operator_fakultas', 'staff'], 'classes' => 'nav-header-master'],
        [
            'text' => 'Master Data',
            'icon' => 'fas fa-fw fa-database',
            'role' => ['superadmin', 'admin', 'admin_rektorat', 'operator_fakultas', 'staff'],
            'submenu' => [
                [
                    'text' => 'Satuan Kerja (Units)',
                    'url' => 'units',
                    'icon' => 'fas fa-fw fa-building',
                ],
                [
                    'text' => 'Jenis Aset Tetap',
                    'url' => 'categories',
                    'icon' => 'fas fa-fw fa-tags',
                ],
                [
                    'text' => 'Jenis Aset Lancar/ Persediaan',
                    'url' => 'current-asset-categories',
                    'icon' => 'fas fa-fw fa-list-ul',
                ],
                [
                    'text' => 'Lokasi Ruang',
                    'url' => 'locations',
                    'icon' => 'fas fa-fw fa-map-marker-alt',
                ],
            ],
        ],

        ['header' => 'INVENTARISASI (MASTER ASET)', 'role' => ['superadmin', 'admin', 'admin_rektorat', 'operator_fakultas', 'staff'], 'classes' => 'nav-header-inventarisasi'],
        [
            'text' => 'Aset Tetap',
            'icon' => 'fas fa-fw fa-box',
            'role' => ['superadmin', 'admin', 'admin_rektorat', 'operator_fakultas', 'staff'],
            'submenu' => [
                [
                    'text' => 'Daftar Aset',
                    'url' => 'assets',
                    'icon' => 'fas fa-fw fa-list',
                ],
            ],
        ],
        [
            'text' => 'Aset Lancar/ Persediaan',
            'url' => 'current-assets',
            'icon' => 'fas fa-fw fa-boxes',
            'active' => ['current-assets*'],
            'role' => ['superadmin', 'admin', 'admin_rektorat', 'operator_fakultas', 'staff'],
        ],
        [
            'text' => 'Scan QR / Cek Aset',
            'url' => 'scan-aset',
            'icon' => 'fas fa-fw fa-qrcode',
            'role' => ['superadmin', 'admin', 'admin_rektorat', 'operator_fakultas', 'staff', 'user', 'stakeholder', 'umum'],
        ],

        ['header' => 'PERENCANAAN (RKBMN)', 'role' => ['superadmin', 'admin', 'admin_rektorat'], 'classes' => 'nav-header-rkbmn'],
        [
            'text' => 'Usulan Pengadaan',
            'url' => 'rkbmn/procurements',
            'icon' => 'fas fa-fw fa-shopping-cart',
            'role' => ['superadmin', 'admin', 'admin_rektorat'],
        ],
        [
            'text' => 'Usulan Pemeliharaan',
            'url' => 'rkbmn/maintenances',
            'icon' => 'fas fa-fw fa-tools',
            'role' => ['superadmin', 'admin', 'admin_rektorat'],
        ],
        [
            'text' => 'Usulan Pemanfaatan',
            'url' => 'rkbmn/actions',
            'icon' => 'fas fa-fw fa-chart-line',
            'role' => ['superadmin', 'admin', 'admin_rektorat'],
        ],
        [
            'text' => 'Usulan Penghapusan',
            'url' => 'rkbmn/deletions',
            'icon' => 'fas fa-fw fa-trash-alt',
            'role' => ['superadmin', 'admin', 'admin_rektorat'],
        ],

        ['header' => 'PENGELOLAAN ASET TETAP', 'role' => ['superadmin', 'admin', 'admin_rektorat', 'operator_fakultas', 'staff'], 'classes' => 'nav-header-transaksi'],
        [
            'text' => 'Penetapan Status (PSP)',
            'url' => 'psp',
            'icon' => 'fas fa-fw fa-file-contract',
            'role' => ['superadmin', 'admin', 'admin_rektorat', 'operator_fakultas'],
        ],
        [
            'text' => 'Pemanfaatan Aset',
            'url' => 'utilizations',
            'icon' => 'fas fa-fw fa-handshake',
            'role' => ['superadmin', 'admin', 'admin_rektorat', 'operator_fakultas'],
        ],
        [
            'text' => 'Distribusi Aset',
            'url' => 'distributions',
            'icon' => 'fas fa-fw fa-truck',
            'active' => ['distributions*'],
            'role' => ['superadmin', 'admin', 'admin_rektorat', 'operator_fakultas', 'staff'],
        ],
        [
            'text' => 'Pemegang Aset (BAST)',
            'url' => 'assignments',
            'icon' => 'fas fa-fw fa-user-tag',
            'active' => ['assignments*'],
            'role' => ['superadmin', 'admin', 'admin_rektorat', 'operator_fakultas', 'staff'],
        ],
        [
            'text' => 'Peminjaman Aset',
            'url' => 'borrowings',
            'icon' => 'fas fa-fw fa-hand-holding',
            'active' => ['borrowings*'],
            'role' => ['superadmin', 'admin', 'admin_rektorat', 'operator_fakultas', 'staff'],
        ],
        [
            'text' => 'Maintenance Aset',
            'url' => 'maintenances',
            'icon' => 'fas fa-fw fa-wrench',
            'active' => ['maintenances*'],
            'role' => ['superadmin', 'admin', 'admin_rektorat', 'operator_fakultas', 'staff'],
        ],
        [
            'text' => 'Evaluasi Aset Berkala',
            'url' => 'evaluations',
            'icon' => 'fas fa-fw fa-clipboard-check',
            'active' => ['evaluations*'],
            'role' => ['superadmin', 'admin', 'admin_rektorat'],
        ],
        [
            'text' => 'Pemindahtanganan',
            'url' => 'transfers',
            'icon' => 'fas fa-fw fa-exchange-alt',
            'role' => ['superadmin', 'admin', 'admin_rektorat', 'operator_fakultas'],
        ],
        [
            'text' => 'Penghapusan Aset',
            'url' => 'deletions',
            'icon' => 'fas fa-fw fa-trash',
            'role' => ['superadmin', 'admin', 'admin_rektorat', 'operator_fakultas'],
        ],

        ['header' => 'PENGELOLAAN ASET LANCAR', 'role' => ['superadmin', 'admin', 'admin_rektorat', 'operator_fakultas', 'staff'], 'classes' => 'nav-header-persediaan'],
        [
            'text' => 'Transaksi Persediaan',
            'url' => 'current-asset-transactions',
            'icon' => 'fas fa-fw fa-dolly-flatbed',
            'role' => ['superadmin', 'admin', 'admin_rektorat', 'operator_fakultas', 'staff'],
            'active' => ['current-asset-transactions*'],
        ],


        ['header' => 'PENGAWASAN (WASDAL)', 'role' => ['superadmin', 'admin', 'admin_rektorat'], 'classes' => 'nav-header-wasdal'],
        [
            'text' => 'Pelaporan Wasdal',
            'url' => 'wasdal-reports',
            'icon' => 'fas fa-fw fa-clipboard-list',
            'role' => ['superadmin', 'admin', 'admin_rektorat'],
        ],
        [
            'text' => 'Monitoring & Idle',
            'url' => 'wasdal-monitorings',
            'icon' => 'fas fa-fw fa-search-location',
            'role' => ['superadmin', 'admin', 'admin_rektorat'],
        ],


        ['header' => 'ASURANSI BMN', 'role' => ['superadmin', 'admin', 'admin_rektorat', 'operator_fakultas', 'staff'], 'classes' => 'nav-header-asuransi'],
        [
            'text' => 'Asuransi BMN',
            'url' => 'insurances',
            'icon' => 'fas fa-fw fa-shield-alt',
            'role' => ['superadmin', 'admin', 'admin_rektorat', 'operator_fakultas', 'staff'],
        ],

        ['header' => 'PORTOFOLIO ASET', 'role' => ['superadmin', 'admin', 'admin_rektorat'], 'classes' => 'nav-header-portofolio'],
        [
            'text' => 'Evaluasi Kinerja (SBSK)',
            'url' => 'performances',
            'icon' => 'fas fa-fw fa-chart-line',
            'role' => ['superadmin', 'admin', 'admin_rektorat'],
        ],


        ['header' => 'PENGATURAN', 'role' => ['superadmin', 'admin'], 'classes' => 'nav-header-pengaturan'],
        [
            'text' => 'Manajemen User',
            'url' => 'users',
            'icon' => 'fas fa-fw fa-users',
            'role' => ['superadmin', 'admin'],
        ],
        [
            'text' => 'Permohonan Role',
            'url' => 'role-requests',
            'icon' => 'fas fa-fw fa-user-tag',
            'role' => ['superadmin', 'admin'],
            'label' => 'Baru',
            'label_color' => 'success',
        ],
        [
            'text' => 'Profile',
            'url' => 'profile',
            'icon' => 'fas fa-fw fa-user',
        ],
        [
            'text' => 'Update Sistem',
            'route' => 'system.update.index',
            'icon' => 'fas fa-fw fa-sync-alt',
            'role' => ['superadmin'],
        ],
        [
            'text' => 'Log Aktivitas',
            'url' => 'logs',
            'icon' => 'fas fa-fw fa-history',
            'role' => ['superadmin', 'admin', 'admin_rektorat', 'operator_fakultas'],
        ],
    ],

    /*
     |--------------------------------------------------------------------------
     | Menu Filters
     |--------------------------------------------------------------------------
     |
     | Here we can modify the menu filters of the admin panel.
     |
     | For detailed instructions you can look the menu filters section here:
     | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
     |
     */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class ,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class ,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class ,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class ,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class ,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class ,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class ,
        App\Menu\Filters\RoleFilter::class ,
    ],

    /*
     |--------------------------------------------------------------------------
     | Plugins Initialization
     |--------------------------------------------------------------------------
     |
     | Here we can modify the plugins used inside the admin panel.
     |
     | For detailed instructions you can look the plugins section here:
     | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
     |
     */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
        'CustomCSS' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'css/custom_admin.css',
                ],
            ],
        ],
    ],

    /*
     |--------------------------------------------------------------------------
     | IFrame
     |--------------------------------------------------------------------------
     |
     | Here we change the IFrame mode configuration. Note these changes will
     | only apply to the view that extends and enable the IFrame mode.
     |
     | For detailed instructions you can look the iframe mode section here:
     | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
     |
     */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
     |--------------------------------------------------------------------------
     | Livewire
     |--------------------------------------------------------------------------
     |
     | Here we can enable the Livewire support.
     |
     | For detailed instructions you can look the livewire here:
     | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
     |
     */

    'livewire' => false,
];
