<!DOCTYPE html>
<html>
<head>
    <title>Laporan Evaluasi Aset</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; }
        .header p { margin: 5px 0; }
        .content { margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #000; padding: 4px; }
        .footer { width: 100%; margin-top: 30px; }
        .signature { width: 30%; display: inline-block; vertical-align: top; text-align: center; }
        .badge { padding: 2px 5px; border-radius: 3px; font-weight: bold; color: white; }
        .badge-success { background-color: #28a745; }
        .badge-warning { background-color: #ffc107; color: black; }
        .badge-danger { background-color: #dc3545; }
        .badge-dark { background-color: #343a40; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN HASIL EVALUASI ASET</h2>
        <p>Periode: {{ $evaluation->year }} - {{ ucfirst($evaluation->period_type) }} {{ $evaluation->semester ? 'Semester ' . $evaluation->semester : '' }}</p>
    </div>

    <div class="content">
        <table style="width: 100%; margin-bottom: 20px;">
            <tr>
                <td style="border: none; width: 15%;"><strong>Status</strong></td>
                <td style="border: none;">: {{ $evaluation->status == 'finalized' ? 'Final' : 'Draft' }}</td>
                <td style="border: none; width: 15%;"><strong>Dibuat Oleh</strong></td>
                <td style="border: none;">: {{ $evaluation->creator->name ?? '-' }}</td>
            </tr>
            <tr>
                <td style="border: none;"><strong>Tanggal Finalisasi</strong></td>
                <td style="border: none;">: {{ $evaluation->finalized_at ? $evaluation->finalized_at->format('d/m/Y') : '-' }}</td>
                <td style="border: none;"><strong>Total Aset</strong></td>
                <td style="border: none;">: {{ $details->count() }}</td>
            </tr>
        </table>

        <table class="table">
            <thead>
                <tr style="background-color: #f0f0f0;">
                    <th style="width: 5%;">No</th>
                    <th style="width: 15%;">Kode Aset</th>
                    <th style="width: 25%;">Nama Aset</th>
                    <th style="width: 10%;">Tahun</th>
                    <th style="width: 15%;">Kondisi</th>
                    <th style="width: 15%;">Tindakan</th>
                    <th style="width: 15%;">Catatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($details as $detail)
                    <tr>
                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                        <td>{{ $detail->asset->kode_barang ?? '-' }}</td>
                        <td>{{ $detail->asset->nama_barang ?? '-' }}</td>
                        <td style="text-align: center;">{{ $detail->asset->tgl_perolehan ? $detail->asset->tgl_perolehan->format('Y') : '-' }}</td>
                        <td style="text-align: center;">{{ ucfirst(str_replace('_', ' ', $detail->condition_status)) }}</td>
                        <td>{{ $detail->action_needed ?? '-' }}</td>
                        <td>{{ $detail->notes ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
                <p>Petugas Evaluasi</p>
                <br><br><br>
                <p>( {{ $evaluation->creator->name ?? '...........................' }} )</p>
            </div>
        </div>
    </div>
</body>
</html>
