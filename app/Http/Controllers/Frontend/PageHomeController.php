<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Category;
use App\Models\Product;
use App\Models\SiteSetting;
use App\Models\Slider;
use Illuminate\Http\Request;

class PageHomeController extends Controller
{
    public function anasayfa()
    {
        $slider = Slider::where('status','1')->first();
        $categories = Category::where('status','1')->get();
        $about = About::where('id','1')->first();
        $lastproduct = Product::where('status','1')->select(['id','name','slug','size','color','price','category_id','image'])->orderBy('id','desc')->limit(10)->get();

        $seolists = metaolustur('anasayfa');

        $seo = [
            'title' =>  $seolists['title'] ?? '',
            'description' => $seolists['description'] ?? '',
            'keywords' => $seolists['keywords'] ?? '',
            'image' => asset('img/page-bg.jpg'),
            'url'=>  $seolists['currenturl'],
            'canonical'=> $seolists['trpage'],
            'robots' => 'index, follow',
        ];
        
        return view('frontend.pages.index', compact('seo','slider','categories','about','lastproduct')); 
    }
}
