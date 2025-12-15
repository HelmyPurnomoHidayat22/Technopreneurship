<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories
     */
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for customizing category
     */
    public function customize(Category $category)
    {
        return view('admin.categories.customize', compact('category'));
    }

    /**
     * Update category customization
     */
    public function updateCustomization(Request $request, Category $category)
    {
        $validated = $request->validate([
            'note' => ['nullable', 'string', 'max:1000'],
            'custom_style' => ['nullable', 'string', 'max:50'],
            'icon' => ['nullable', 'string', 'max:50'],
        ], [
            'note.max' => 'Catatan maksimal 1000 karakter',
            'custom_style.max' => 'Custom style maksimal 50 karakter',
            'icon.max' => 'Icon maksimal 50 karakter',
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Customisasi kategori berhasil diperbarui!');
    }
}
