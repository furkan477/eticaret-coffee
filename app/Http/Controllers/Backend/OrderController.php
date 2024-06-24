<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\İnvoice;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index() {
        $orders = İnvoice::withCount('orders')->paginate(20);
        return view('backend.pages.orders.index',compact('orders'));
    }

    public function edit($id) {
        $invoice = İnvoice::where('id',$id)->with('orders')->firstOrFail();
        return view('backend.pages.orders.edit',compact('invoice'));
    }

    public function update(Request $request , $id) {
        $update = $request->status;
        İnvoice::where('id',$id)->update(['status' => $update]);
        return redirect()->route('panel.order.index');
    }

    public function destroy(Request $request)
    {
        $order = İnvoice::where('id',$request->id)->firstOrFail();
        Order::where('order_no',$order->order_no)->delete();
        $order->delete();

        return redirect()->route('panel.order.index');
    }
}
