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
        
            $display = DetailStoreVisit::selectRaw('
            COUNT(detail_store_visits.display_product_id) as count_display,
            detail_store_visits.display_product_id as display_id,
            display_products.name as display_name, 
            MONTHNAME(detail_store_visits.created_at) as month
        ')
        ->join('display_products', 'display_products.id', 'detail_store_visits.display_product_id')
        ->whereBetween('detail_store_visits.created_at', [
            date('Y-m-d', strtotime('-3 months')),
            date('Y-m-t')
        ])
        ->groupBy('display_product_id', 'display_name','month')
        ->orderBy('month', 'DESC')
        ->get();

            // 'detail_store_visits.category_product_id', 'category_products.name'
            // ->join('category_products', 'category_products.id', 'detail_store_visits.category_product_id')
            // count(detail_store_visits.category_product_id) as category_count,
            //     category_products.name as category_name,
        // dd($display);
        
        // $top5Item = OutletVisitProduct::selectRaw('count(outlet_visit_products.product_id) as product_count,products.name')
        // ->join('products', 'products.id', 'outlet_visit_products.product_id')
        // ->groupBy('outlet_visit_products.product_id', 'products.name')
        // ->orderBy('outlet_visit_products.product_id', 'ASC')
        // ->limit(5)
        // ->get();

        return view('dashboard', ['chartvisit' => $chartvisit->build(), 
            'chartmarketshare' => $chartmarketshare->build(),
            'chartincrement' => $chartincrement->build()],
            compact('store', 'outlet', 'user', 'visit'));
    }
}
