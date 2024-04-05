<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use App\Models\HeaderVisit;
use App\Models\OutletVisitProduct;
use App\Models\DetailStoreVisit;

use App\Charts\VisitChart;
use App\Charts\MarketShareChart;
use App\Charts\IncrementQuarterDisplayChart;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class DashboardController extends Controller
{

    public function index(VisitChart $chartvisit, MarketShareChart $chartmarketshare, IncrementQuarterDisplayChart $chartincrement){
        $store = Customer::where('type', 'S')->get()->count();
        $outlet = Customer::where('type', 'O')->get()->count();
        $user = User::all()->count();
        $visit = HeaderVisit::where('user_id', Auth::user()->id)
            ->where('date', date('Y-m-d'))->get()->count();

        // $top5Item = OutletVisitProduct::selectRaw('count(outlet_visit_products.product_id) as product_count, products.name as product_name,month(outlet_visit_products.created_at) as month')
        //     ->join('products', 'products.id', 'outlet_visit_products.product_id')
        //     ->whereMonth('outlet_visit_products.created_at', date('m'))
        //     ->groupBy('outlet_visit_products.product_id', 'product_name','month')
        //     ->orderBy('product_count', 'DESC')
        //     ->limit(5)
        //     ->get();
        // dd($top5Item->toArray());

        return view('dashboard', ['chartvisit' => $chartvisit->build(), 
            'chartmarketshare' => $chartmarketshare->build(),
            'chartincrement' => $chartincrement->build()],
            compact('store', 'outlet', 'user', 'visit'));
    }
}
