<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // 検索（商品名）
        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        // 並び替え
        if ($request->sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort === 'price_desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->orderBy('id', 'asc');
        }

        $products = $query->paginate(6);

        $products->appends($request->query());
        return view('products.index', compact('products'));


    }

    public function create()
    {
        $seasons = Season::all();
        return view('products.register', compact('seasons'));
    }

    public function store(StoreProductRequest $request)
    {
        $path = $request->file('image')->store('products', 'public'); // products/xxxxx.jpg

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $path,
            'description' => $request->description,
        ]);

        $product->seasons()->attach($request->seasons);

        return redirect()->route('products.index');
    }

    public function show(Product $product)
    {
        $product->load('seasons');
        $seasons = Season::all();

        return view('products.detail', compact('product', 'seasons'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
        ];

        // 画像は「選ばれた時だけ」更新（選ばなければ元の画像のまま）
        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);
        $product->seasons()->sync($request->seasons);

        return redirect()->route('products.show', $product);
    }

    public function destroy(Product $product)
    {
        $product->seasons()->detach();

        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index');
    }
}