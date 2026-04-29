@extends('adminlte::page')

@section('title', 'Ajukan Peminjaman')

@section('content_header')
    <h1>Ajukan Peminjaman Aset</h1>
@stop

@section('content')
    <form action="{{ route('borrowings.store') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="asset_id">Pilih Aset <span class="text-danger">*</span></label>
                    <select name="asset_id" id="asset_id" class="form-control @error('asset_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Aset yang Tersedia --</option>
                        @foreach($assets as $asset)
                            <option value="{{ $asset->id }}" {{ old('asset_id') == $asset->id ? 'selected' : '' }}>
                                {{ $asset->kode_barang }} - {{ $asset->nama_barang }} ({{ $asset->kondisi ?? '-' }})
                            </option>
                        @endforeach
                    </select>
                    @error('asset_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="borrower_name">Nama Peminjam <span class="text-danger">*</span></label>
                            <input type="text" name="borrower_name" id="borrower_name" class="form-control @error('borrower_name') is-invalid @enderror" 
                                   value="{{ old('borrower_name') }}" required>
                            @error('borrower_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="borrower_phone">No. Telepon <span class="text-danger">*</span></label>
                            <input type="text" name="borrower_phone" id="borrower_phone" class="form-control @error('borrower_phone') is-invalid @enderror" 
                                   value="{{ old('borrower_phone') }}" required>
                            @error('borrower_phone')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="borrower_email">Email (opsional)</label>
                    <input type="email" name="borrower_email" id="borrower_email" class="form-control @error('borrower_email') is-invalid @enderror" 
                           value="{{ old('borrower_email') }}">
                    @error('borrower_email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="borrow_date">Tanggal Pinjam <span class="text-danger">*</span></label>
                            <input type="date" name="borrow_date" id="borrow_date" class="form-control @error('borrow_date') is-invalid @enderror"  
                                   value="{{ old('borrow_date', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required>
                            @error('borrow_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="return_date">Tanggal Kembali <span class="text-danger">*</span></label>
                            <input type="date" name="return_date" id="return_date" class="form-control @error('return_date') is-invalid @enderror" 
                                   value="{{ old('return_date') }}" required>
                            @error('return_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="purpose">Tujuan Peminjaman <span class="text-danger">*</span></label>
                    <textarea name="purpose" id="purpose" rows="3" class="form-control @error('purpose') is-invalid @enderror" required>{{ old('purpose') }}</textarea>
                    @error('purpose')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i> Kirim Permohonan
                </button>
                <a href="{{ route('borrowings.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
@stop

@section('js')
    <script>
        // Auto set minimum return date when borrow date changes
        $('#borrow_date').change(function() {
            var borrowDate = new Date($(this).val());
            borrowDate.setDate(borrowDate.getDate() + 1);
            var minReturnDate = borrowDate.toISOString().split('T')[0];
            $('#return_date').attr('min', minReturnDate);
            if ($('#return_date').val() <= $(this).val()) {
                $('#return_date').val(minReturnDate);
            }
        });
    </script>
@stop
