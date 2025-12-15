<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Get category to check if it's Custom Design
        $category = Category::find($request->category_id);
        $isCustomDesign = $category && $category->name === 'Custom Design';

        // Base validation rules
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'preview_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];

        // Add file_template validation only if NOT Custom Design
        if (!$isCustomDesign) {
            $rules['file_template'] = 'required|file|mimes:pptx,pdf,psd,zip,ai,eps,docx,xlsx,fig,sketch,rar,7z|max:10240';
        }

        $request->validate($rules);

        $product = new Product();
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category_id;

        // Store preview image
        if ($request->hasFile('preview_image')) {
            $previewImage = $request->file('preview_image');
            $previewImagePath = $previewImage->store('products/previews', 'private');
            $product->preview_image = $previewImagePath;
        }

        // Store file template (only if provided and not Custom Design)
        if ($request->hasFile('file_template') && !$isCustomDesign) {
            $fileTemplate = $request->file('file_template');
            $fileTemplatePath = $fileTemplate->store('products/files', 'private');
            $product->file_path = $fileTemplatePath;
        }

        $product->save();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('category');
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'preview_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'file_template' => 'nullable|file|mimes:pptx,pdf,psd,zip,ai,eps,docx,xlsx,fig,sketch,rar,7z|max:10240',
        ]);

        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category_id;

        // Update preview image if provided
        if ($request->hasFile('preview_image')) {
            // Delete old preview image
            if ($product->preview_image) {
                Storage::disk('private')->delete($product->preview_image);
            }
            $previewImage = $request->file('preview_image');
            $previewImagePath = $previewImage->store('products/previews', 'private');
            $product->preview_image = $previewImagePath;
        }

        // Update file template if provided
        if ($request->hasFile('file_template')) {
            // Delete old file template
            if ($product->file_path) {
                Storage::disk('private')->delete($product->file_path);
            }
            $fileTemplate = $request->file('file_template');
            $fileTemplatePath = $fileTemplate->store('products/files', 'private');
            $product->file_path = $fileTemplatePath;
        }

        $product->save();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete associated files
        if ($product->preview_image) {
            Storage::disk('private')->delete($product->preview_image);
        }
        if ($product->file_path) {
            Storage::disk('private')->delete($product->file_path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
