<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CurrentAsset extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kode_barang', 'nama_barang', 'kategori',
        'stok_awal', 'stok_masuk', 'stok_keluar', 'stok_tersedia', 'stok_minimum',
        'harga_satuan', 'nilai_total',
        'tanggal_perolehan', 'sumber_dana', 'lokasi_penyimpanan',
        'satuan', 'spesifikasi', 'keterangan',
        'unit_id', 'category_id'
    ];

    protected $casts = [
        'tanggal_perolehan' => 'date',
        'harga_satuan' => 'decimal:2',
        'nilai_total' => 'decimal:2',
    ];

    // Relationships
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function category()
    {
        return $this->belongsTo(CurrentAssetCategory::class);
    }

    public function transactions()
    {
        return $this->hasMany(CurrentAssetTransaction::class);
    }

    // Accessors
    public function getIsLowStockAttribute()
    {
        return $this->stok_tersedia <= $this->stok_minimum;
    }

    // Methods
    public function recalculateStock()
    {
        // Calculate based on approved transactions
        $stok_masuk = $this->transactions()
            ->where('status', 'approved')
            ->whereIn('transaction_type', ['purchase', 'transfer_in', 'grant_in', 'production'])
            ->sum('quantity');

        $stok_keluar = $this->transactions()
            ->where('status', 'approved')
            ->whereIn('transaction_type', ['usage', 'transfer_out', 'grant_out', 'disposal'])
            ->sum('quantity');

        // Adjust for Opname/Correction if needed (simplified for now: treat as direct adjustment or separate logic)
        // For now, let's assume stock is purely calculated from these transactions + initial stock

        $this->stok_masuk = $stok_masuk;
        $this->stok_keluar = $stok_keluar;
        $this->stok_tersedia = $this->stok_awal + $this->stok_masuk - $this->stok_keluar;

        // Recalculate value (Avg Price or Last Price) - SAKTI uses Last Price or Avg
        // For simplicity, we keep the manual price update or update it based on last purchase
        $lastPurchase = $this->transactions()
            ->where('status', 'approved')
            ->whereIn('transaction_type', ['purchase'])
            ->latest('transaction_date')
            ->first();

        if ($lastPurchase) {
            $this->harga_satuan = $lastPurchase->unit_price;
        }

        $this->nilai_total = $this->stok_tersedia * $this->harga_satuan;
        $this->save();
    }
}
