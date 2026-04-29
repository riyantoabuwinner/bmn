@extends('adminlte::page')

@section('title', 'Scan QR Code Aset')

@section('content_header')
    <h1><i class="fas fa-qrcode"></i> Scan QR Code Aset</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <!-- Scanner Container -->
                <div id="scanner-container" class="mb-3">
                    <div id="reader" style="width: 100%; max-width: 600px; margin: 0 auto;"></div>
                </div>

                <!-- Instructions -->
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Cara Penggunaan:</strong>
                    <ol class="mb-0 mt-2">
                        <li>Klik tombol "Mulai Scan" di bawah</li>
                        <li>Izinkan akses kamera pada browser</li>
                        <li>Arahkan kamera ke QR Code pada aset</li>
                        <li>Detail aset akan muncul otomatis setelah QR Code terdeteksi</li>
                    </ol>
                </div>

                <!-- Control Buttons -->
                <div class="text-center mb-3">
                    <button id="start-btn" class="btn btn-primary btn-lg">
                        <i class="fas fa-play"></i> Mulai Scan
                    </button>
                    <button id="stop-btn" class="btn btn-danger btn-lg" style="display:none;">
                        <i class="fas fa-stop"></i> Berhenti Scan
                    </button>
                </div>

                <!-- Scan Result -->
                <div id="result" class="alert" style="display:none;"></div>
            </div>
        </div>
    </div>
</div>

<!-- Asset Detail Modal -->
<div class="modal fade" id="assetModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title"><i class="fas fa-box"></i> Detail Aset</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <img id="asset-photo" src="" alt="Asset Photo" 
                             class="img-fluid rounded" style="max-height: 200px;">
                    </div>
                    <div class="col-md-8">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Kode Aset:</th>
                                <td id="asset-code"></td>
                            </tr>
                            <tr>
                                <th>Nama Aset:</th>
                                <td id="asset-name" class="font-weight-bold"></td>
                            </tr>
                            <tr>
                                <th>Kategori:</th>
                                <td id="asset-category"></td>
                            </tr>
                            <tr>
                                <th>Lokasi:</th>
                                <td id="asset-location"></td>
                            </tr>
                            <tr>
                                <th>Unit:</th>
                                <td id="asset-unit"></td>
                            </tr>
                            <tr>
                                <th>Kondisi:</th>
                                <td>
                                    <span id="asset-condition" class="badge"></span>
                                </td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>
                                    <span id="asset-status" class="badge"></span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a id="view-detail-btn" href="#" class="btn btn-info">
                    <i class="fas fa-eye"></i> Lihat Detail Lengkap
                </a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    #reader {
        border: 3px solid #667eea;
        border-radius: 10px;
        overflow: hidden;
    }
    #scanner-container {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
    }
</style>
@stop

@section('js')
<!-- html5-qrcode library -->
<script src="https://unpkg.com/html5-qrcode"></script>

<script>
let html5QrCode;
let isScanning = false;

$(document).ready(function() {
    $('#start-btn').click(startScanning);
    $('#stop-btn').click(stopScanning);
});

function startScanning() {
    if (isScanning) return;

    html5QrCode = new Html5Qrcode("reader");
    
    html5QrCode.start(
        { facingMode: "environment" }, // Use back camera
        {
            fps: 10,
            qrbox: { width: 250, height: 250 }
        },
        onScanSuccess,
        onScanError
    ).then(() => {
        isScanning = true;
        $('#start-btn').hide();
        $('#stop-btn').show();
        $('#result').hide();
    }).catch(err => {
        alert('Error accessing camera: ' + err);
    });
}

function stopScanning() {
    if (!isScanning) return;

    html5QrCode.stop().then(() => {
        isScanning = false;
        $('#start-btn').show();
        $('#stop-btn').hide();
    }).catch(err => {
        console.error('Error stopping scanner:', err);
    });
}

function onScanSuccess(decodedText, decodedResult) {
    // Stop scanning immediately after successful scan
    stopScanning();

    // Show loading
    $('#result').removeClass('alert-success alert-danger')
        .addClass('alert-info')
        .html('<i class="fas fa-spinner fa-spin"></i> Mencari data aset...')
        .show();

    // Fetch asset data
    fetch(`/api/aset/scan/${encodeURIComponent(decodedText)}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayAssetModal(data.data);
                $('#result').removeClass('alert-info alert-danger')
                    .addClass('alert-success')
                    .html('<i class="fas fa-check-circle"></i> Aset ditemukan!');
            } else {
                $('#result').removeClass('alert-info alert-success')
                    .addClass('alert-danger')
                    .html('<i class="fas fa-times-circle"></i> ' + data.message);
            }
        })
        .catch(error => {
            $('#result').removeClass('alert-info alert-success')
                .addClass('alert-danger')
                .html('<i class="fas fa-exclamation-triangle"></i> Error: ' + error.message);
        });
}

function onScanError(error) {
    // Ignore scan errors (they happen frequently while searching for QR code)
}

function displayAssetModal(asset) {
    // Fill modal with asset data
    $('#asset-code').text(asset.asset_code);
    $('#asset-name').text(asset.name);
    $('#asset-category').text(asset.category);
    $('#asset-location').text(asset.location);
    $('#asset-unit').text(asset.unit);
    
    // Set photo
    if (asset.photo) {
        $('#asset-photo').attr('src', asset.photo).show();
    } else {
        $('#asset-photo').attr('src', '{{ asset("vendor/adminlte/dist/img/default-150x150.png") }}').show();
    }
    
    // Set condition badge
    let conditionClass = '';
    let conditionText = '';
    switch(asset.condition_status) {
        case 'baik':
            conditionClass = 'success';
            conditionText = 'Baik';
            break;
        case 'rusak_ringan':
            conditionClass = 'warning';
            conditionText = 'Rusak Ringan';
            break;
        case 'rusak_berat':
            conditionClass = 'danger';
            conditionText = 'Rusak Berat';
            break;
        default:
            conditionClass = 'secondary';
            conditionText = asset.condition_status;
    }
    $('#asset-condition').removeClass().addClass('badge badge-' + conditionClass).text(conditionText);
    
    // Set availability badge
    let statusClass = '';
    let statusText = '';
    switch(asset.availability_status) {
        case 'tersedia':
            statusClass = 'success';
            statusText = 'Tersedia';
            break;
        case 'dipinjam':
            statusClass = 'warning';
            statusText = 'Dipinjam';
            break;
        case 'maintenance':
            statusClass = 'info';
            statusText = 'Maintenance';
            break;
        case 'rusak':
            statusClass = 'danger';
            statusText = 'Rusak';
            break;
        default:
            statusClass = 'secondary';
            statusText = asset.availability_status;
    }
    $('#asset-status').removeClass().addClass('badge badge-' + statusClass).text(statusText);
    
    // Set detail button link
    $('#view-detail-btn').attr('href', '/assets/' + asset.id);
    
    // Show modal
    $('#assetModal').modal('show');
}
</script>
@stop
