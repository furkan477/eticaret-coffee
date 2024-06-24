<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(){
        $settings = SiteSetting::get();
        return view('backend.pages.settings.index',compact('settings'));
    } 
    public function create(){
        $settings = SiteSetting::get();
        return view('backend.pages.settings.create',compact('settings'));
    }
    public function store(Request $request){

        SiteSetting::firstOrcreate([
            'name' => $request->name,
            'data' => $request->data,
            'set_type' => $request->set_type,
        ]);

        return redirect()->route('panel.setting.index');
    }
    public function edit($id){
        $setting = SiteSetting::where('id',$id)->first();
        return view('backend.pages.settings.edit',compact('setting'));
    }
    public function update(Request $request ,$id){
        $settings = SiteSetting::where('id',$id)->first();
        
        if($request->hasFile('data')){
            $resim = $request->file('data');
            $dosyaadi = time().'-'.Str::slug($request->name).'.'.$resim->getClientOriginalExtension();
            $resim->move(public_path('img/setting'),$dosyaadi);
        }

        $settings->update([
            'name' => $request->name,
            'data' => $dosyaadi ?? $request->data,
            'set_type' => $request->set_type,
        ]);
        return redirect()->route('panel.setting.index');
    }
    public function destroy(string $id)
    {
        $products = SiteSetting::find($id);
        $products->delete($id);


        return redirect()->route('panel.setting.index');
    }
}
