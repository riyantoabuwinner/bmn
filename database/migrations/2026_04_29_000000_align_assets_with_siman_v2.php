<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, convert some existing string columns to text to avoid "Row size too large" error
        Schema::table('assets', function (Blueprint $table) {
            $toText = [
                'nama_satker', 'nama_barang', 'status_bmn', 'status_sbsn', 
                'status_bmn_idle', 'status_kemitraan', 'satuan', 'lokasi', 
                'alamat', 'rt_rw', 'desa_kel', 'kecamatan', 'kab_kota', 
                'provinsi', 'sbsk', 'optimalisasi', 'penghuni', 'pengguna',
                'kode_kpknl', 'uraian_kpknl', 'uraian_kanwil', 'nama_kl', 
                'nama_e1', 'nama_korwil', 'kode_register'
            ];

            foreach ($toText as $col) {
                if (Schema::hasColumn('assets', $col)) {
                    $table->text($col)->nullable()->change();
                }
            }
        });

        Schema::table('assets', function (Blueprint $table) {
            // Renaming existing columns to match SIMAN v2 labels
            if (Schema::hasColumn('assets', 'accumulated_depreciation')) {
                $table->renameColumn('accumulated_depreciation', 'akumulasi_penyusutan');
            }
            if (Schema::hasColumn('assets', 'tgl_perolehan')) {
                $table->renameColumn('tgl_perolehan', 'tgl_perolehan_pertama');
            }
            if (Schema::hasColumn('assets', 'tgl_pembukuan')) {
                $table->renameColumn('tgl_pembukuan', 'tgl_buku');
            }
            if (Schema::hasColumn('assets', 'economic_life')) {
                $table->renameColumn('economic_life', 'masa_manfaat');
            }
            if (Schema::hasColumn('assets', 'usul_hapus')) {
                $table->renameColumn('usul_hapus', 'usulan_hapus');
            }
            if (Schema::hasColumn('assets', 'nama_pemilik')) {
                $table->renameColumn('nama_pemilik', 'nama_sertifikat');
            }
            if (Schema::hasColumn('assets', 'luas_tanah_seluruhnya')) {
                $table->renameColumn('luas_tanah_seluruhnya', 'luas');
            }
            if (Schema::hasColumn('assets', 'floors')) {
                $table->renameColumn('floors', 'jumlah_lantai');
            }
            if (Schema::hasColumn('assets', 'status_penggunaan')) {
                $table->renameColumn('status_penggunaan', 'status_pemanfaatan');
            }

            // Adding missing columns as TEXT to save row space
            $table->text('merk')->nullable()->after('nup');
            $table->text('tipe')->nullable()->after('merk');
            $table->text('intra_ekstra')->nullable()->after('kondisi');
            $table->integer('sisa_masa_manfaat')->nullable()->after('masa_manfaat');
            $table->date('tgl_dokumen')->nullable()->after('no_dokumen');
            $table->text('usulan_rusak_berat')->nullable()->after('usulan_barang_rb');
            $table->date('tgl_sertifikat')->nullable()->after('no_sertifikat');
            $table->date('masa_berlaku')->nullable()->after('tgl_sertifikat');
            $table->text('nama_pemegang_hak')->nullable()->after('masa_berlaku');
            $table->text('lahan_kosong')->nullable()->after('status_pemanfaatan');
        });

        // Data Migration: Split merk_type into merk and tipe if exists
        if (Schema::hasColumn('assets', 'merk_type')) {
            DB::table('assets')->whereNotNull('merk_type')->chunkById(100, function ($assets) {
                foreach ($assets as $asset) {
                    $parts = explode('/', $asset->merk_type, 2);
                    DB::table('assets')->where('id', $asset->id)->update([
                        'merk' => $parts[0] ?? null,
                        'tipe' => $parts[1] ?? null,
                    ]);
                }
            });

            Schema::table('assets', function (Blueprint $table) {
                $table->dropColumn('merk_type');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert some columns back to string if needed, but keeping them as text is safer
        
        Schema::table('assets', function (Blueprint $table) {
            $table->string('merk_type')->nullable()->after('nup');
        });

        // Inverse Data Migration
        DB::table('assets')->chunkById(100, function ($assets) {
            foreach ($assets as $asset) {
                $merkType = trim(($asset->merk ?? '') . '/' . ($asset->tipe ?? ''), '/');
                DB::table('assets')->where('id', $asset->id)->update([
                    'merk_type' => $merkType ?: null,
                ]);
            }
        });

        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn([
                'merk', 'tipe', 'intra_ekstra', 'sisa_masa_manfaat', 'tgl_dokumen',
                'usulan_rusak_berat', 'tgl_sertifikat', 'masa_berlaku', 'nama_pemegang_hak', 'lahan_kosong'
            ]);

            $table->renameColumn('akumulasi_penyusutan', 'accumulated_depreciation');
            $table->renameColumn('tgl_perolehan_pertama', 'tgl_perolehan');
            $table->renameColumn('tgl_buku', 'tgl_pembukuan');
            $table->renameColumn('masa_manfaat', 'economic_life');
            $table->renameColumn('usulan_hapus', 'usul_hapus');
            $table->renameColumn('nama_sertifikat', 'nama_pemilik');
            $table->renameColumn('luas', 'luas_tanah_seluruhnya');
            $table->renameColumn('jumlah_lantai', 'floors');
            $table->renameColumn('status_pemanfaatan', 'status_penggunaan');
        });
    }
};
