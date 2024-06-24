<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Coupon;

class CouponController extends Controller
{
    public function index()
    {
        $coupone = Coupon::all();
        return view('backend.pages.coupon.index',compact('coupone'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $name = $request->name;
        $sor = Coupon::where('name',$name)->first();

        if(!empty($sor)){
            return back()->withError('ZAten Kayıtlı !');
        }


        if($request->hasFile('image')){
            $resim = $request->file('image');
            $dosyaadi = time().'-'.Str::slug($request->name).'.'.$resim->getClientOriginalExtension();
            $resim->move(public_path('img/slider'),$dosyaadi);
        }else {
            $resim = null;
        }

        Coupon::create([
            'name' => $request->name,
            'price' =>$request->price,
            'status' => $request->status,
        ]);
        return back()->withSuccess('Coupon Başarıyla Oluşturuldu');
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
        $coupone = Coupon::where('id',$id)->first();
        return view('backend.pages.coupon.edit',compact('coupone'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {  
        $name = $request->name;
        $sor = Coupon::where('id','!=',$id)->where('name',$name)->first();

        if(!empty($sor)){
            return back()->withError('Zaten Kayıtlı !');
        }

            
        $coupon = Coupon::find($id);

        $coupon->update($request->all());
        return redirect()->route('panel.coupon.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $coupon = Coupon::find($id);
        $coupon->delete($id);


        return redirect()->route('panel.coupon.index');
    }
}
