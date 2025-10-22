<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Tag;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductFilterRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductFilterRequest $request)
    {
        abort_if(!auth()->user()->can('view products'), 403);
        $products = app(Pipeline::class)
            ->send(Product::query())
            ->through([
                \App\Filters\Products\SearchFilter::class,
                \App\Filters\Products\CategoryFilter::class,
                \App\Filters\Products\TagFilter::class,
                \App\Filters\Products\PriceFilter::class,
            ])
            ->thenReturn()
            ->with(['image', 'category', 'tags'])
            ->latest()
            ->paginate(session('pagination'));
        $tags = Tag::all();
        $categories = Category::all();
        return view('dashboard.pages.products.index', compact(['products', 'tags', 'categories']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        abort_if(!auth()->user()->can('cteate products'), 403);
        $request->validate([
            'tags' => 'required|array|exists:tags,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $product = Product::create($request->validated());
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = $image->store('/products', 'public');
            if (!$product) {
                return back()->with('error', 'product not found');
            }
            $product->image()->create([
                'path' => $filename,
            ]);
        }
        $product->tags()->syncWithoutDetaching($request->input('tags'));
        return redirect()->route('dashboard.products.index')->with('success', 'Product Created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        abort_if(!auth()->user()->can('edit products'), 403);
        $tags = Tag::all();
        $categories = Category::all();
        return view('dashboard.pages.products.edit', compact(['product', 'tags', 'categories']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        abort_if(!auth()->user()->can('edit products'), 403);
        $request->validate([
            'tags' => 'required|array|exists:tags,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $product->update($request->validated());
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::delete('public/' . $product->image->path);
                $product->image()->delete();
            }
            $image = $request->file('image');
            $filename = $image->store('/products', 'public');
            $product->image()->create([
                'path' => $filename,
            ]);
        }
        $product->tags()->sync($request->input('tags'));

        return redirect()->route('dashboard.products.index')->with('success', 'image Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        abort_if(!auth()->user()->can('delete products'), 403);
        $product->delete();
        return redirect()->back()->with('success' , 'Product deleted successfully');
    }
}
