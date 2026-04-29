@extends('adminlte::page')

@section('title', 'Edit Aset')

@section('content_header')
    <h1>Edit Aset (SIMAN V2)</h1>
@stop

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Form Edit Data Aset SIMAN V2</h3>
        </div>
        <form action="{{ route('assets.update', $asset) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <!-- 0. ID Persistent -->
                <div class="alert alert-light border">
                    <small class="text-muted mr-2">ID Aset Unik (Persistent):</small>
                    <code class="text-primary font-weight-bold text-lg">{{ $asset->unique_asset_id }}</code>
                </div>

                <!-- 1. Identitas -->
                <h5 class="text-primary"><i class="fas fa-barcode mr-2"></i> Identitas Barang & Satker</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kode Satker</label>
                            <input type="text" name="kode_satker" class="form-control" value="{{ old('kode_satker', $asset->kode_satker) }}">
                        </div>
                        <div class="form-group">
                            <label>Nama Satker</label>
                            <input type="text" name="nama_satker" class="form-control" value="{{ old('nama_satker', $asset->nama_satker) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kode Barang <span class="text-danger">*</span></label>
                                    <input type="text" name="kode_barang" class="form-control" required value="{{ old('kode_barang', $asset->kode_barang) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>NUP <span class="text-danger">*</span></label>
                                    <input type="number" name="nup" class="form-control" required value="{{ old('nup', $asset->nup) }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nama Barang <span class="text-danger">*</span></label>
                            <input type="text" name="nama_barang" class="form-control" required value="{{ old('nama_barang', $asset->nama_barang) }}">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Merk</label>
                                    <input type="text" name="merk" class="form-control" value="{{ old('merk', $asset->merk) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tipe</label>
                                    <input type="text" name="tipe" class="form-control" value="{{ old('tipe', $asset->tipe) }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Jenis BMN (Kategori)</label>
                            <select name="category_id" class="form-control select2">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id', $asset->category_id) == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Kode Register</label>
                                    <input type="text" name="kode_register" class="form-control" value="{{ old('kode_register', $asset->kode_register) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Masa Manfaat</label>
                                    <input type="text" name="masa_manfaat" class="form-control" value="{{ old('masa_manfaat', $asset->masa_manfaat) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Sisa Masa Manfaat (Bulan)</label>
                                    <input type="number" name="sisa_masa_manfaat" class="form-control" value="{{ old('sisa_masa_manfaat', $asset->sisa_masa_manfaat) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Intra/Ekstra</label>
                                    <input type="text" name="intra_ekstra" class="form-control" value="{{ old('intra_ekstra', $asset->intra_ekstra) }}">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Extra Info</label>
                                    <input type="text" name="extra_info" class="form-control" value="{{ old('extra_info', $asset->extra_info) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>

                <!-- 2. Status & Kondisi -->
                <h5 class="text-primary"><i class="fas fa-info-circle mr-2"></i> Kondisi & Status</h5>
                <div class="row">
                    <div class="col-md-3">
                         <div class="form-group">
                            <label>Kondisi <span class="text-danger">*</span></label>
                            <select name="kondisi" class="form-control" required>
                                <option value="Baik" {{ old('kondisi', $asset->kondisi) == 'Baik' ? 'selected' : '' }}>Baik</option>
                                <option value="Rusak Ringan" {{ old('kondisi', $asset->kondisi) == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                <option value="Rusak Berat" {{ old('kondisi', $asset->kondisi) == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Status Pemanfaatan</label>
                            <input type="text" name="status_pemanfaatan" class="form-control" value="{{ old('status_pemanfaatan', $asset->status_pemanfaatan) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Status BMN</label>
                            <input type="text" name="status_bmn" class="form-control" value="{{ old('status_bmn', $asset->status_bmn) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Status SBSN</label>
                            <input type="text" name="status_sbsn" class="form-control" value="{{ old('status_sbsn', $asset->status_sbsn) }}">
                        </div>
                    </div>
                     <div class="col-md-3">
                        <div class="form-group">
                            <label>Status Idle</label>
                            <input type="text" name="status_bmn_idle" class="form-control" value="{{ old('status_bmn_idle', $asset->status_bmn_idle) }}">
                        </div>
                    </div>
                     <div class="col-md-3">
                        <div class="form-group">
                            <label>Status Kemitraan</label>
                            <input type="text" name="status_kemitraan" class="form-control" value="{{ old('status_kemitraan', $asset->status_kemitraan) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Henti Guna</label>
                            <input type="text" name="henti_guna" class="form-control" value="{{ old('henti_guna', $asset->henti_guna) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>BPYBDS</label>
                            <input type="text" name="bpybds" class="form-control" value="{{ old('bpybds', $asset->bpybds) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Usulan Hapus</label>
                            <input type="text" name="usulan_hapus" class="form-control" value="{{ old('usulan_hapus', $asset->usulan_hapus) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Barang Hilang</label>
                            <input type="text" name="usulan_barang_hilang" class="form-control" value="{{ old('usulan_barang_hilang', $asset->usulan_barang_hilang) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Barang RB</label>
                            <input type="text" name="usulan_barang_rb" class="form-control" value="{{ old('usulan_barang_rb', $asset->usulan_barang_rb) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Prop. Investasi</label>
                            <input type="text" name="properti_investasi" class="form-control" value="{{ old('properti_investasi', $asset->properti_investasi) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Status PMK</label>
                            <input type="text" name="status_pmk" class="form-control" value="{{ old('status_pmk', $asset->status_pmk) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Usulan RB</label>
                            <input type="text" name="usulan_rusak_berat" class="form-control" value="{{ old('usulan_rusak_berat', $asset->usulan_rusak_berat) }}">
                        </div>
                    </div>
                </div>
                <hr>

                <!-- 3. Nilai & Tanggal -->
                <h5 class="text-primary"><i class="fas fa-calendar-alt mr-2"></i> Tanggal & Nilai Aset</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tgl Perolehan Pertama</label>
                                    <input type="date" name="tgl_perolehan_pertama" class="form-control" value="{{ old('tgl_perolehan_pertama', $asset->tgl_perolehan_pertama ? $asset->tgl_perolehan_pertama->format('Y-m-d') : '') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tgl Pembukuan</label>
                                    <input type="date" name="tgl_buku" class="form-control" value="{{ old('tgl_buku', $asset->tgl_buku ? $asset->tgl_buku->format('Y-m-d') : '') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tgl Buku Pertama</label>
                                    <input type="date" name="tgl_buku_pertama" class="form-control" value="{{ old('tgl_buku_pertama', $asset->tgl_buku_pertama ? $asset->tgl_buku_pertama->format('Y-m-d') : '') }}">
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tgl Pengapusan</label>
                                    <input type="date" name="tgl_pengapusan" class="form-control" value="{{ old('tgl_pengapusan', $asset->tgl_pengapusan ? $asset->tgl_pengapusan->format('Y-m-d') : '') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nilai Perolehan Pertama</label>
                                    <input type="number" name="nilai_perolehan_pertama" class="form-control" value="{{ old('nilai_perolehan_pertama', $asset->nilai_perolehan_pertama) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nilai Mutasi</label>
                                    <input type="number" name="nilai_mutasi" class="form-control" value="{{ old('nilai_mutasi', $asset->nilai_mutasi) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nilai Perolehan (Kini)</label>
                                    <input type="number" name="nilai_perolehan" class="form-control" required value="{{ old('nilai_perolehan', $asset->nilai_perolehan) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nilai Penyusutan</label>
                                    <input type="number" name="nilai_penyusutan" class="form-control" value="{{ old('nilai_penyusutan', $asset->nilai_penyusutan) }}">
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nilai Buku</label>
                                    <input type="number" name="nilai_buku" class="form-control" value="{{ old('nilai_buku', $asset->nilai_buku) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>

                <!-- 4. Spesifikasi Fisik -->
                <h5 class="text-primary"><i class="fas fa-ruler-combined mr-2"></i> Spesifikasi Fisik</h5>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Luas (m²)</label>
                            <input type="number" step="0.01" name="luas" class="form-control" value="{{ old('luas', $asset->luas) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Luas Tanah Bangunan (m²)</label>
                            <input type="number" step="0.01" name="luas_tanah_bangunan" class="form-control" value="{{ old('luas_tanah_bangunan', $asset->luas_tanah_bangunan) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Luas Tanah Sarana (m²)</label>
                            <input type="number" step="0.01" name="luas_tanah_sarana" class="form-control" value="{{ old('luas_tanah_sarana', $asset->luas_tanah_sarana) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Luas Lahan Kosong (m²)</label>
                            <input type="number" step="0.01" name="luas_lahan_kosong" class="form-control" value="{{ old('luas_lahan_kosong', $asset->luas_lahan_kosong) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Luas Bangunan (m²)</label>
                            <input type="number" step="0.01" name="luas_bangunan" class="form-control" value="{{ old('luas_bangunan', $asset->luas_bangunan) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Lahan Kosong</label>
                            <input type="text" name="lahan_kosong" class="form-control" value="{{ old('lahan_kosong', $asset->lahan_kosong) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Jumlah Lantai</label>
                            <input type="number" name="jumlah_lantai" class="form-control" value="{{ old('jumlah_lantai', $asset->jumlah_lantai) }}">
                        </div>
                    </div>
                 </div>
                 <hr>

                <!-- 5. Lokasi & Alamat -->
                <h5 class="text-primary"><i class="fas fa-map-marker-alt mr-2"></i> Lokasi & Alamat</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $asset->alamat) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Lokasi Ruang (SIMAN)</label>
                            <input type="text" name="lokasi_ruang" class="form-control" value="{{ old('lokasi_ruang', $asset->lokasi_ruang) }}">
                        </div>
                        <div class="form-group">
                            <label>Keterangan Lokasi (App)</label>
                            <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi', $asset->lokasi) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label>RT/RW</label>
                                    <input type="text" name="rt_rw" class="form-control" value="{{ old('rt_rw', $asset->rt_rw) }}">
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kelurahan/Desa</label>
                                    <input type="text" name="desa_kel" class="form-control" value="{{ old('desa_kel', $asset->desa_kel) }}">
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kecamatan</label>
                                    <input type="text" name="kecamatan" class="form-control" value="{{ old('kecamatan', $asset->kecamatan) }}">
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kab/Kota</label>
                                    <input type="text" name="kab_kota" class="form-control" value="{{ old('kab_kota', $asset->kab_kota) }}">
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label>Provinsi</label>
                                    <input type="text" name="provinsi" class="form-control" value="{{ old('provinsi', $asset->provinsi) }}">
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kode Pos</label>
                                    <input type="text" name="kode_pos" class="form-control" value="{{ old('kode_pos', $asset->kode_pos) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>

                <!-- 6. Organisasi -->
                <h5 class="text-primary"><i class="fas fa-sitemap mr-2"></i> Organisasi & Wilayah</h5>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>KPKNL</label>
                            <input type="text" name="kode_kpknl" class="form-control" placeholder="Kode" value="{{ old('kode_kpknl', $asset->kode_kpknl) }}">
                            <input type="text" name="uraian_kpknl" class="form-control mt-1" placeholder="Uraian" value="{{ old('uraian_kpknl', $asset->uraian_kpknl) }}">
                        </div>
                    </div>
                     <div class="col-md-4">
                        <div class="form-group">
                            <label>Kanwil DJKN</label>
                            <input type="text" name="uraian_kanwil" class="form-control" value="{{ old('uraian_kanwil', $asset->uraian_kanwil) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>K/L</label>
                            <input type="text" name="nama_kl" class="form-control" value="{{ old('nama_kl', $asset->nama_kl) }}">
                        </div>
                    </div>
                     <div class="col-md-4">
                        <div class="form-group">
                            <label>Eselon 1</label>
                            <input type="text" name="nama_e1" class="form-control" value="{{ old('nama_e1', $asset->nama_e1) }}">
                        </div>
                    </div>
                     <div class="col-md-4">
                        <div class="form-group">
                            <label>Korwil</label>
                            <input type="text" name="nama_korwil" class="form-control" value="{{ old('nama_korwil', $asset->nama_korwil) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nama Pengguna (SIMAN)</label>
                            <input type="text" name="nama_pengguna_siman" class="form-control" value="{{ old('nama_pengguna_siman', $asset->nama_pengguna_siman) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Jenis Identitas</label>
                            <input type="text" name="jenis_identitas" class="form-control" value="{{ old('jenis_identitas', $asset->jenis_identitas) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>No Identitas</label>
                            <input type="text" name="no_identitas" class="form-control" value="{{ old('no_identitas', $asset->no_identitas) }}">
                        </div>
                    </div>
                </div>

                <!-- 7. Legalitas -->
                <h5 class="text-primary"><i class="fas fa-gavel mr-2"></i> Legalitas</h5>
                <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                            <label>No PSP</label>
                            <input type="text" name="no_psp" class="form-control" value="{{ old('no_psp', $asset->no_psp) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                         <div class="form-group">
                            <label>Tanggal PSP</label>
                            <input type="date" name="tgl_psp" class="form-control" value="{{ old('tgl_psp', $asset->tgl_psp ? $asset->tgl_psp->format('Y-m-d') : '') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Jenis Dokumen</label>
                            <input type="text" name="jenis_dokumen" class="form-control" value="{{ old('jenis_dokumen', $asset->jenis_dokumen) }}">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>No Dokumen</label>
                            <input type="text" name="no_dokumen" class="form-control" value="{{ old('no_dokumen', $asset->no_dokumen) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tanggal Dokumen</label>
                            <input type="date" name="tgl_dokumen" class="form-control" value="{{ old('tgl_dokumen', $asset->tgl_dokumen ? $asset->tgl_dokumen->format('Y-m-d') : '') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>No BPKP</label>
                            <input type="text" name="no_bpkp" class="form-control" value="{{ old('no_bpkp', $asset->no_bpkp) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>No Polisi</label>
                            <input type="text" name="no_polisi" class="form-control" value="{{ old('no_polisi', $asset->no_polisi) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>No STNK</label>
                            <input type="text" name="no_stnk" class="form-control" value="{{ old('no_stnk', $asset->no_stnk) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Status Sertifikasi</label>
                            <input type="text" name="status_sertifikasi" class="form-control" value="{{ old('status_sertifikasi', $asset->status_sertifikasi) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Jenis Sertifikat</label>
                            <input type="text" name="jenis_sertifikat" class="form-control" value="{{ old('jenis_sertifikat', $asset->jenis_sertifikat) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>No Sertifikat</label>
                            <input type="text" name="no_sertifikat" class="form-control" value="{{ old('no_sertifikat', $asset->no_sertifikat) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nama Sertifikat</label>
                            <input type="text" name="nama_sertifikat" class="form-control" value="{{ old('nama_sertifikat', $asset->nama_sertifikat) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tgl Sertifikat</label>
                            <input type="date" name="tgl_sertifikat" class="form-control" value="{{ old('tgl_sertifikat', $asset->tgl_sertifikat ? $asset->tgl_sertifikat->format('Y-m-d') : '') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Masa Berlaku</label>
                            <input type="date" name="masa_berlaku" class="form-control" value="{{ old('masa_berlaku', $asset->masa_berlaku ? $asset->masa_berlaku->format('Y-m-d') : '') }}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Pemegang Hak (Sertifikat)</label>
                            <input type="text" name="nama_pemegang_hak" class="form-control" value="{{ old('nama_pemegang_hak', $asset->nama_pemegang_hak) }}">
                        </div>
                    </div>
                </div>

                <!-- 8. Lainnya -->
                <h5 class="text-primary"><i class="fas fa-box-open mr-2"></i> Lainnya</h5>
                <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                            <label>Cara Perolehan</label>
                            <input type="text" name="cara_perolehan" class="form-control" value="{{ old('cara_perolehan', $asset->cara_perolehan) }}">
                        </div>
                    </div>
                     <div class="col-md-6">
                        <div class="form-group">
                            <label>No Bukti</label>
                            <input type="text" name="no_bukti" class="form-control" value="{{ old('no_bukti', $asset->no_bukti) }}">
                        </div>
                    </div>
                     <div class="col-md-12">
                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan', $asset->keterangan) }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                         <div class="form-group">
                            <label>Foto Aset</label>
                            @if($asset->photo)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $asset->photo) }}" alt="Current Photo" style="max-height: 100px">
                                </div>
                            @endif
                            <input type="file" name="photo" class="form-control-file">
                        </div>
                    </div>
                </div>

            </div>
            
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('assets.index') }}" class="btn btn-default">Kembali</a>
            </div>
        </form>
    </div>
@stop
