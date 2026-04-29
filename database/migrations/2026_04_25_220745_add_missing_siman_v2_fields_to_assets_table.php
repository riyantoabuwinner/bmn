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
        Schema::table('assets', function (Blueprint $table) {
            $cols = [
                'jenis_dokumen' => ['type' => 'text'],
                'no_dokumen' => ['type' => 'text'],
                'no_bpkp' => ['type' => 'text'],
                'no_polisi' => ['type' => 'text'],
                'status_sertifikasi' => ['type' => 'text'],
                'jenis_sertifikat' => ['type' => 'text'],
                'no_sertifikat' => ['type' => 'text'],
                'nama_pemilik' => ['type' => 'text'],
                'no_stnk' => ['type' => 'text'],
                'status_pmk' => ['type' => 'text'],
                'henti_guna' => ['type' => 'text'],
                'bpybds' => ['type' => 'text'],
                'usulan_barang_hilang' => ['type' => 'text'],
                'usulan_barang_rb' => ['type' => 'text'],
                'usul_hapus' => ['type' => 'text'],
                'hibah_dktp' => ['type' => 'text'],
                'konsensi_jasa' => ['type' => 'text'],
                'properti_investasi' => ['type' => 'text'],
                'lokasi_ruang' => ['type' => 'text'],
                'jenis_identitas' => ['type' => 'text'],
                'no_identitas' => ['type' => 'text'],
                'nama_pengguna_siman' => ['type' => 'text'],
                'umur_aset' => ['type' => 'text'],
                'extra_info' => ['type' => 'text'],
            ];

            foreach ($cols as $col => $attr) {
                if (!Schema::hasColumn('assets', $col)) {
                    if ($attr['type'] === 'string') {
                        $table->string($col, $attr['length'])->nullable();
                    } else {
                        $table->text($col)->nullable();
                    }
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn([
                'jenis_dokumen', 'no_dokumen', 'no_bpkp', 'no_polisi',
                'status_sertifikasi', 'jenis_sertifikat', 'no_sertifikat', 'nama_pemilik', 'no_stnk', 'status_pmk',
                'henti_guna', 'bpybds', 'usulan_barang_hilang', 'usulan_barang_rb', 'usul_hapus', 'hibah_dktp', 'konsensi_jasa', 'properti_investasi',
                'lokasi_ruang', 'jenis_identitas', 'no_identitas', 'nama_pengguna_siman',
                'umur_aset', 'extra_info'
            ]);
        });
    }
};
