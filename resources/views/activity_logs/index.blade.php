@extends('adminlte::page')

@section('title', 'Log Aktivitas')

@section('content_header')
    <h1>Log Aktivitas</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Aktivitas User</h3>
            <div class="card-tools">
                <form action="{{ route('logs.index') }}" method="GET" class="form-inline">
                    <div class="input-group input-group-sm" style="width: 250px;">
                        <input type="text" name="action" class="form-control float-right" placeholder="Search Action/Desc" value="{{ request('action') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Description</th>
                        <th>IP Address</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                        <tr>
                            <td>{{ $log->id }}</td>
                            <td>{{ $log->user->name ?? 'Unknown' }}</td>
                            <td><span class="badge badge-info">{{ $log->action }}</span></td>
                            <td>{{ $log->description }}</td>
                            <td>{{ $log->ip_address }}</td>
                            <td>{{ $log->created_at->format('d M Y H:i:s') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data aktivitas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $logs->links() }}
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
