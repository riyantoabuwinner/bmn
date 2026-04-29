<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class AssetSimanTemplateExport implements FromArray, WithHeadings, WithTitle
{
    public function array(): array
    {
        // Return an empty row or sample data
        return [
            [
                'Tanah', // jenis_bmn
                '123456', // kode_satker
                'Nama Satker Contoh', // nama_satker
                '2.01.01.01.001', // kode_barang
                '1', // nup
                'Tanah Bangunan Kantor', // nama_barang
                '-', // merk
                '-', // tipe
                'Baik', // kondisi
                '10', // umur_aset
                'Intra', // intra_ekstra
                '1', // kuantitas
                'Unit', // satuan
                '100000000', // nilai_perolehan_pertama_rp
                '10000000', // akumulasi_penyusutan_rp
                '90000000', // nilai_buku_rp
                '2020-01-01', // tanggal_perolehan_pertama
                '2020-01-02', // tanggal_buku
                '10', // masa_manfaat
                '5', // sisa_masa_manfaat
                'DOC-123', // no_dokumen
                '2020-01-01', // tgl_dokumen
                'PSP-123', // no_psp
                '2020-01-01', // tgl_psp
                'Tidak', // status_sbsn
                'Tidak', // status_bmn_idle
                'Tidak', // status_kemitraan
                '-', // bpybds
                'Tidak', // usulan_barang_hilang
                'Tidak', // usulan_barang_rb
                'Tidak', // usulan_rusak_berat
                'Tidak', // usulan_hapus
                'SERT-123', // no_sertifikat
                'Sertifikat Tanah', // nama_sertifikat
                '2020-01-01', // tgl_sertifikat
                '2030-01-01', // masa_berlaku
                'Kementerian', // nama_pemegang_hak
                'Jl. Contoh No. 1', // alamat
                '01/02', // rt_rw
                'Kelurahan', // desa_kel
                'Kecamatan', // kecamatan
                'Kabupaten', // kab_kota
                'Provinsi', // provinsi
                '100', // luas
                '0', // luas_bangunan
                '0', // luas_tapak_bangunan
                '0', // luas_pemanfaatan
                '0', // jumlah_lantai
                '1', // jumlah_foto
                'Digunakan', // status_pemanfaatan
                '-', // lahan_kosong
                'Catatan contoh', // keterangan
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'jenis_bmn',
            'kode_satker',
            'nama_satker',
            'kode_barang',
            'nup',
            'nama_barang',
            'merk',
            'tipe',
            'kondisi',
            'umur_aset',
            'intra_ekstra',
            'kuantitas',
            'satuan',
            'nilai_perolehan_pertama_rp',
            'akumulasi_penyusutan_rp',
            'nilai_buku_rp',
            'tanggal_perolehan_pertama',
            'tanggal_buku',
            'masa_manfaat',
            'sisa_masa_manfaat',
            'no_dokumen',
            'tgl_dokumen',
            'no_psp',
            'tgl_psp',
            'status_sbsn',
            'status_bmn_idle',
            'status_kemitraan',
            'bpybds',
            'usulan_barang_hilang',
            'usulan_barang_rb',
            'usulan_rusak_berat',
            'usulan_hapus',
            'no_sertifikat',
            'nama_sertifikat',
            'tgl_sertifikat',
            'masa_berlaku',
            'nama_pemegang_hak',
            'alamat',
            'rt_rw',
            'kelurahan_desa',
            'kecamatan',
            'kab_kota',
            'provinsi',
            'luas_m2',
            'luas_bangunan',
            'luas_tapak_bangunan',
            'luas_pemanfaatan',
            'jumlah_lantai',
            'jumlah_foto',
            'status_pemanfaatan',
            'lahan_kosong',
            'keterangan'
        ];
    }

    public function title(): string
    {
        return 'Template Import SIMAN v2';
    }
}
