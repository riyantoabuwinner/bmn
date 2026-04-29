@extends('adminlte::page')

@section('title', 'Pengembalian Aset')

@section('content_header')
    <h1>Proses Pengembalian Aset</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <!-- Asset Info -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Informasi Aset & Pemegang</h3>
                </div>
                <div class="card-body">
                    <dl>
                        <dt>Kode Aset</dt>
                        <dd>{{ $assignment->asset->kode_barang }}</dd>
                        
                        <dt>Nama Aset</dt>
                        <dd>{{ $assignment->asset->nama_barang }}</dd>
                        
                        <dt>Pemegang Saat Ini</dt>
                        <dd>{{ $assignment->employee_name }}</dd>
                        
                        <dt>Tanggal Diserahkan</dt>
                        <dd>{{ $assignment->assigned_date->format('d F Y') }}</dd>
                        
                        <dt>Kondisi Awal</dt>
                        <dd>{{ ucfirst($assignment->condition_on_assign) }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <!-- Return Form -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Pengembalian</h3>
                </div>
                <form action="{{ route('assignments.process-return', $assignment) }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="return_date">Tanggal Kembali <span class="text-danger">*</span></label>
                            <input type="date" name="return_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="condition_on_return">Kondisi Aset <span class="text-danger">*</span></label>
                            <select name="condition_on_return" class="form-control" required>
                                <option value="baik">Baik</option>
                                <option value="rusak_ringan">Rusak Ringan</option>
                                <option value="rusak_berat">Rusak Berat</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="notes">Catatan Pengembalian</label>
                            <textarea name="notes" class="form-control" rows="3" placeholder="Keterangan tambahan..."></textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Proses Pengembalian</button>
                        <a href="{{ route('assignments.show', $assignment) }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
