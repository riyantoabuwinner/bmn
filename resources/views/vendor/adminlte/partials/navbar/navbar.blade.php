@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

<nav class="main-header navbar
    {{ config('adminlte.classes_topnav_nav', 'navbar-expand') }}
    {{ config('adminlte.classes_topnav', 'navbar-white navbar-light') }}">

    {{-- Navbar left links --}}
    <ul class="navbar-nav">
        {{-- Left sidebar toggler link --}}
        @include('adminlte::partials.navbar.menu-item-left-sidebar-toggler')

        {{-- Configured left links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-left'), 'item')

        {{-- Custom left links --}}
        @yield('content_top_nav_left')
    </ul>

    {{-- Navbar right links --}}
    <ul class="navbar-nav ml-auto">
        {{-- Custom right links --}}
        @yield('content_top_nav_right')

        {{-- Configured right links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-right'), 'item')

        {{-- Google Translate Navbar Item --}}
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                <img id="current-nav-flag" src="https://flagcdn.com/w20/id.png" style="width: 20px; border-radius: 2px; margin-top: 5px;">
            </a>
            <div class="dropdown-menu dropdown-menu-right p-0" style="min-width: 180px; overflow: hidden; border-radius: 8px; border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                <a href="javascript:void(0)" onclick="window.accessibilityWidgetInstance.changeLanguage('id')" class="dropdown-item py-2 px-3 d-flex align-items-center" style="gap: 12px;">
                    <img src="https://flagcdn.com/w20/id.png" style="width: 20px; border-radius: 2px;"> 
                    <span>Indonesia</span>
                </a>
                <a href="javascript:void(0)" onclick="window.accessibilityWidgetInstance.changeLanguage('en')" class="dropdown-item py-2 px-3 d-flex align-items-center" style="gap: 12px;">
                    <img src="https://flagcdn.com/w20/gb.png" style="width: 20px; border-radius: 2px;"> 
                    <span>Bahasa inggris</span>
                </a>
                <a href="javascript:void(0)" onclick="window.accessibilityWidgetInstance.changeLanguage('ar')" class="dropdown-item py-2 px-3 d-flex align-items-center" style="gap: 12px;">
                    <img src="https://flagcdn.com/w20/sa.png" style="width: 20px; border-radius: 2px;"> 
                    <span>Arab</span>
                </a>
            </div>
        </li>

        {{-- User menu link --}}
        @if(Auth::user())
            @if(config('adminlte.usermenu_enabled'))
                @include('adminlte::partials.navbar.menu-item-dropdown-user-menu')
            @else
                @include('adminlte::partials.navbar.menu-item-logout-link')
            @endif
        @endif

        {{-- Right sidebar toggler link --}}
        @if($layoutHelper->isRightSidebarEnabled())
            @include('adminlte::partials.navbar.menu-item-right-sidebar-toggler')
        @endif
    </ul>

</nav>
