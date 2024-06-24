<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Str;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('category:id,cat_ust,name')->get();
        return view('backend.pages.category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();
        return view('backend.pages.category.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        if($request->hasFile('image')){
            $resim = $request->file('image');
            $dosyaadi = time().'-'.Str::slug($request->name).'.'.$resim->getClientOriginalExtension();
            $resim->move(public_path('img/kategori'),$dosyaadi);
        }else {
            $resim = null;
        }

        Category::create([
            'name' => $request->name,
            'image' =>$dosyaadi ?? null,
            'content' => $request->content,
            'status' => $request->status,
            'link' => $request->link,
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
        $category = Category::where('id',$id)->first();
        $categories = Category::get();
        return view('backend.pages.category.edit',compact('category','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $categories = Category::find($id);

        $categories->update($request->all());
        return redirect()->route('panel.category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categories = Category::find($id);
        $categories->delete($id);


        return redirect()->route('panel.category.index');
    }
}
