<?php

namespace App\Http\Controllers;

use App\Models\CurrentAssetCategory;
use Illuminate\Http\Request;

class CurrentAssetCategoryController extends Controller
{
    public function index()
    {
        // Fetch categories from database instead of hardcoded array
        $categories = CurrentAssetCategory::withCount('currentAssets')->get();
        return view('current_asset_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('current_asset_categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:current_asset_categories,name',
            'description' => 'nullable|string',
        ]);

        CurrentAssetCategory::create($validated);

        return redirect()->route('current-asset-categories.index')
            ->with('success', 'Kategori aset lancar berhasil ditambahkan.');
    }

    public function edit(CurrentAssetCategory $currentAssetCategory)
    {
        // Binding resolution might fail if route param doesn't match, so we use explicit model binding or id
        return view('current_asset_categories.edit', compact('currentAssetCategory'));
    }

    // Workaround if route resource binding name is singular 'current_asset_category' or 'category'
    // Let's assume route is manually defined or resource uses default naming.
    // Given the route definition: Route::get('current-asset-categories', ...), it wasn't a resource route.
    // I need to update web.php to use Route::resource for full CRUD.

    public function update(Request $request, $id)
    {
        $category = CurrentAssetCategory::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:current_asset_categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update($validated);

        return redirect()->route('current-asset-categories.index')
            ->with('success', 'Kategori aset lancar berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $category = CurrentAssetCategory::findOrFail($id);

        // Check if has assets
        if ($category->currentAssets()->count() > 0) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki aset.');
        }

        $category->delete();

        return redirect()->route('current-asset-categories.index')
            ->with('success', 'Kategori aset lancar berhasil dihapus.');
    }
}
