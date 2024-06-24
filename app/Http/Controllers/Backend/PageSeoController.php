<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\PageSeo;
use Illuminate\Http\Request;

class PageSeoController extends Controller
{
    public function index()
    {
        $pageseos = PageSeo::all();
        return view('backend.pages.pageseo.index',compact('pageseos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.pageseo.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $pagereq = $request->page;
         $sor = PageSeo::where('page',$pagereq)->first();

        if(!empty($sor)) {
            return back()->withSuccess('Zaten Kayıtlı Sayfa!');
        }

        if($request->hasFile('image')){
            $resim = $request->file('image');
            $dosyaadi = time().'-'.Str::slug($request->name).'.'.$resim->getClientOriginalExtension();
            $resim->move(public_path('img/pageseo'),$dosyaadi);
        }else {
            $resim = null;
        }

        PageSeo::create([
            'dil' => $request->dil,
            'image' =>$dosyaadi ?? null,
            'page' => $request->page,
            'page_ust' => $request->page_ust,
            'title' => $request->title,
            'derscription' => $request->description,
            'keywords' => $request->keywords,
            'contents' => $request->contents,
        ]);
        return back()->withSuccess('SEO Başarıyla Oluşturuldu');
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
        $pageseos = PageSeo::where('id',$id)->first();
        return view('backend.pages.pageseo.edit',compact('pageseos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pageseo = PageSeo::find($id);

        $pagereq = $request->page;
        $sor = PageSeo::where('id','!=',$pageseo->id)->where('page',$pagereq)->first();

        if(!empty($sor)){
            return back()->withSuccess('Zaten Kayıtlı Sayfa!');
        }

        $pageseo->update($request->all());
        return redirect()->route('panel.pageseo.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pageseo = PageSeo::find($id);
        $pageseo->delete($id);


        return redirect()->route('panel.pageseo.index');
    }
}
