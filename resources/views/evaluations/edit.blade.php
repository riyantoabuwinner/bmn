@extends('adminlte::page')

@section('title', 'Input Hasil Evaluasi')

@section('content_header')
    <h1>Input Hasil Evaluasi: {{ $evaluation->period_name }}</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('evaluations.update', $evaluation) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="card-header">
                <div class="float-right">
                    <button type="submit" name="save_draft" value="1" class="btn btn-default mr-2">
                        <i class="fas fa-save"></i> Simpan Draft
                    </button>
                    <!-- Finalize Button triggers modal or confirm -->
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#finalizeModal">
                        <i class="fas fa-check-circle"></i> Finalisasi Evaluasi
                    </button>
                </div>
            </div>

            <div class="card-body table-responsive p-0" style="height: 600px;">
                <table class="table table-head-fixed text-nowrap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Aset</th>
                            <th>Nama Aset</th>
                            <th>Kondisi Saat Ini</th>
                            <th>Tindakan Diperlukan</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($details as $detail)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $detail->asset->kode_barang ?? '-' }}</td>
                                <td>{{ $detail->asset->nama_barang ?? '-' }}</td>
                                <td>
                                    <!-- Use name="details[ID][field]" for bulk update -->
                                    <select name="details[{{ $detail->id }}][condition_status]" class="form-control form-control-sm">
                                        <option value="baik" {{ $detail->condition_status == 'baik' ? 'selected' : '' }}>Baik</option>
                                        <option value="rusak_ringan" {{ $detail->condition_status == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                        <option value="rusak_berat" {{ $detail->condition_status == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                                        <option value="hilang" {{ $detail->condition_status == 'hilang' ? 'selected' : '' }}>Hilang</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="details[{{ $detail->id }}][action_needed]" class="form-control form-control-sm" value="{{ $detail->action_needed }}" placeholder="Contoh: Perbaiki/Hapus">
                                </td>
                                <td>
                                    <input type="text" name="details[{{ $detail->id }}][notes]" class="form-control form-control-sm" value="{{ $detail->notes }}" placeholder="Catatan tambahan...">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $details->links() }}
                <small class="text-muted float-right">Total Aset: {{ $details->total() }}</small>
            </div>

            <!-- Finalize Modal -->
            <div class="modal fade" id="finalizeModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Konfirmasi Finalisasi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin memfinalisasi evaluasi ini?</p>
                            <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan. Status kondisi aset induk akan diperbarui sesuai hasil evaluasi.</small></p>
                            
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="is_final" value="1" id="confirmFinal" required>
                                <label class="form-check-label" for="confirmFinal">Ya, saya mengerti dan ingin memfinalisasi.</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Finalisasi Sekarang</button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
@stop
