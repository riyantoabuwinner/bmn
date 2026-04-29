<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pemeliharaan Aset</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; }
        .header p { margin: 5px 0; }
        .content { margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #000; padding: 5px; }
        .footer { width: 100%; margin-top: 50px; }
        .signature { width: 45%; display: inline-block; vertical-align: top; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN PEMELIHARAAN ASET</h2>
        <p>Nomor: MAINT/{{ date('Y') }}/{{ $maintenance->id }}</p>
    </div>

    <div class="content">
        <h3>I. Informasi Aset</h3>
        <table class="table">
            <tr>
                <td style="width: 150px; background-color: #f0f0f0;"><strong>Kode Barang</strong></td>
                <td>{{ $maintenance->asset->kode_barang }}</td>
            </tr>
            <tr>
                <td style="background-color: #f0f0f0;"><strong>Nama Barang</strong></td>
                <td>{{ $maintenance->asset->nama_barang }}</td>
            </tr>
            <tr>
                <td style="background-color: #f0f0f0;"><strong>NUP</strong></td>
                <td>{{ $maintenance->asset->nup }}</td>
            </tr>
            <tr>
                <td style="background-color: #f0f0f0;"><strong>Kondisi Awal</strong></td>
                <td>{{ $maintenance->condition_before }}</td>
            </tr>
        </table>

        <h3>II. Detail Pemeliharaan</h3>
        <table class="table">
             <tr>
                <td style="width: 150px; background-color: #f0f0f0;"><strong>Jenis Pemeliharaan</strong></td>
                <td>{{ ucfirst($maintenance->maintenance_type) }}</td>
            </tr>
            <tr>
                <td style="background-color: #f0f0f0;"><strong>Tanggal Jadwal</strong></td>
                <td>{{ \Carbon\Carbon::parse($maintenance->scheduled_date)->format('d F Y') }}</td>
            </tr>
             <tr>
                <td style="background-color: #f0f0f0;"><strong>Status</strong></td>
                <td>{{ ucfirst(str_replace('_', ' ', $maintenance->status)) }}</td>
            </tr>
             <tr>
                <td style="background-color: #f0f0f0;"><strong>Deskripsi Masalah</strong></td>
                <td>{{ $maintenance->description }}</td>
            </tr>
        </table>

        @if($maintenance->status == 'selesai')
        <h3>III. Hasil Pemeliharaan</h3>
        <table class="table">
            <tr>
                <td style="width: 150px; background-color: #f0f0f0;"><strong>Tanggal Selesai</strong></td>
                <td>{{ $maintenance->completion_date ? \Carbon\Carbon::parse($maintenance->completion_date)->format('d F Y') : '-' }}</td>
            </tr>
             <tr>
                <td style="background-color: #f0f0f0;"><strong>Kondisi Akhir</strong></td>
                <td>{{ $maintenance->condition_after }}</td>
            </tr>
             <tr>
                <td style="background-color: #f0f0f0;"><strong>Biaya Aktual</strong></td>
                <td>Rp {{ number_format($maintenance->actual_cost, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="background-color: #f0f0f0;"><strong>Catatan Penyelesaian</strong></td>
                <td>{{ $maintenance->completion_notes }}</td>
            </tr>
        </table>
        @endif
    </div>

    <div class="footer">
        <div class="signature">
            <p>Mengetahui,<br>Kepala Unit/Satker</p>
            <br><br><br>
            <p>( ...................................... )</p>
        </div>
        <div class="signature">
            <p>Pelaksana / Teknisi</p>
            <br><br><br>
            <p>( ...................................... )</p>
        </div>
    </div>
</body>
</html>
