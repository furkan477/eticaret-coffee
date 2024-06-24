<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Order;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class DashboardController extends Controller
{
    public function index()
    {
        $TotalCount = Order::count();
        $TotalPrice = Order::sum('price');

        $date7DaysAgo = Carbon::now()->subDays(32);
        // 7 gün önceki siparişlerin sayısını alın
        $mountCount = Order::where('created_at', '>=', $date7DaysAgo)->count();
        $mountPrice = Order::where('created_at', '>=', $date7DaysAgo)->sum('price');

        $topProducts = Order::select('product_id', DB::raw('sum(qty) as total_sold'))
            ->with('product:id,name') 
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();

        return view('backend.pages.index',compact('topProducts','TotalCount','TotalPrice','mountCount','mountPrice'));
    }

    public function orderchart()
    {
        $aggregatedData = Order::select(DB::raw('name, SUM(price * qty) as total_price'))
        ->groupBy('name')
        ->get();
    
        $labels = $aggregatedData->pluck('name');
        $dataa = $aggregatedData->pluck('total_price');
    
        $data = [
            'labels' =>  $labels,
            'data' => $dataa,
        ];
    
        return view('backend.pages.chart',compact('data'));
    }
}
