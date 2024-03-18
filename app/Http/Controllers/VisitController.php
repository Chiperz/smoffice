<?php

namespace App\Http\Controllers;

// Traits
use App\Traits\ImageUploadTraits;

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
use File;

class VisitController extends Controller
{
    use ImageUploadTraits;

    public function list(String $type){
        $customers = Customer::where('type', $type)->orderBy('code', 'ASC')->paginate(10);
        
        return view('visit.list', compact('customers'));
    }

    public function create(Request $request, $id){
        $customer = Customer::findOrFail($id);
        $reasons = UnproductiveReason::where('type', $customer->type)->get();
        $lastSerial = HeaderVisit::where('user_id', Auth::user()->id)
                        ->where('date', date('Y-m-d'))
                        ->orderBy('serial', 'DESC')
                        ->first();
        $cekVisit = HeaderVisit::where('user_id', Auth::user()->id)
                        ->where('date', date('Y-m-d'))
                        ->where('customer_id', $id)
                        ->where('time_out', NULL)
                        ->get();
        $generalVisit = '';
        // dd($lastSerial->serial);

        if(!$cekVisit->isEmpty()){
            $generalVisit = HeaderVisit::where('user_id', Auth::user()->id)
                            ->where('date', date('Y-m-d'))
                            ->where('customer_id', $id)
                            ->first();
                            // dd($generalVisit);
            
            return view('visit.create', compact('customer', 'reasons', 'generalVisit'));
        }else{
            $generalVisit = new HeaderVisit();
            $generalVisit->date = date('Y-m-d');
            $generalVisit->serial = empty($lastSerial) ? 1 : $lastSerial->serial+1;
            $generalVisit->time_in = date('H:i:s');
            $generalVisit->customer_id = $id;
            $generalVisit->user_id = Auth::user()->id;
            $generalVisit->created_at = date('Y-m-d H:i:s');
            $generalVisit->save();
            $generalVisit->get();
            // dd($generalVisit);

            return view('visit.create', compact('customer', 'reasons', 'generalVisit'));
        }
        
    }

    public function store(Request $request, String $id){
        $request->validate([
            'photo_visit' => 'required | image | mimes:jpeg,jpg,png',
            'activity' => 'required',
            'banner' => 'required'
        ]);
        
        // dd($request->lat);

        $generalVisit = HeaderVisit::findOrFail($id);
        $customer = Customer::findOrFail($id);
        
        if(empty($customer->LA) && empty($customer->LA)){
            $customer->LA = $request->lat;
            $customer->LO = $request->lon;
            $customer->save();
        }

        if($customer->type == 'O'){
            $customer->status_registration = $request->status;
            $customer->save();
        }

        if(empty($customer->photo) && !empty($request->photo_visit)){
            $imagePath = $this->updateImage($request, date('d-M-Y His'), $customer->code, $customer->name, 'photo_visit', 'uploads/customer/');
            $customer->photo = empty(!$imagePath) ? $imagePath : $customer->photo;
            $customer->save();
        }

        $generalVisit->time_out = date('H:i:s');
        $generalVisit->LA = $request->lat;
        $generalVisit->LO = $request->lon;
        $generalVisit->banner = $request->banner;
        $generalVisit->status_registration = empty($request->status) ? 'N' : $request->status;
        $generalVisit->activity = $request->activity;
        $generalVisit->note = $request->note;
        $generalVisit->updated_at = date('Y-m-d H:i:s');
        $generalVisit->save();

        if(count($request->display) > count($request->category)){
            // for($i=0;$i<=count($request->category);$i++){
            //     $detailStoreVisit = DetailStoreVisit::insert([
            //         'header_visit_id' => $id, 
            //         'category_product_id' => empty($request->category[$i]) ? $request->category[$i-1] : $request->category[$i],
            //         'display_product_id' => $request->display[$i]
            //     ]);
            // }
            foreach($request->display as $number => $row){
                $detailStoreVisit = DetailStoreVisit::insert([
                    'header_visit_id' => $id,
                    'category_product_id' => empty($request->category[$number]) ? $request->category[$number-1] : $request->category[$number],
                    'display_product_id' => $row
                ]);
            }
        }else{
            // for($i = 0; $i<=count($request->category);$i++){
            //     $detailStoreVisit = DetailStoreVisit::insert([$id, $request->category[$i], empty($request->display[$i]) ? $request->display[$i-1] : $request->display[$i]]);
            // }
            foreach($request->category as $number => $row){
                $detailStoreVisit = DetailStoreVisit::insert([
                    'header_visit_id' => $id,
                    'category_product_id' => $row,
                    'display_product_id' => empty($request->display[$number]) ? $request->display[$number-1] : $request->display[$number]
                ]);
            }
        }

        foreach($request->brand as $row){
            $storeVisitBrand = StoreVisitBrand::insert([
                'header_visit_id' => $id,
                'brand_product_id' => $row
            ]);
        }

        foreach($request->reason as $row){
            $storeVisitUnproductiveReason = StoreVisitUnproductiveReason::insert([
                'header_visit_id' => $id,
                'unproductive_reason_id' => $row
            ]);
        }

        if(!empty($request->photo_visit)){
            $imagePathVisit = $this->uploadImage($request, date('d-M-Y His'), $request->code, $request->name, 'photo', 'uploads/visit/');

            $fotoVisit = Foto::insert([
                'header_visit_id' => $id,
                'file_name' => $imagePathVisit,
                'file_size' => '',
                'type' => 'V'
            ]);
        }

        if(!empty($request->photo_display)){
            $imagePathDisplay = $this->uploadImage($request, date('d-M-Y His'), $request->code, $request->name, 'photo', 'uploads/display/');

            $fotoDisplay = Foto::insert([
                'header_visit_id' => $id,
                'file_name' => $imagePathDisplay,
                'file_size' => '',
                'type' => 'D'
            ]);
        }

        toastr()->success('Data kunjungan berhasil disimpan');
        
        return redirect()->route('dashboard');
    }
}
