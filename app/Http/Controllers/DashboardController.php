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
        $string = "Toy/s";
        if(strpos($string,"'")){
            $string = str_replace("'", '', $string);
        }

        if(strpos($string, '"')){
            $string = str_replace('"', '', $string);
        }

        if(strpos($string, '/')){
            $string = str_replace('/', '', $string);
        }
        // dd($string);
        // $top5Item = OutletVisitProduct::selectRaw('count(outlet_visit_products.product_id) as product_count, products.name as product_name,month(outlet_visit_products.created_at) as month')
        //     ->join('products', 'products.id', 'outlet_visit_products.product_id')
        //     ->whereMonth('outlet_visit_products.created_at', date('m'))
        //     ->groupBy('outlet_visit_products.product_id', 'product_name','month')
        //     ->orderBy('product_count', 'DESC')
        //     ->limit(5)
        //     ->get();

        // $display = DetailStoreVisit::selectRaw('
        //         COUNT(detail_store_visits.display_product_id) as count_display,
        //         detail_store_visits.display_product_id as display_id,
        //         display_products.name as display_name, 
        //         MONTHNAME(detail_store_visits.created_at) as month
        //     ')
        //     ->join('display_products', 'display_products.id', 'detail_store_visits.display_product_id')
        //     ->whereBetween('detail_store_visits.created_at', [
        //         date('Y-m-d', strtotime('-3 months')),
        //         date('Y-m-t')
        //     ])
        //     ->groupBy('display_product_id', 'display_name','month')
        //     ->orderBy('month', 'DESC')->get();
        // dd($display->toArray());

        return view('dashboard', ['chartvisit' => $chartvisit->build(), 
            'chartmarketshare' => $chartmarketshare->build(),
            'chartincrement' => $chartincrement->build()],
            compact('store', 'outlet', 'user', 'visit'));
    }
}
