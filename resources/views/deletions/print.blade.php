<!DOCTYPE html>
<html>
<head>
    <title>Berita Acara Penghapusan Aset</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; }
        .header p { margin: 5px 0; }
        .content { margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #000; padding: 5px; }
        .footer { width: 100%; margin-top: 50px; }
        .signature { width: 30%; display: inline-block; vertical-align: top; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h2>BERITA ACARA PENGHAPUSAN BARANG MILIK NEGARA</h2>
        <p>Nomor: DEL/{{ date('Y') }}/{{ $deletion->id }}</p>
    </div>

    <div class="content">
        <p>Pada hari ini, <strong>{{ $deletion->approved_at ? \Carbon\Carbon::parse($deletion->approved_at)->isoFormat('dddd') : '..........' }}</strong>, tanggal <strong>{{ $deletion->approved_at ? \Carbon\Carbon::parse($deletion->approved_at)->isoFormat('D MMMM Y') : '..........' }}</strong>, kami yang bertanda tangan di bawah ini:</p>

        <p>Telah melakukan penghapusan Barang Milik Negara (BMN) berdasarkan Surat Keputusan Nomor ................................... tanggal ................................... dengan rincian sebagai berikut:</p>

        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>NUP</th>
                    <th>Tahun</th>
                    <th>Kondisi Terakhir</th>
                    <th>Alasan Penghapusan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>{{ $deletion->asset->kode_barang }}</td>
                    <td>{{ $deletion->asset->nama_barang }}</td>
                    <td>{{ $deletion->asset->nup }}</td>
                    <td>{{ $deletion->asset->tgl_perolehan ? $deletion->asset->tgl_perolehan->format('Y') : '-' }}</td>
                    <td>{{ $deletion->asset->kondisi }}</td>
                    <td>{{ $deletion->reason }}</td>
                </tr>
            </tbody>
        </table>

        <p>Barang tersebut telah diperiksa dan dinyatakan tidak dapat digunakan lagi / hilang / rusak berat, sehingga perlu dihapuskan dari Daftar Barang Milik Negara.</p>
        
        <p>Demikian Berita Acara ini dibuat dengan sesungguhnya untuk dipergunakan sebagaimana mestinya.</p>
    </div>

    <div class="footer">
        <div style="text-align: center; width: 100%;">
            <div class="signature">
                <p>Mengetahui,</p>
                <p>Kepala Unit/Satker</p>
                <br><br><br>
                <p>( ........................... )</p>
            </div>
            <div class="signature">
                <p>Penyimpan Barang</p>
                <br><br><br>
                <p>( ........................... )</p>
            </div>
            <div class="signature">
                <p>Tim Penghapusan</p>
                <br><br><br>
                <p>( ........................... )</p>
            </div>
        </div>
    </div>
</body>
</html>
