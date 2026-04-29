<?php

namespace App\Exports;

use App\Models\Asset;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AssetsExport implements FromQuery, WithHeadings, WithMapping
{

    public function query()
    {
        return Asset::query();
    }

    public function headings(): array
    {
        return [
            'Kode Satker', 'Nama Satker', 'Kode Barang', 'Nama Barang', 'NUP', 'Merk', 'Tipe', 'Kondisi', 'Intra/Ekstra', 'Status Pemanfaatan',
            'Status BMN', 'Status SBSN', 'Status BMN Idle', 'Status Kemitraan', 'Henti Guna', 'BPYBDS',
            'Tgl Perolehan Pertama', 'Tgl Pembukuan', 'Tgl Buku Pertama', 'Tgl Penghapusan', 'Tgl PSP', 
            'Nilai Perolehan Pertama', 'Nilai Mutasi', 'Nilai Perolehan', 'Nilai Penyusutan', 'Nilai Buku', 'Akumulasi Penyusutan',
            'Kuantitas', 'Satuan', 'Luas (m2)', 'Luas Tanah Bangunan', 'Luas Tanah Sarana', 'Luas Lahan Kosong', 'Lahan Kosong', 'Luas Bangunan', 'Jumlah Lantai',
            'Lokasi', 'Alamat', 'RT/RW', 'Desa/Kel', 'Kecamatan', 'Kab/Kota', 'Provinsi', 'Kode Pos',
            'Masa Manfaat', 'Sisa Masa Manfaat', 'No PSP', 'Jenis Dokumen', 'No Dokumen', 'Tgl Dokumen', 'No BPKP', 'No Polisi', 'No STNK',
            'Status Sertifikasi', 'Jenis Sertifikat', 'No Sertifikat', 'Nama Sertifikat', 'Tgl Sertifikat', 'Masa Berlaku', 'Nama Pemegang Hak',
            'Kode KPKNL', 'Uraian KPKNL', 'Uraian Kanwil', 'Nama KL', 'Nama E1', 'Nama Korwil', 'Nama Pengguna SIMAN', 'Kode Register', 'Cara Perolehan', 'No Bukti', 'Keterangan',
            'Usulan Hilang', 'Usulan RB (Lama)', 'Usulan RB (Barang)', 'Usulan Hapus', 'Hibah DKTP', 'Konsensi Jasa', 'Properti Investasi',
            'QR Code', 'Unique ID'
        ];
    }

    public function map($asset): array
    {
        return [
            $asset->kode_satker,
            $asset->nama_satker,
            $asset->kode_barang,
            $asset->nama_barang,
            $asset->nup,
            $asset->merk,
            $asset->tipe,
            $asset->kondisi,
            $asset->intra_ekstra,
            $asset->status_pemanfaatan,
            $asset->status_bmn,
            $asset->status_sbsn,
            $asset->status_bmn_idle,
            $asset->status_kemitraan,
            $asset->henti_guna,
            $asset->bpybds,
            $asset->tgl_perolehan_pertama ? $asset->tgl_perolehan_pertama->format('Y-m-d') : null,
            $asset->tgl_buku ? $asset->tgl_buku->format('Y-m-d') : null,
            $asset->tgl_buku_pertama ? $asset->tgl_buku_pertama->format('Y-m-d') : null,
            $asset->tgl_pengapusan ? $asset->tgl_pengapusan->format('Y-m-d') : null,
            $asset->tgl_psp ? $asset->tgl_psp->format('Y-m-d') : null,
            $asset->nilai_perolehan_pertama,
            $asset->nilai_mutasi,
            $asset->nilai_perolehan,
            $asset->nilai_penyusutan,
            $asset->nilai_buku,
            $asset->akumulasi_penyusutan,
            $asset->kuantitas,
            $asset->satuan,
            $asset->luas,
            $asset->luas_tanah_bangunan,
            $asset->luas_tanah_sarana,
            $asset->luas_lahan_kosong,
            $asset->lahan_kosong,
            $asset->luas_bangunan,
            $asset->jumlah_lantai,
            $asset->lokasi,
            $asset->alamat,
            $asset->rt_rw,
            $asset->desa_kel,
            $asset->kecamatan,
            $asset->kab_kota,
            $asset->provinsi,
            $asset->kode_pos,
            $asset->masa_manfaat,
            $asset->sisa_masa_manfaat,
            $asset->no_psp,
            $asset->jenis_dokumen,
            $asset->no_dokumen,
            $asset->tgl_dokumen ? $asset->tgl_dokumen->format('Y-m-d') : null,
            $asset->no_bpkp,
            $asset->no_polisi,
            $asset->no_stnk,
            $asset->status_sertifikasi,
            $asset->jenis_sertifikat,
            $asset->no_sertifikat,
            $asset->nama_sertifikat,
            $asset->tgl_sertifikat ? $asset->tgl_sertifikat->format('Y-m-d') : null,
            $asset->masa_berlaku ? $asset->masa_berlaku->format('Y-m-d') : null,
            $asset->nama_pemegang_hak,
            $asset->kode_kpknl,
            $asset->uraian_kpknl,
            $asset->uraian_kanwil,
            $asset->nama_kl,
            $asset->nama_e1,
            $asset->nama_korwil,
            $asset->nama_pengguna_siman,
            $asset->kode_register,
            $asset->cara_perolehan,
            $asset->no_bukti,
            $asset->keterangan,
            $asset->usulan_barang_hilang,
            $asset->usulan_barang_rb,
            $asset->usulan_rusak_berat,
            $asset->usulan_hapus,
            $asset->hibah_dktp,
            $asset->konsensi_jasa,
            $asset->properti_investasi,
            $asset->qr_code,
            $asset->unique_asset_id,
        ];
    }
}
