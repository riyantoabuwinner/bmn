@extends('adminlte::page')

@section('title', 'Detail User')

@section('content_header')
    <h1>Detail Pengguna</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Profile Pengguna</h3>
            <div class="card-tools">
                <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Edit User
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=128" class="img-circle mb-3" alt="User Image">
                    <h4>{{ $user->name }}</h4>
                    <p class="text-muted">{{ $user->roles->pluck('name')->implode(', ') }}</p>
                </div>
                <div class="col-md-8">
                    <table class="table table-bordered">
                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Unit Kerja</th>
                            <td>{{ $user->unit ? $user->unit->name : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Telepon</th>
                            <td>{{ $user->phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Status Akun</th>
                            <td>
                                @if($user->is_active)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Non-Aktif/Suspended</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Bergabung Sejak</th>
                            <td>{{ $user->created_at->format('d F Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class="mt-4">
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@stop
