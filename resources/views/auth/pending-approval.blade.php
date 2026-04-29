@extends('adminlte::master')

@section('adminlte_css')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f4f6f9; }
        .pending-card {
            max-width: 600px;
            margin: 80px auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            padding: 40px;
            text-align: center;
        }
        .status-icon {
            font-size: 80px;
            color: #f39c12;
            margin-bottom: 20px;
        }
        .btn-action {
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            margin-top: 20px;
        }
    </style>
@stop

@section('body')
<div class="container">
    <div class="pending-card">
        <div class="status-icon">
            <i class="fas fa-clock"></i>
        </div>
        <h2 style="font-weight: 700; color: #333;">Menunggu Persetujuan</h2>
        <p style="color: #666; font-size: 16px; margin-top: 10px; line-height: 1.6;">
            Akun Anda telah berhasil dibuat. Silahkan ajukan permohonan role akses (Operator Unit, Admin Rektorat, dll) 
            dengan melampirkan SK Penugasan untuk dapat mengakses menu transaksi.
        </p>
        
        <div class="mt-4">
            <a href="{{ route('role-requests.create') }}" class="btn btn-primary btn-action shadow">
                <i class="fas fa-paper-plane mr-2"></i> Ajukan Permohonan Role
            </a>
            <form method="POST" action="{{ route('logout') }}" class="d-inline-block ml-2">
                @csrf
                <button type="submit" class="btn btn-outline-secondary btn-action">
                    Keluar
                </button>
            </form>
        </div>
    </div>
</div>
@stop
