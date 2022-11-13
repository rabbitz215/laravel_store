<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Product::with(['category'])->get();

        $title = "Product List";

        return view('admin.pages.product.list', [
            'data' => $data,
            'title' => $title
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = new Product();

        $title = "Product Create";

        return view('admin.pages.product.form', [
            'product' => $product,
            'category' => Category::get(),
            'title' => $title,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->all();

        $image = $request->file('image');
        if ($image) {
            $data['image'] = $image->store('images/product', 'public');
        }

        Product::create($data);

        Alert::success('Success', 'You\'ve Successfully Create A Product');

        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $title = "Product Edit";

        return view('admin.pages.product.form', [
            'product' => $product,
            'category' => Category::get(),
            'title' => $title
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->all();
        $image = $request->file('image');
        if ($image) {
            // cek apakah file lama ada didalam folder?
            $exists = File::exists(storage_path('app/public/') . $product->image);
            if ($exists) {
                // delete file lama tersebut
                File::delete(storage_path('app/public/') . $product->image);
            }
            // upload file baru
            $data['image'] = $image->store('images/product', 'public');
        }
        $product->update($data);

        Alert::success('Success', 'You\'ve Successfully Update A Product');

        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->destroy($product->id);

        File::delete(storage_path('app/public/') . $product->image);

        Alert::success('Success', 'You\'ve Successfully Delete A Product');

        return redirect()->route('product.index');
    }
}
