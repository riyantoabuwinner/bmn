@extends('adminlte::page')

@section('title', 'Edit Usulan Pengadaan')

@section('content_header')
    <h1>Edit Usulan Pengadaan</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('rkbmn.procurements.update', $procurement) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="year">Tahun Anggaran</label>
                            <input type="number" name="year" class="form-control" value="{{ $procurement->year }}" min="2025" max="2030" required>
                        </div>

                        <div class="form-group">
                            <label for="name">Nama Barang</label>
                            <input type="text" name="name" class="form-control" value="{{ $procurement->name }}" required>
                        </div>

                        <div class="form-group">
                            <label for="type">Jenis Aset</label>
                            <select name="type" class="form-control" required>
                                @foreach(['Tanah', 'Gedung dan Bangunan', 'Peralatan dan Mesin', 'Jalan, Irigasi, Jaringan', 'Aset Tetap Lainnya'] as $type)
                                    <option value="{{ $type }}" {{ $procurement->type == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="quantity">Volume (Jumlah)</label>
                                    <input type="number" name="quantity" class="form-control" value="{{ $procurement->quantity }}" min="1" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="unit">Satuan</label>
                                    <input type="text" name="unit" class="form-control" value="{{ $procurement->unit }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="estimated_unit_price">Estimasi Harga Satuan (Rp)</label>
                            <input type="number" name="estimated_unit_price" class="form-control" value="{{ $procurement->estimated_unit_price }}" min="0" required>
                        </div>

                        <div class="form-group">
                            <label for="priority">Prioritas Kebutuhan</label>
                             <select name="priority" class="form-control" required>
                                @foreach(['Tinggi', 'Sedang', 'Rendah'] as $prio)
                                    <option value="{{ $prio }}" {{ $procurement->priority == $prio ? 'selected' : '' }}>{{ $prio }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="justification">Justifikasi Kebutuhan (Alasan Pengadaan)</label>
                    <textarea name="justification" class="form-control" rows="3" required>{{ $procurement->justification }}</textarea>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update Usulan</button>
                <a href="{{ route('rkbmn.procurements.index') }}" class="btn btn-default">Kembali</a>
            </div>
        </form>
    </div>
@stop
