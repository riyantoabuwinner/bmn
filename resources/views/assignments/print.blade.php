<!DOCTYPE html>
<html>
<head>
    <title>Berita Acara Serah Terima Aset</title>
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
        <h2>BERITA ACARA SERAH TERIMA ASET</h2>
        <p>Nomor: BAST/{{ date('Y') }}/{{ $assignment->id }}</p>
    </div>

    <div class="content">
        <p>Pada hari ini, <strong>{{ \Carbon\Carbon::parse($assignment->assigned_date)->isoFormat('dddd') }}</strong>, tanggal <strong>{{ \Carbon\Carbon::parse($assignment->assigned_date)->isoFormat('D MMMM Y') }}</strong>, yang bertanda tangan di bawah ini:</p>

        <p>1. <strong>Pihak Pertama (Yang Menyerahkan):</strong></p>
        <table style="width: 100%; border: none;">
            <tr><td style="width: 150px; border: none;">Nama</td><td style="border: none;">: Administrator BMN</td></tr>
            <tr><td style="border: none;">Jabatan</td><td style="border: none;">: Pengelola Aset</td></tr>
        </table>

        <p>2. <strong>Pihak Kedua (Yang Menerima):</strong></p>
        <table style="width: 100%; border: none;">
            <tr><td style="width: 150px; border: none;">Nama</td><td style="border: none;">: {{ $assignment->employee_name }}</td></tr>
            <tr><td style="border: none;">NIP/NIK</td><td style="border: none;">: {{ $assignment->employee_id_number ?? '-' }}</td></tr>
            <tr><td style="border: none;">Jabatan/Unit</td><td style="border: none;">: {{ $assignment->position ?? '-' }} / {{ $assignment->department ?? '-' }}</td></tr>
        </table>

        <p>Telah melakukan serah terima Barang Milik Negara (BMN) dengan rincian sebagai berikut:</p>

        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>NUP</th>
                    <th>Merk/Tipe</th>
                    <th>Kondisi</th>
                    <th>Tahun</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>{{ $assignment->asset->kode_barang }}</td>
                    <td>{{ $assignment->asset->nama_barang }}</td>
                    <td>{{ $assignment->asset->nup }}</td>
                    <td>{{ $assignment->asset->merk_type ?? '-' }}</td>
                    <td>{{ $assignment->condition_on_assign }}</td>
                    <td>{{ $assignment->asset->tgl_perolehan ? $assignment->asset->tgl_perolehan->format('Y') : '-' }}</td>
                </tr>
            </tbody>
        </table>

        <p>Selanjutnya Pihak Kedua bertanggung jawab penuh atas pemeliharaan dan keamanan barang tersebut. Apabila terjadi kerusakan atau kehilangan yang disebabkan oleh kelalaian, Pihak Kedua bersedia mengganti sesuai ketentuan yang berlaku.</p>
    </div>

    <div class="footer">
        <div class="signature">
            <p>Yang Menyerahkan,<br>Pihak Pertama</p>
            <br><br><br>
            <p>( ...................................... )</p>
        </div>
        <div class="signature">
            <p>Yang Menerima,<br>Pihak Kedua</p>
            <br><br><br>
            <p><strong>{{ $assignment->employee_name }}</strong></p>
        </div>
    </div>
</body>
</html>
