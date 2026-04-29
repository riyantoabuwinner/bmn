<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Asset extends Model
{
    protected $fillable = [
        'unique_asset_id', // SIMAN Persistent Unique ID
        'kode_satker', 'nama_satker',
        'kode_barang', 'nama_barang', 'jenis_bmn', 'nup', 
        'merk', 'tipe', // New split fields
        'kondisi', 'intra_ekstra', 'status_pemanfaatan',
        'tgl_perolehan_pertama', 'tgl_buku',
        'nilai_perolehan_pertama', 'akumulasi_penyusutan', 'nilai_buku',
        'kuantitas', 'satuan',
        'lokasi', 'alamat', 'rt_rw', 'desa_kel', 'kecamatan', 'kab_kota', 'provinsi',
        'masa_manfaat', 'sisa_masa_manfaat',
        'no_dokumen', 'tgl_dokumen',
        'no_psp', 'tgl_psp',
        'status_sbsn', 'status_bmn_idle', 'status_kemitraan',
        'bpybds', 'usulan_barang_hilang', 'usulan_barang_rb', 'usulan_rusak_berat', 'usulan_hapus',
        'no_sertifikat', 'nama_sertifikat', 'tgl_sertifikat', 'masa_berlaku', 'nama_pemegang_hak',
        'luas', 'luas_bangunan', 'luas_tapak_bangunan', 'luas_pemanfaatan', 'lahan_kosong',
        'jumlah_lantai', 'jumlah_foto', 'keterangan',
        'photo', 'qr_code',
        'unit_id', 'category_id', 'location_id',

        // Additional Metadata & App specific
        'status_bmn', 'tgl_buku_pertama', 'tgl_pengapusan',
        'nilai_mutasi', 'nilai_penyusutan',
        'sbsk', 'optimalisasi', 'penghuni', 'pengguna',
        'kode_kpknl', 'uraian_kpknl', 'uraian_kanwil',
        'nama_kl', 'nama_e1', 'nama_korwil',
        'kode_register', 'sip_number',
        'last_inventory_at', 'extra_info',
        'jenis_dokumen', 'no_bpkp', 'no_polisi',
        'status_sertifikasi', 'jenis_sertifikat', 'no_stnk', 'status_pmk',
        'henti_guna', 'hibah_dktp', 'konsensi_jasa', 'properti_investasi',
        'lokasi_ruang', 'jenis_identitas', 'no_identitas', 'nama_pengguna_siman',
        'umur_aset'
    ];

    protected $casts = [
        'tgl_perolehan_pertama' => 'date',
        'tgl_buku' => 'date',
        'tgl_dokumen' => 'date',
        'tgl_psp' => 'date',
        'tgl_sertifikat' => 'date',
        'masa_berlaku' => 'date',
        'last_inventory_at' => 'datetime',
        'nilai_perolehan_pertama' => 'decimal:2',
        'akumulasi_penyusutan' => 'decimal:2',
        'nilai_buku' => 'decimal:2',
        'nilai_mutasi' => 'decimal:2',
        'nilai_penyusutan' => 'decimal:2',
        'luas' => 'decimal:2',
        'luas_bangunan' => 'decimal:2',
        'luas_tapak_bangunan' => 'decimal:2',
        'luas_pemanfaatan' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->unique_asset_id)) {
                $model->unique_asset_id = 'BMN-' . strtoupper(Str::random(8)) . '-' . date('Y');
            }
        });
    }

    // Relationships

    public function category()
    {
        return $this->belongsTo(AssetCategory::class);
    }

    public function maintenances()
    {
        return $this->hasMany(RkbmnMaintenance::class);
    }

    public function utilizations()
    {
        return $this->hasMany(AssetUtilization::class);
    }

}
