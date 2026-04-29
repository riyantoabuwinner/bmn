@extends('adminlte::master')

@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\PreloaderHelper')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('css/custom-theme.css') }}">
    @stack('css')
    @yield('css')
    <style>
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
@stop

@section('classes_body', $layoutHelper->makeBodyClasses())

@section('body_data', $layoutHelper->makeBodyData())

@section('body')
    <div class="wrapper">

        {{-- Preloader Animation (fullscreen mode) --}}
        @if($preloaderHelper->isPreloaderEnabled())
            @include('adminlte::partials.common.preloader')
        @endif

        {{-- Top Navbar --}}
        @if($layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.navbar.navbar-layout-topnav')
        @else
            @include('adminlte::partials.navbar.navbar')
        @endif

        {{-- Left Main Sidebar --}}
        @if(!$layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.sidebar.left-sidebar')
        @endif

        {{-- Content Wrapper --}}
        @empty($iFrameEnabled)
            @include('adminlte::partials.cwrapper.cwrapper-default')
        @else
            @include('adminlte::partials.cwrapper.cwrapper-iframe')
        @endempty

        {{-- Footer --}}
        @include('adminlte::partials.footer.footer')

        {{-- Right Control Sidebar --}}
        @if($layoutHelper->isRightSidebarEnabled())
            @include('adminlte::partials.sidebar.right-sidebar')
        @endif

    </div>
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
@stop
