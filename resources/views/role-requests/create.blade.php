@extends('adminlte::page')

@section('title', 'Ajukan Permohonan Role')

@section('content_header')
    <h1>Ajukan Permohonan Role Akses</h1>
@stop

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Formulir Pengajuan Role</h3>
            </div>
            <form action="{{ route('role-requests.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Silahkan isi formulir di bawah ini untuk mengajukan hak akses sebagai Operator Unit atau role lainnya. Wajib melampirkan scan SK Penugasan.
                    </div>

                    <div class="form-group">
                        <label>Role yang Diajukan</label>
                        <select name="requested_role" class="form-control @error('requested_role') is-invalid @enderror" required id="roleSelect">
                            <option value="">-- Pilih Role --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role }}">{{ ucfirst(str_replace('_', ' ', $role)) }}</option>
                            @endforeach
                        </select>
                        @error('requested_role') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group" id="unitGroup">
                        <label>Unit Kerja</label>
                        <select name="unit_id" class="form-control @error('unit_id') is-invalid @enderror">
                            <option value="">-- Pilih Unit Kerja --</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }} ({{ $unit->code }})</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Pilih unit kerja tempat Anda bertugas.</small>
                        @error('unit_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Upload SK Penugasan</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('sk_file') is-invalid @enderror" id="skFile" name="sk_file" required accept=".pdf,.jpg,.jpeg,.png">
                                <label class="custom-file-label" for="skFile">Pilih file (PDF/JPG, Max 2MB)</label>
                            </div>
                        </div>
                        @error('sk_file') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label>Catatan Tambahan (Opsional)</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Contoh: Mohon segera disetujui untuk keperluan input data rkbmn."></textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Kirim Pengajuan</button>
                    <a href="{{ route('dashboard') }}" class="btn btn-default float-right">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    $(document).ready(function () {
        bsCustomFileInput.init();
        
        // Show/hide unit selection based on role
        $('#roleSelect').change(function() {
            var role = $(this).val();
            // Assuming 'operator_unit' and 'operator_fakultas' need unit selection
            if(role == 'admin' || role == 'admin_rektorat' || role == 'superadmin') {
               // Logic can be adjusted based on requirements. For now showing for all to be safe, or hide for admin?
               // Let's keep it visible but maybe optional logic validation is in backend
            }
        });
    });
</script>
@stop
