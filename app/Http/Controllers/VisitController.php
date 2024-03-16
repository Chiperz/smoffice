<?php

namespace App\Http\Controllers;

// Master
use App\Models\Customer;
use App\Models\BrandProduct;
use App\Models\CategoryProduct;
use App\Models\DisplayProduct;
use App\Models\Product;
use App\Models\UnproductiveReason;

// Transaction
use App\Models\HeaderVisit;
use App\Models\DetailGiftVisit;
use App\Models\Foto;
use App\Models\DetailStoreVisit;
use App\Models\StoreVisitBrand;
use App\Models\StoreVisitUnproductiveReason;
use App\Models\DetailOutletVisit;
use App\Models\OutletVisitProduct;
use App\Models\OutletVisitUnproductiveReason;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class VisitController extends Controller
{
    public function list(String $type){
        $customers = Customer::where('type', $type)->orderBy('code', 'ASC')->paginate(10);
        
        return view('visit.list', compact('customers'));
    }

    public function create(Request $request, String $id){
        $customer = Customer::findOrFail($id);
        $reasons = UnproductiveReason::where('type', $customer->type)->get();
        $lastSerial = HeaderVisit::where('user_id', Auth::user()->id)
                        ->where('date', date('Y-m-d'))
                        ->orderBy('serial', 'DESC')
                        ->get();
        $cekVisit = HeaderVisit::where('user_id', Auth::user()->id)
                        ->where('date', date('Y-m-d'))
                        ->where('time_out', NULL)
                        ->get();
        $generalVisit = '';
        // dd($cekVisit);

        if(!$cekVisit->isEmpty()){
            $generalVisit = HeaderVisit::where('user_id', Auth::user()->id)
                            ->where('date', date('Y-m-d'))
                            ->get();
            
            return view('visit.create', compact('customer', 'reasons', 'generalVisit'));
        }
        
        $generalVisit = new HeaderVisit();
        $generalVisit->date = date('Y-m-d');
        $generalVisit->serial = $lastSerial->isEmpty() ? 1 : $lastSerial->serial+1;
        $generalVisit->time_in = date('H:i:s');
        $generalVisit->user_id = Auth::user()->id;
        $generalVisit->created_at = date('Y-m-d H:i:s');
        $generalVisit->save();

        return view('visit.create', compact('customer', 'reasons'));
    }

    public function store(Request $request, String $id){
        dd($request->all());
        // if(count($request->display) > count($request->category)){
        //     return 'display lebih besar dari kategori';
        // }else{
        //     return 'kategori lebih besar dari display';
        // }
    }
}
