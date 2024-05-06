<?php

namespace App\Http\Controllers;

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
        return view('frontend.pages.cart',compact('cartİtem','totalPrice'));
    }

    public function add(Request $request)
    {
            
            $productİd = $request->product_id;
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
                ];
            }
            session(['cart'=>$cartİtem]);

        return redirect('sepet');
    }

    public function remove(Request $request)
    {
        $productİd = $request->product_id;
        $cartİtem = session('cart',[]);

        if(array_key_exists($productİd,$cartİtem)){
            unset($cartİtem[$productİd]);
        }
        session(['cart' => $cartİtem]);

        return redirect('/sepet');
    }
}
