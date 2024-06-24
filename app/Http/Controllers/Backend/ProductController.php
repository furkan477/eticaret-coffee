<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category:id,cat_ust,name')->orderBy('id','desc')->get();
        return view('backend.pages.product.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();
        return view('backend.pages.product.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        if($request->hasFile('image')){
            $resim = $request->file('image');
            $dosyaadi = 'images/'.Str::slug($request->name).'.'.$resim->getClientOriginalExtension();
            $resim->move(public_path('images/'),$dosyaadi);
        }else {
            $resim = null;
        }


        Product::create([
            'name' => $request->name,
            'image' =>$dosyaadi ?? null,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'size' => $request->size,
            'color' => $request->color,
            'short_text' => $request->short_text,
            'qty' => $request->qty,
            'content' => $request->content,
            'title' => $request->title,
            'description' => $request->description,
            'keywords' => $request->keywords,
            'status' => $request->status,
        ]);
        return back()->withSuccess('Kategori Başarıyla Oluşturuldu');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::where('id',$id)->first();
        $categories = Category::get();
        return view('backend.pages.product.edit',compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $products = Product::find($id);

        $products->update($request->all());
        return redirect()->route('panel.product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $products = Product::find($id);
        $products->delete($id);


        return redirect()->route('panel.product.index');
    }
}