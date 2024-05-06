<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function urunler(Request $request, $slug=null)
    {
        $category = request()->segment(1) ?? null;

        $sizes = $request->size ?? null;

        $colors = $request->color ?? null;

        $start_price = $request->min ?? null;

        $end_price = $request->max ?? null;
        
        $order = $request->order ?? 'id';

        $sort = $request->sort ?? 'desc';

        $products = Product::where('status','1')->select(['id','name','slug','size','color','price','category_id','image'])
        ->where(function($q) use($sizes,$colors,$start_price,$end_price){
            if(!empty($sizes)) {
                $q->whereIn('size',$sizes);
            }
            if(!empty($colors)) {
                $q->whereIn('color',$colors);
            }
            if(!empty($start_price) && $end_price) {
                $q->whereBetween('price',[$start_price,$end_price]);
            }
            return $q;
        })
        ->with('category:id,name,slug')
        ->whereHas('category' ,function($q) use ($category,$slug) {
            if(!empty($slug)) {
                $q->where('slug',$slug);
            }
            return $q;
        });

        $sizelists = Product::where('status','1')->groupBy('size')->pluck('size')->toArray();

        $colors = Product::where('status','1')->groupBy('color')->pluck('color')->toArray();

        $products = $products->orderBy($order,$sort)->paginate(21);

        $maxprice = Product::max('price');

        $categories = Category::where('status','1')->withCount('items')->get();

        return view('frontend.pages.products',compact('products','categories','maxprice','sizelists','colors'));
    }





    public function indirimurunleri()
    {
        return view('frontend.pages.products');
    }
    public function urundetay($slug)
    {
        $slug = Product::whereSlug($slug)->where('status','1')->firstOrFail();

        $products = Product::where('id','!=',$slug->id)
        ->where('category_id',$slug->category_id)
        ->where('status','1')
        ->limit(6)
        ->get();

        return view('frontend.pages.product',compact('slug','products'));
    }
    public function hakkimizda()
    {
        $about = About::where('id','1')->first();
        return view('frontend.pages.about', compact('about'));
    }
    public function iletisim()
    {
        return view('frontend.pages.contact');
    }

}
