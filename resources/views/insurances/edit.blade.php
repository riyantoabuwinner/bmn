@extends('adminlte::page')

@section('title', 'Edit Data Asuransi')

@section('content_header')
    <h1>Edit Data Asuransi</h1>
@stop

@section('content')
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Update Informasi Pertanggungan: {{ $insurance->asset->nama_barang }}</h3>
        </div>
        <form action="{{ route('insurances.update', $insurance) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nomor Polis</label>
                            <input type="text" name="policy_number" class="form-control" value="{{ old('policy_number', $insurance->policy_number) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Perusahaan Asuransi</label>
                            <input type="text" name="insurance_company" class="form-control" value="{{ old('insurance_company', $insurance->insurance_company) }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Mulai</label>
                            <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $insurance->start_date ? $insurance->start_date->format('Y-m-d') : '') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Berakhir</label>
                            <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $insurance->end_date ? $insurance->end_date->format('Y-m-d') : '') }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nilai Pertanggungan (Rp)</label>
                            <input type="number" name="coverage_amount" class="form-control" step="0.01" value="{{ old('coverage_amount', $insurance->coverage_amount) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nilai Premi (Rp)</label>
                            <input type="number" name="premium_amount" class="form-control" step="0.01" value="{{ old('premium_amount', $insurance->premium_amount) }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="Usulan" {{ $insurance->status == 'Usulan' ? 'selected' : '' }}>Usulan</option>
                                <option value="Aktif" {{ $insurance->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Berakhir" {{ $insurance->status == 'Berakhir' ? 'selected' : '' }}>Berakhir</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Update Dokumen Polis (PDF/JPG/PNG)</label>
                            @if($insurance->document)
                                <div class="mb-2">
                                    <a href="{{ asset('storage/' . $insurance->document) }}" target="_blank" class="btn btn-xs btn-outline-primary">
                                        <i class="fas fa-file-download"></i> Lihat Dokumen Saat Ini
                                    </a>
                                </div>
                            @endif
                            <input type="file" name="document" class="form-control-file">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Catatan</label>
                    <textarea name="notes" class="form-control" rows="3">{{ old('notes', $insurance->notes) }}</textarea>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('insurances.index') }}" class="btn btn-default">Kembali</a>
            </div>
        </form>
    </div>
@stop
