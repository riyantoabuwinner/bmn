<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\CurrentAsset;
use App\Models\CurrentAssetTransaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CurrentAssetTransactionTest extends TestCase
{
    // use RefreshDatabase; // Don't use refresh on existing DB, be careful

    public function test_transaction_flow()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // 1. Create Asset
        $asset = CurrentAsset::create([
            'kode_barang' => 'TEST-001',
            'nama_barang' => 'Test Item',
            'stok_awal' => 0,
            'stok_masuk' => 0,
            'stok_keluar' => 0,
            'stok_tersedia' => 0,
            'harga_satuan' => 1000,
            'nilai_total' => 0,
        ]);

        // 2. Create Purchase Transaction (Pending)
        $response = $this->post(route('current-asset-transactions.store'), [
            'current_asset_id' => $asset->id,
            'transaction_type' => 'purchase',
            'reference_number' => 'REF-001',
            'transaction_date' => now()->toDateString(),
            'quantity' => 10,
            'unit_price' => 1000,
        ]);

        $response->assertRedirect();

        $asset->refresh();
        $this->assertEquals(0, $asset->stok_tersedia, 'Stock should not increase on pending transaction');

        // 3. Approve Transaction
        $transaction = CurrentAssetTransaction::where('reference_number', 'REF-001')->first();

        $response = $this->post(route('current-asset-transactions.action', $transaction), [
            'action' => 'approve'
        ]);

        $asset->refresh();
        $this->assertEquals(10, $asset->stok_tersedia, 'Stock should increase after approval');
        $this->assertEquals(10, $asset->stok_masuk);

        // 4. Create Usage Transaction (Pending)
        $response = $this->post(route('current-asset-transactions.store'), [
            'current_asset_id' => $asset->id,
            'transaction_type' => 'usage',
            'reference_number' => 'REF-002',
            'transaction_date' => now()->toDateString(),
            'quantity' => 2,
        ]);

        $asset->refresh();
        $this->assertEquals(10, $asset->stok_tersedia);

        // 5. Approve Usage
        $transactionUsage = CurrentAssetTransaction::where('reference_number', 'REF-002')->first();
        $this->post(route('current-asset-transactions.action', $transactionUsage), [
            'action' => 'approve'
        ]);

        $asset->refresh();
        $this->assertEquals(8, $asset->stok_tersedia, 'Stock should decrease after usage approval');
        $this->assertEquals(2, $asset->stok_keluar);

        // Clean up
        $transactionUsage->delete();
        $transaction->delete();
        $asset->delete();
        $user->delete();
    }
}
