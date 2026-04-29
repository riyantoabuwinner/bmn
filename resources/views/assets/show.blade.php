@extends('adminlte::page')

@section('title', 'Detail Aset')

@section('content_header')
    <h1>Detail Aset (SIMAN V2)</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-3">
            <!-- Profile Image -->
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        @if($asset->photo)
                            <img class="profile-user-img img-fluid img-circle"
                                src="{{ asset('storage/' . $asset->photo) }}"
                                alt="Foto Aset">
                        @else
                            <div class="text-center py-5 bg-light">
                                <i class="fas fa-box fa-3x text-muted"></i>
                            </div>
                        @endif
                    </div>

                    <h3 class="profile-username text-center mt-3">{{ $asset->nama_barang }}</h3>

                    <p class="text-muted text-center">{{ $asset->kode_barang }}</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>NUP</b> <a class="float-right">{{ $asset->nup }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Kondisi</b> 
                            <a class="float-right">
                                @if(Str::contains(strtolower($asset->kondisi), 'baik'))
                                    <span class="badge badge-success">{{ $asset->kondisi }}</span>
                                @elseif(Str::contains(strtolower($asset->kondisi), 'ringan'))
                                    <span class="badge badge-warning">{{ $asset->kondisi }}</span>
                                @else
                                    <span class="badge badge-danger">{{ $asset->kondisi }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="list-group-item">
                            <b>Status</b> <a class="float-right">{{ $asset->status_pemanfaatan ?? '-' }}</a>
                        </li>
                    </ul>

                    <a href="{{ route('assets.index') }}" class="btn btn-default btn-block"><b>Kembali</b></a>
                    <a href="{{ route('assets.edit', $asset) }}" class="btn btn-primary btn-block"><b>Edit Aset</b></a>
                </div>
            </div>
            
            <!-- QR Code Box -->
             <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Identitas SIMAN V2</h3>
                </div>
                <div class="card-body">
                    <strong>ID Aset Unik (Persistent)</strong>
                    <div class="bg-light p-2 border mb-3">
                        <code class="text-primary font-weight-bold">{{ $asset->unique_asset_id ?? '-' }}</code>
                    </div>

                    <strong>Inventarisasi Terakhir</strong>
                    <div class="mb-3">
                        @if($asset->last_inventory_at)
                            <span class="badge badge-success"><i class="fas fa-check"></i> {{ $asset->last_inventory_at->format('d M Y H:i') }}</span>
                        @else
                            <span class="badge badge-danger"><i class="fas fa-times"></i> Belum Pernah Sensus</span>
                        @endif
                        <form action="{{ route('assets.update-inventory', $asset) }}" method="POST" class="mt-2">
                            @csrf
                            <button type="submit" class="btn btn-xs btn-success btn-block">
                                <i class="fas fa-sync"></i> Update Inventarisasi
                            </button>
                        </form>
                    </div>

                    <hr>
                    <strong>QR Code / Register</strong>
                    <div class="text-center mt-2">
                        @if($asset->qr_code)
                            <code>{{ $asset->qr_code }}</code>
                        @endif
                        <p class="small text-muted mb-0">No Reg: {{ $asset->kode_register ?? '-' }}</p>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#detail" data-toggle="tab">Detail Utama</a></li>
                        <li class="nav-item"><a class="nav-link" href="#fisik" data-toggle="tab">Fisik & Lokasi</a></li>
                        <li class="nav-item"><a class="nav-link" href="#legal" data-toggle="tab">Legalitas</a></li>
                        <li class="nav-item"><a class="nav-link" href="#org" data-toggle="tab">Organisasi</a></li>
                        <li class="nav-item"><a class="nav-link" href="#history" data-toggle="tab">Riwayat</a></li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <!-- Detail Utama -->
                        <div class="active tab-pane" id="detail">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong><i class="fas fa-tag mr-1"></i> Identitas</strong>
                                    <p class="text-muted">
                                        Merk: {{ $asset->merk ?? '-' }}<br>
                                        Tipe: {{ $asset->tipe ?? '-' }}<br>
                                        Intra/Ekstra: {{ $asset->intra_ekstra ?? '-' }}<br>
                                        Kuantitas: {{ $asset->kuantitas }} {{ $asset->satuan }}
                                    </p>
                                    
                                    <strong><i class="far fa-calendar-alt mr-1"></i> Tanggal Penting</strong>
                                    <p class="text-muted">
                                        Perolehan: {{ $asset->tgl_perolehan_pertama ? $asset->tgl_perolehan_pertama->format('d M Y') : '-' }}<br>
                                        Pembukuan: {{ $asset->tgl_buku ? $asset->tgl_buku->format('d M Y') : '-' }}<br>
                                        Buku Pertama: {{ $asset->tgl_buku_pertama ? $asset->tgl_buku_pertama->format('d M Y') : '-' }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <strong><i class="fas fa-money-bill-wave mr-1"></i> Nilai Aset</strong>
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td>Nilai Perolehan Pertama</td>
                                            <td class="text-right">Rp {{ number_format($asset->nilai_perolehan_pertama, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nilai Mutasi</td>
                                            <td class="text-right">Rp {{ number_format($asset->nilai_mutasi, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nilai Perolehan (Kini)</td>
                                            <td class="text-right font-weight-bold">Rp {{ number_format($asset->nilai_perolehan, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nilai Penyusutan</td>
                                            <td class="text-right text-danger">- Rp {{ number_format($asset->nilai_penyusutan, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr class="border-top">
                                            <td><strong>Nilai Buku</strong></td>
                                            <td class="text-right"><strong>Rp {{ number_format($asset->nilai_buku, 0, ',', '.') }}</strong></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <hr>
                            <strong><i class="fas fa-flag mr-1"></i> Status Khusus (SIMAN v2)</strong>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <dl class="row mb-0">
                                        <dt class="col-sm-6">Henti Guna</dt> <dd class="col-sm-6">{{ $asset->henti_guna ?? '-' }}</dd>
                                        <dt class="col-sm-6">BPYBDS</dt> <dd class="col-sm-6">{{ $asset->bpybds ?? '-' }}</dd>
                                        <dt class="col-sm-6">Hibah DKTP</dt> <dd class="col-sm-6">{{ $asset->hibah_dktp ?? '-' }}</dd>
                                        <dt class="col-sm-6">Konsensi Jasa</dt> <dd class="col-sm-6">{{ $asset->konsensi_jasa ?? '-' }}</dd>
                                    </dl>
                                </div>
                                <div class="col-md-6">
                                    <dl class="row mb-0">
                                        <dt class="col-sm-6">Barang Hilang</dt> <dd class="col-sm-6">{{ $asset->usulan_barang_hilang ?? '-' }}</dd>
                                        <dt class="col-sm-6">Barang RB</dt> <dd class="col-sm-6">{{ $asset->usulan_barang_rb ?? '-' }}</dd>
                                        <dt class="col-sm-6">Usulan RB</dt> <dd class="col-sm-6">{{ $asset->usulan_rusak_berat ?? '-' }}</dd>
                                        <dt class="col-sm-6">Usul Hapus</dt> <dd class="col-sm-6">{{ $asset->usulan_hapus ?? '-' }}</dd>
                                        <dt class="col-sm-6">Prop. Investasi</dt> <dd class="col-sm-6">{{ $asset->properti_investasi ?? '-' }}</dd>
                                    </dl>
                                </div>
                            </div>

                            <hr>
                            <strong><i class="fas fa-sticky-note mr-1"></i> Keterangan</strong>
                            <p class="text-muted">{{ $asset->keterangan ?? '-' }}</p>
                            
                            <strong>Cara Perolehan</strong>: {{ $asset->cara_perolehan ?? '-' }} <br>
                            <strong>No Bukti</strong>: {{ $asset->no_bukti ?? '-' }} <br>
                            <strong>Extra Info</strong>: {{ $asset->extra_info ?? '-' }}
                        </div>

                        <!-- Fisik & Lokasi -->
                        <div class="tab-pane" id="fisik">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Spesifikasi Luas (m²)</h5>
                                    <dl class="row">
                                        <dt class="col-sm-6">Luas</dt>
                                        <dd class="col-sm-6">{{ number_format($asset->luas, 2) }}</dd>

                                        <dt class="col-sm-6">Tanah utk Bangunan</dt>
                                        <dd class="col-sm-6">{{ number_format($asset->luas_tanah_bangunan, 2) }}</dd>

                                        <dt class="col-sm-6">Tanah utk Sarana</dt>
                                        <dd class="col-sm-6">{{ number_format($asset->luas_tanah_sarana, 2) }}</dd>
                                        
                                        <dt class="col-sm-6">Lahan Kosong</dt>
                                        <dd class="col-sm-6">{{ number_format($asset->luas_lahan_kosong, 2) }}</dd>

                                        <dt class="col-sm-6">Ket. Lahan Kosong</dt>
                                        <dd class="col-sm-6">{{ $asset->lahan_kosong ?? '-' }}</dd>

                                        <dt class="col-sm-6">Bangunan</dt>
                                        <dd class="col-sm-6">{{ number_format($asset->luas_bangunan, 2) }}</dd>
                                    </dl>
                                    
                                    <strong>Fisik Lainnya:</strong>
                                    <ul>
                                        <li>Jumlah Lantai: {{ $asset->jumlah_lantai }}</li>
                                        <li>Jumlah Foto: {{ $asset->jumlah_foto }}</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h5>Alamat & Lokasi</h5>
                                    <p>
                                        <strong>Alamat:</strong> <br>
                                        {{ $asset->alamat ?? '-' }}
                                    </p>
                                    <dl class="row">
                                        <dt class="col-sm-4">RT / RW</dt>
                                        <dd class="col-sm-8">{{ $asset->rt_rw ?? '-' }}</dd>

                                        <dt class="col-sm-4">Kelurahan</dt>
                                        <dd class="col-sm-8">{{ $asset->desa_kel ?? '-' }}</dd>

                                        <dt class="col-sm-4">Kecamatan</dt>
                                        <dd class="col-sm-8">{{ $asset->kecamatan ?? '-' }}</dd>
                                        
                                        <dt class="col-sm-4">Kab/Kota</dt>
                                        <dd class="col-sm-8">{{ $asset->kab_kota ?? '-' }} ({{ $asset->kode_kab_kota }})</dd>

                                        <dt class="col-sm-4">Provinsi</dt>
                                        <dd class="col-sm-8">{{ $asset->provinsi ?? '-' }} ({{ $asset->kode_provinsi }})</dd>
                                        
                                        <dt class="col-sm-4">Kode Pos</dt>
                                        <dd class="col-sm-8">{{ $asset->kode_pos ?? '-' }}</dd>
                                    </dl>
                                    <p><strong>Lokasi Ruang:</strong> {{ $asset->lokasi_ruang ?? '-' }}</p>
                                    <p><strong>Keterangan Lokasi:</strong> {{ $asset->lokasi ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Legalitas -->
                        <div class="tab-pane" id="legal">
                             <div class="row">
                                <div class="col-md-6">
                                    <h5>Status BMN & SBSN</h5>
                                    <dl>
                                        <dt>Status BMN</dt>
                                        <dd>{{ $asset->status_bmn ?? '-' }}</dd>
                                        
                                        <dt>Status SBSN</dt>
                                        <dd>{{ $asset->status_sbsn ?? '-' }}</dd>
                                        
                                        <dt>Idle / Kemitraan</dt>
                                        <dd>{{ $asset->status_bmn_idle ?? '-' }} / {{ $asset->status_kemitraan ?? '-' }}</dd>
                                        
                                        <dt>Masa Manfaat</dt>
                                        <dd>{{ $asset->masa_manfaat ?? '-' }} Tahun</dd>
                                        
                                        <dt>Sisa Masa Manfaat</dt>
                                        <dd>{{ $asset->sisa_masa_manfaat ?? '-' }} Bulan</dd>
                                    </dl>
                                </div>
                                <div class="col-md-6">
                                    <h5>Dokumen Legal</h5>
                                    <dl class="row">
                                        <dt class="col-sm-5">Jenis Dokumen</dt> <dd class="col-sm-7">{{ $asset->jenis_dokumen ?? '-' }}</dd>
                                        <dt class="col-sm-5">No Dokumen</dt> <dd class="col-sm-7">{{ $asset->no_dokumen ?? '-' }}</dd>
                                        <dt class="col-sm-5">Tanggal Dokumen</dt> <dd class="col-sm-7">{{ $asset->tgl_dokumen ? $asset->tgl_dokumen->format('d M Y') : '-' }}</dd>
                                        <dt class="col-sm-5">No PSP</dt> <dd class="col-sm-7">{{ $asset->no_psp ?? '-' }}</dd>
                                        <dt class="col-sm-5">Tanggal PSP</dt> <dd class="col-sm-7">{{ $asset->tgl_psp ? $asset->tgl_psp->format('d M Y') : '-' }}</dd>
                                        <dt class="col-sm-5">No BPKP</dt> <dd class="col-sm-7">{{ $asset->no_bpkp ?? '-' }}</dd>
                                        <dt class="col-sm-5">No Polisi / STNK</dt> <dd class="col-sm-7">{{ $asset->no_polisi ?? '-' }} / {{ $asset->no_stnk ?? '-' }}</dd>
                                        <dt class="col-sm-5">Status PMK</dt> <dd class="col-sm-7">{{ $asset->status_pmk ?? '-' }}</dd>
                                    </dl>
                                </div>
                                <div class="col-md-6">
                                    <h5>Sertifikasi</h5>
                                    <dl class="row">
                                        <dt class="col-sm-5">Status</dt> <dd class="col-sm-7">{{ $asset->status_sertifikasi ?? '-' }}</dd>
                                        <dt class="col-sm-5">Jenis</dt> <dd class="col-sm-7">{{ $asset->jenis_sertifikat ?? '-' }}</dd>
                                        <dt class="col-sm-5">No Sertifikat</dt> <dd class="col-sm-7">{{ $asset->no_sertifikat ?? '-' }}</dd>
                                        <dt class="col-sm-5">Nama Sertifikat</dt> <dd class="col-sm-7">{{ $asset->nama_sertifikat ?? '-' }}</dd>
                                        <dt class="col-sm-5">Tgl Sertifikat</dt> <dd class="col-sm-7">{{ $asset->tgl_sertifikat ? $asset->tgl_sertifikat->format('d M Y') : '-' }}</dd>
                                        <dt class="col-sm-5">Masa Berlaku</dt> <dd class="col-sm-7">{{ $asset->masa_berlaku ? $asset->masa_berlaku->format('d M Y') : '-' }}</dd>
                                        <dt class="col-sm-5">Pemegang Hak</dt> <dd class="col-sm-7">{{ $asset->nama_pemegang_hak ?? '-' }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Organisasi -->
                        <div class="tab-pane" id="org">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Satuan Kerja</strong>
                                    <p>{{ $asset->kode_satker }} - {{ $asset->nama_satker }}</p>
                                    
                                    <strong>K/L (Kementerian/Lembaga)</strong>
                                    <p>{{ $asset->nama_kl ?? '-' }}</p>
                                    
                                    <strong>Eselon 1</strong>
                                    <p>{{ $asset->nama_e1 ?? '-' }}</p>
                                    
                                    <strong>Korwil</strong>
                                    <p>{{ $asset->nama_korwil ?? '-' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <strong>KPKNL</strong>
                                    <p>{{ $asset->kode_kpknl }} - {{ $asset->uraian_kpknl ?? '-' }}</p>
                                    
                                    <strong>Kanwil DJKN</strong>
                                    <p>{{ $asset->uraian_kanwil ?? '-' }}</p>

                                    <hr>
                                    <strong>Pengguna & Penghuni</strong>
                                    <dl class="row">
                                        <dt class="col-sm-4">Pengguna</dt> <dd class="col-sm-8">{{ $asset->pengguna ?? '-' }}</dd>
                                        <dt class="col-sm-4">Penghuni</dt> <dd class="col-sm-8">{{ $asset->penghuni ?? '-' }}</dd>
                                        <dt class="col-sm-4">Nama Pengguna (SIMAN)</dt> <dd class="col-sm-8">{{ $asset->nama_pengguna_siman ?? '-' }}</dd>
                                    </dl>
                                    <hr>
                                    <strong>Identitas Tambahan</strong>
                                    <dl class="row">
                                        <dt class="col-sm-4">Jenis Identitas</dt> <dd class="col-sm-8">{{ $asset->jenis_identitas ?? '-' }}</dd>
                                        <dt class="col-sm-4">No Identitas</dt> <dd class="col-sm-8">{{ $asset->no_identitas ?? '-' }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="history">
                            <!-- Maintenance History -->
                            <h5>Riwayat Pemeliharaan</h5>
                            @if($asset->maintenances->count() > 0)
                                <div class="timeline timeline-inverse">
                                    @foreach($asset->maintenances as $maintenance)
                                        <div>
                                            <i class="fas fa-tools bg-primary"></i>
                                            <div class="timeline-item">
                                                <span class="time"><i class="far fa-clock"></i> {{ $maintenance->created_at->format('d M Y') }}</span>
                                                <h3 class="timeline-header"><a href="#">Maintenance</a> {{ $maintenance->maintenance_type }}</h3>
                                                <div class="timeline-body">
                                                    {{ $maintenance->condition_summary }} <br> Status: {{ $maintenance->status }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted">Belum ada riwayat pemeliharaan.</p>
                            @endif

                            <hr>
                            
                            <!-- Utilization History (was Borrowing) -->
                            <h5>Riwayat Pemanfaatan</h5>
                            @if($asset->utilizations->count() > 0)
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Pihak / Mitra</th><th>Jenis</th><th>Mulai</th><th>Selesai</th><th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($asset->utilizations as $utilization)
                                            <tr>
                                                <td>{{ $utilization->partner_name }}</td>
                                                <td>{{ $utilization->utilization_type }}</td>
                                                <td>{{ $utilization->start_date->format('d/m/Y') }}</td>
                                                <td>{{ $utilization->end_date->format('d/m/Y') }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $utilization->status == 'active' ? 'success' : 'secondary' }}">
                                                        {{ ucfirst($utilization->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="text-muted">Belum ada riwayat pemanfaatan.</p>
                            @endif
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
@stop
