<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use App\Models\HeaderVisit;
use App\Models\OutletVisitProduct;

// Traits
use App\Traits\LoggingTraits;

use App\Charts\VisitChart;
use App\Charts\MarketShareChart;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class DashboardController extends Controller
{
    use LoggingTraits;

    public function index(VisitChart $chartvisit, MarketShareChart $chartmarketshare){
        $store = Customer::where('type', 'S')->get()->count();
        $outlet = Customer::where('type', 'O')->get()->count();
        $user = User::all()->count();
        $visit = HeaderVisit::where('user_id', Auth::user()->id)
            ->where('date', date('Y-m-d'))->get()->count();

        $top5Item = OutletVisitProduct::selectRaw('count(outlet_visit_products.product_id) as product_count,products.name')
        ->join('products', 'products.id', 'outlet_visit_products.product_id')
        ->groupBy('outlet_visit_products.product_id', 'products.name')
        ->orderBy('outlet_visit_products.product_id', 'ASC')
        ->limit(5)
        ->get();

        // $this->createLog(
        //     'view',
        //     Auth::user(),
        //     'Displaying dashboard',
        //     'view dashboard'
        // );

        return view('dashboard', ['chartvisit' => $chartvisit->build(), 'chartmarketshare' => $chartmarketshare->build()], compact('store', 'outlet', 'user', 'visit'));
    }
}
