<?php

namespace App\Http\Controllers;

use App\Http\Requests\İnvoiceRequest;
use App\Models\Coupon;
use App\Models\İnvoice;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartİtem = session('cart',[]);
        $totalPrice = 0;

        foreach ($cartİtem as $cart) {
            $totalPrice += $cart['price'] * $cart['qty'];
        }
        $cartİtem;

        if(session()->get('coupon_code')) {
            $kupon = Coupon::where('name',session()->get('coupon_code'))->first();
            $kupon_price = $kupon->price ?? 0;
            $kupon_code = $kupon->name ?? '';

            $newtotalprice = $totalPrice - $kupon_price;
        }else {
            $newtotalprice = $totalPrice;
        }
        
        session()->put('total_price',$newtotalprice);

        $seolists = metaolustur('sepet');

        $seo = [
            'title' =>  $seolists['title'] ?? '',
            'description' => $seolists['description'] ?? '',
            'keywords' => $seolists['keywords'] ?? '',
            'image' => asset('img/page-bg.jpg'),
            'url'=>  $seolists['currenturl'],
            'canonical'=> $seolists['trpage'],
            'robots' => 'index, follow',
        ];

        $breadcrumb = [
            'sayfalar' => [],
            'active' => 'sepet'
        ];
        return view('frontend.pages.cart',compact('seo','breadcrumb','cartİtem'));
    }

    public function sepetform()
    {
        $cartİtem = session('cart',[]);
        $totalPrice = 0;

        foreach ($cartİtem as $cart) {
            $totalPrice += $cart['price'] * $cart['qty'];
        }
        $cartİtem;

        if(session()->get('coupon_code')) {
            $kupon = Coupon::where('name',session()->get('coupon_code'))->first();
            $kupon_price = $kupon->price ?? 0;
            $kupon_code = $kupon->name ?? '';

            $newtotalprice = $totalPrice - $kupon_price;
        }else {
            $newtotalprice = $totalPrice;
        }
        
        session()->put('total_price',$newtotalprice);

        $seolists = metaolustur('sepet');

        $seo = [
            'title' =>  $seolists['title'] ?? '',
            'description' => $seolists['description'] ?? '',
            'keywords' => $seolists['keywords'] ?? '',
            'image' => asset('img/page-bg.jpg'),
            'url'=>  $seolists['currenturl'],
            'canonical'=> $seolists['trpage'],
            'robots' => 'index, follow',
        ];  

        $breadcrumb = [
            'sayfalar' => [],
            'active' => 'sepet'
        ];

        return view('frontend.pages.cartform',compact('seo','breadcrumb','cartİtem'));
    }

    public function add(Request $request)
    {
            
            $productİd = sifrelecoz($request->product_id);
            $size = $request->size;
            $qty = $request->qty ?? 1;

            $cartİtem = session('cart',[]);
            $item = Product::find($productİd);

            if(array_key_exists($productİd,$cartİtem)){
                $cartİtem[$productİd]['qty'] += $qty;
            } else {
                $cartİtem[$productİd] = [
                    "image" => $item->image,
                    "name" => $item->name,
                    "price" => $item->price,
                    "size" => $size,
                    "qty" => $qty,
                    "kdv" => $item->kdv,
                ];

            }
            session(['cart'=>$cartİtem]);

            if($request->ajax()){
                return response()->json(['Sepet Güncellendi']);
            }

        return redirect('sepet');
    }
    
    public function newqty(Request $request) {
        $productID= $request->product_id;
        $qty= $request->qty ?? 1;
        $itemtotal = 0;
         $urun = Product::find($productID);
        if(!$urun) {
            return response()->json('Ürün Bulanamadı!');
        }
        $cartItem = session('cart',[]);


        if(array_key_exists($productID,$cartItem)){
            $cartItem[$productID]['qty'] = $qty;
            if($qty == 0 || $qty < 0){
                unset($cartItem[$productID]);
            }
            $itemtotal =  $urun->price * $qty;
        }

        session(['cart'=>$cartItem]);


         $this->sepetList();

        if($request->ajax()) {
            return response()->json(['itemTotal'=>$itemtotal, 'message'=>'Sepet Güncellendi']);
        }
    }


    public function remove(Request $request)
    {
        $productİd = sifrelecoz($request->product_id);
        $cartİtem = session('cart',[]);

        if(array_key_exists($productİd,$cartİtem)){
            unset($cartİtem[$productİd]);
        }
        session(['cart' => $cartİtem]);

        if($request->ajax()){
            return response()->json(['Sepet Güncellendi']);
        }

        return redirect('/sepet');
    }

    public function couponcheck(Request $request)
    {
        $cartİtem = session('cart',[]);
        $totalPrice = 0;

        foreach ($cartİtem as $cart) {
            $totalPrice += $cart['price'] * $cart['qty'];
        }

        $kupon = Coupon::where('name',$request->coupon_name)->first();
        $kuponprice = $kupon->price ?? 0;
        $kuponcode = $kupon->name ?? '';

        $totalPrice = $totalPrice - $kuponprice;

        session()->put('total_price',$totalPrice);
        session()->put('coupon_price',$kuponprice);
        session()->put('coupon_code',$kuponcode);

        return back()->withSuccess('Kupon Başarıyla Uygulandı.');

    }

    function generateKod() {
        $siparisno = generateOTP(7);
            if ($this->barcodeKodExists($siparisno)) {
                return $this->generateKod();
            }

            return $siparisno;
        }

        function barcodeKodExists($siparisno) {
            return İnvoice::where('order_no',$siparisno)->exists();
        }

    public function cartSave (İnvoiceRequest $request)
    {   
        

        $invoce = İnvoice::create([
            "order_no" => $this->generateKod(),
            "country" => $request->country,
            "name" => $request->name,
            "company_name" => $request->company_name ?? null,
            "address" => $request->address ?? null,
            "city" => $request->city ?? null,
            "district" => $request->district ?? null,
            "posta_zip" => $request->posta_zip ?? null,
            "email" => $request->email ?? null,
            "phone" => $request->phone ?? null,
            "note" => $request->note ?? null,
        ]);

        $cart = session()->get('cart') ?? [];
        foreach ($cart as $key => $item) {
            Order::create([
                'order_no' => $invoce->order_no,
                'product_id' => $key,
                'name'  => $item['name'],
                'price' => $item['price'],
                'qty' => $item['qty'],
            ]);
        }

        session()->forget('cart');
        return redirect()->route('anasayfa');
    }
}
