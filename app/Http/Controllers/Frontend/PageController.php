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

        $sizes = !empty($request->size) ? explode(',',$request->size) : null;

        $colors = !empty($request->color) ? explode(',',$request->color) : null;

        $start_price = $request->min ?? null;

        $end_price = $request->max ?? null;
        
        $order = $request->order ?? 'id';

        $sort = $request->sort ?? 'desc';


        $anakategori = null;
            $altkategori = null;
            if(!empty($category) && empty($slug)) {
                  $anakategori = Category::where('slug',$category)->first();
                  $categorySlug = $anakategori->slug ?? '';
            }else if (!empty($category) && !empty($slug)){
                 $anakategori = Category::where('slug',$category)->first();
                 $altkategori = Category::where('slug',$slug)->first();
                 $categorySlug = $altkategori->slug ?? '';
            }


            $breadcrumb = [
                'sayfalar' => [

                ],
                'active'=> 'Ürünler'
            ];

            if(!empty($anakategori) && empty($altkategori)) {
                $breadcrumb['active'] = $anakategori->name;
            }

            if(!empty($altkategori)) {
                $breadcrumb['sayfalar'][] = [
                    'link'=> route($anakategori->slug.'urunler'),
                    'name' => $anakategori->name
                ];

                $breadcrumb['active'] = $altkategori->name;
            }



        $products = Product::where('status','1')->select(['id','name','slug','size','color','price','category_id','image'])
        ->where(function($q) use($sizes,$colors,$start_price,$end_price){
            if(!empty($sizes)) {
                $q->whereIn('size',$sizes);
            }
            if(!empty($colors)) {
                $q->whereIn('color',$colors);
            }
            if(!empty($start_price) && $end_price) {
                //$q->whereBetween('price',[$start_price,$end_price]);

                $q->where('price','>=',$start_price);
                $q->where('price','<=',$end_price);
            }
            return $q;
        })
        ->with('category:id,name,slug')
        ->whereHas('category' ,function($q) use ($categorySlug) {
            if(!empty($categorySlug)) {
                $q->where('slug',$categorySlug);
            }
            return $q;
        });

        $sizelists = Product::where('status','1')->groupBy('size')->pluck('size')->toArray();

        $colors = Product::where('status','1')->groupBy('color')->pluck('color')->toArray();

        $products = $products->orderBy($order,$sort)->paginate(21);

        $maxprice = Product::max('price');

        $categories = Category::where('status','1')->withCount('items')->get();


        $seolists = metaolustur($category);

        $seo = [
            'title' =>  $seolists['title'] ?? '',
            'description' => $seolists['description'] ?? '',
            'keywords' => $seolists['keywords'] ?? '',
            'image' => asset('img/page-bg.jpg'),
            'url'=>  $seolists['currenturl'],
            'canonical'=> $seolists['trpage'],
            'robots' => 'index, follow',
        ];

        return view('frontend.pages.products',compact('seo','breadcrumb','products','categories','maxprice','sizelists','colors'));
    }


    public function tumurunler()
    {
        $breadcrumb = [
            'sayfalar' => [],
            'active' => 'İnidirimdeki Ürünler'
        ];
        return view('frontend.pages.products',compact('breadcrumb'));
    }

    public function urundetay($slug)
    {
        $product = Product::whereSlug($slug)->where('status','1')->firstOrFail();

        $products = Product::where('id','!=',$product->id)
        ->where('category_id',$product->category_id)
        ->where('status','1')
        ->limit(6)
        ->get();

        
        $category = Category::where('id',$product->category_id)->first();

        $breadcrumb = [
            'sayfalar' => [],
            'active' => $product->name,
        ];

        if(!empty($category)){
            $breadcrumb['sayfalar'][] = [
                'link'=> route('urunler'),
                'name' => $category->name,
            ];
        }

        $title = $product->title ?? $product->name.'-'.$product->category->name.'-'.config('app.name');

        $seo = [
            'title' =>  $title ?? '',
            'description' => $product->description ?? '',
            'keywords' => $product->keywords ?? '',
            'image' => asset($product->image),
            'url'=>  route('urundetay',$product->slug),
            'canonical'=> route('urundetay',$product->slug),
            'robots' => 'index, follow',
        ];


        return view('frontend.pages.product',compact('seo','breadcrumb','product','products'));
    }
    public function hakkimizda()
    {
        
        $about = About::where('id','1')->first();

        $breadcrumb = [
            'sayfalar' => [],
            'active' => 'Hakkımızda'
        ];

        $seolists = metaolustur('hakkımızda');

        $seo = [
            'title' =>  $seolists['title'] ?? '',
            'description' => $seolists['description'] ?? '',
            'keywords' => $seolists['keywords'] ?? '',
            'image' => asset('img/page-bg.jpg'),
            'url'=>  $seolists['currenturl'],
            'canonical'=> $seolists['trpage'],
            'robots' => 'index, follow',
        ];

        return view('frontend.pages.about', compact('seo','breadcrumb','about'));
    }
    public function iletisim()
    {   
         $breadcrumb = [
            'sayfalar' => [],
            'active' => 'İletişim'
        ];

        $seolists = metaolustur('iletisim');

        $seo = [
            'title' =>  $seolists['title'] ?? '',
            'description' => $seolists['description'] ?? '',
            'keywords' => $seolists['keywords'] ?? '',
            'image' => asset('img/page-bg.jpg'),
            'url'=>  $seolists['currenturl'],
            'canonical'=> $seolists['trpage'],
            'robots' => 'index, follow',
        ];

        return view('frontend.pages.contact',compact('seo','breadcrumb'));
    }

}
