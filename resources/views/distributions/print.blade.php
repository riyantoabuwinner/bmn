<!DOCTYPE html>
<html>
<head>
    <title>Berita Acara Distribusi Aset</title>
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
        <h2>BERITA ACARA DISTRIBUSI ASET</h2>
        <p>Nomor: DIST/{{ date('Y') }}/{{ $distribution->id }}</p>
    </div>

    <div class="content">
        <p>Pada hari ini, <strong>{{ \Carbon\Carbon::parse($distribution->distribution_date)->isoFormat('dddd') }}</strong>, tanggal <strong>{{ \Carbon\Carbon::parse($distribution->distribution_date)->isoFormat('D MMMM Y') }}</strong>, telah dilakukan distribusi aset BMN sebagai berikut:</p>

        <table class="table">
            <tr>
                <td style="width: 200px; background-color: #f0f0f0;"><strong>Satuan Kerja (Unit)</strong></td>
                <td>{{ $distribution->unit->name }}</td>
            </tr>
            <tr>
                <td style="background-color: #f0f0f0;"><strong>Penerima</strong></td>
                <td>{{ $distribution->recipient_name }}</td>
            </tr>
            <tr>
                <td style="background-color: #f0f0f0;"><strong>Jabatan</strong></td>
                <td>{{ $distribution->recipient_position }}</td>
            </tr>
        </table>

        <p>Rincian Aset:</p>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>NUP</th>
                    <th>Merk/Tipe</th>
                    <th>Tahun</th>
                    <th>Kondisi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>{{ $distribution->asset->kode_barang }}</td>
                    <td>{{ $distribution->asset->nama_barang }}</td>
                    <td>{{ $distribution->asset->nup }}</td>
                    <td>{{ $distribution->asset->merk_type ?? '-' }}</td>
                    <td>{{ $distribution->asset->tgl_perolehan ? $distribution->asset->tgl_perolehan->format('Y') : '-' }}</td>
                    <td>{{ $distribution->asset->kondisi }}</td>
                </tr>
            </tbody>
        </table>

        <p>Aset tersebut diserahkan dalam keadaan baik dan lengkap untuk digunakan sebagaimana mestinya dalam mendukung kegiatan operasional unit kerja.</p>
        
        @if($distribution->notes)
        <p><strong>Catatan:</strong> {{ $distribution->notes }}</p>
        @endif
    </div>

    <div class="footer">
        <div class="signature">
            <p>Yang Menyerahkan,<br>Petugas BMN</p>
            <br><br><br>
            <p>( ...................................... )</p>
        </div>
        <div class="signature">
            <p>Yang Menerima,<br>{{ $distribution->recipient_position }}</p>
            <br><br><br>
            <p><strong>{{ $distribution->recipient_name }}</strong></p>
        </div>
    </div>
</body>
</html>
