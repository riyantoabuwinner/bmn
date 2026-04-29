<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();

            // Identitas Satker
            $table->string('kode_satker')->nullable()->index();
            $table->string('nama_satker')->nullable();

            // Identitas Barang
            $table->string('kode_barang')->index();
            $table->string('nama_barang');
            $table->integer('nup');
            $table->string('merk_type')->nullable(); // Merk/Tipe

            // Kondisi & Status
            $table->string('kondisi')->default('Baik'); // Baik, Rusak Ringan, Rusak Berat
            $table->string('status_penggunaan')->nullable(); // Digunakan Sendiri, Pinjam Pakai, dll

            // New SIMAN Fields - Status
            $table->string('status_bmn')->nullable(); // Status BMN
            $table->string('status_sbsn')->nullable();
            $table->string('status_bmn_idle')->nullable();
            $table->string('status_kemitraan')->nullable();
            $table->string('tuntutan_ganti_rugi')->nullable(); // TGR

            // Nilai & Tanggal
            $table->date('tgl_perolehan')->nullable();
            $table->date('tgl_pembukuan')->nullable();
            $table->date('tgl_buku_pertama')->nullable(); // Tanggal Buku Pertama
            $table->date('tgl_reval')->nullable(); // Tanggal Revaluasi if needed
            $table->date('tgl_pengapusan')->nullable(); // Tanggal Pengapusan

            $table->decimal('nilai_perolehan_pertama', 15, 2)->default(0); // Nilai Perolehan Pertama
            $table->decimal('nilai_mutasi', 15, 2)->default(0); // Nilai Mutasi
            $table->decimal('nilai_perolehan', 15, 2)->default(0); // Nilai Perolehan Current
            $table->decimal('nilai_penyusutan', 15, 2)->default(0); // Nilai Penyusutan
            $table->decimal('nilai_buku', 15, 2)->default(0); // Nilai Buku

            // Aliases or standardized names
            $table->decimal('book_value', 15, 2)->default(0); // Mirror of nilai_buku for app logic
            $table->decimal('depreciation_value', 15, 2)->default(0); // Mirror of nilai_penyusutan
            $table->decimal('accumulated_depreciation', 15, 2)->default(0);

            // Fisik - Luas Detail
            $table->integer('kuantitas')->default(1);
            $table->string('satuan')->default('Unit');

            $table->decimal('luas_tanah_seluruhnya', 15, 2)->default(0);
            $table->decimal('luas_tanah_bangunan', 15, 2)->default(0);
            $table->decimal('luas_tanah_sarana', 15, 2)->default(0); // Luas Tanah Untuk Sarana Lingkungan
            $table->decimal('luas_lahan_kosong', 15, 2)->default(0);

            $table->decimal('luas_bangunan', 15, 2)->default(0);
            $table->decimal('luas_tapak_bangunan', 15, 2)->default(0);
            $table->decimal('luas_pemanfaatan', 15, 2)->default(0);

            // Common logical fields used in app
            $table->decimal('surface_area', 15, 2)->nullable(); // Total Land Area (Mirror)
            $table->decimal('building_area', 15, 2)->nullable(); // Building Area (Mirror)

            $table->integer('floors')->default(0); // Jumlah Lantai
            $table->integer('jumlah_foto')->default(0); // Jumlah Foto

            // Lokasi Detail
            $table->string('lokasi')->nullable(); // Lokasi fisik / Ruangan (Legacy/Simple)
            $table->string('alamat')->nullable(); // Alamat
            $table->string('rt_rw')->nullable();
            $table->string('desa_kel')->nullable(); // Kelurahan/Desa
            $table->string('kecamatan')->nullable();
            $table->string('kab_kota')->nullable();
            $table->string('kode_kab_kota')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kode_provinsi')->nullable();
            $table->string('kode_pos')->nullable();

            // Legal & Admin
            $table->integer('economic_life')->default(0); // Umur Aset
            $table->string('no_psp')->nullable(); // No PSP
            $table->date('tgl_psp')->nullable(); // Tanggal PSP
            $table->string('no_sip')->nullable(); // No SIP/No Polisi/etc (Generic)

            // Hierarki & Organisasi
            $table->string('sbsk')->nullable();
            $table->string('optimalisasi')->nullable();
            $table->string('penghuni')->nullable();
            $table->string('pengguna')->nullable(); // Pengguna Barang

            $table->string('kode_kpknl')->nullable();
            $table->string('uraian_kpknl')->nullable();
            $table->string('uraian_kanwil')->nullable();

            $table->string('nama_kl')->nullable();
            $table->string('nama_e1')->nullable();
            $table->string('nama_korwil')->nullable();

            $table->string('kode_register')->nullable(); // Unclear if different from NUP, keeping.

            // Tambahan App
            $table->string('cara_perolehan')->nullable();
            $table->string('no_bukti')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('photo')->nullable();
            $table->string('qr_code')->nullable()->unique();

            // Relationships
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('asset_categories')->nullOnDelete();
            $table->foreignId('location_id')->nullable()->constrained('asset_locations')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
