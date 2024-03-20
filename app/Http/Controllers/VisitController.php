<?php

namespace App\Http\Controllers;

// Traits
use App\Traits\ImageUploadTraits;

// Datatable
use App\Datatables\SummaryVisitDatatable;
use App\Datatables\BreakdownVisitDailyDatatable;

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

        $generalVisit = HeaderVisit::findOrFail($id);
        $customer = Customer::findOrFail($request->id_customer);
        
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

        if(!empty($request->photo_visit)){
            $imagePathVisit = $this->uploadImage($request, date('d-M-Y His'), $request->code, $request->name, 'photo_visit', 'uploads/visit/');

            $fotoVisit = Foto::insert([
                'header_visit_id' => $id,
                'file_name' => $imagePathVisit,
                'file_size' => '',
                'type' => 'V',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        if(!empty($request->other_reason)){
            $unproductiveReason = UnproductiveReason::insert([
                'name' => strtolower($request->name_other_reason),
                'type' => $customer->type,
                'created_by' => Auth::user()->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            $lastUnproductive = UnproductiveReason::latest()->first();
            $storeVisitUnproductiveReason = StoreVisitUnproductiveReason::insert([
                'header_visit_id' => $id,
                'unproductive_reason_id' => $lastUnproductive->id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

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

        if($customer->type == 'S'){
            if(count($request->display) > count($request->category)){
                foreach($request->display as $number => $row){
                    $detailStoreVisit = DetailStoreVisit::insert([
                        'header_visit_id' => $id,
                        'category_product_id' => empty($request->category[$number]) ? $request->category[$number-1] : $request->category[$number],
                        'display_product_id' => $row,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }else{
                foreach($request->category as $number => $row){
                    $detailStoreVisit = DetailStoreVisit::insert([
                        'header_visit_id' => $id,
                        'category_product_id' => $row,
                        'display_product_id' => empty($request->display[$number]) ? $request->display[$number-1] : $request->display[$number],
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }

            foreach($request->brand as $row){
                $storeVisitBrand = StoreVisitBrand::insert([
                    'header_visit_id' => $id,
                    'brand_product_id' => $row,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }

            foreach($request->reason as $row){
                $storeVisitUnproductiveReason = StoreVisitUnproductiveReason::insert([
                    'header_visit_id' => $id,
                    'unproductive_reason_id' => $row,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }

            if(!empty($request->photo_display)){
                $imagePathDisplay = $this->uploadImage($request, date('d-M-Y His'), $request->code, $request->name, 'photo_display', 'uploads/display/');

                $fotoDisplay = Foto::insert([
                    'header_visit_id' => $id,
                    'file_name' => $imagePathDisplay,
                    'file_size' => '',
                    'type' => 'D',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }

            toastr()->success('Data kunjungan toko berhasil disimpan');
            
            return redirect()->route('dashboard');
        }else{
            // dd($request->all());
            $detailOutletVisit = new DetailOutletVisit();
            $detailOutletVisit->header_visit_id = $id;
            $detailOutletVisit->sales_amount = $request->sales_amount;
            $detailOutletVisit->customer_id = $request->store;
            $detailOutletVisit->store_name = $request->store_name;
            $detailOutletVisit->market_name = $request->market_name;
            $detailOutletVisit->mark = $request->mark;
            $detailOutletVisit->created_at = date('Y-m-d H:i:s');
            $detailOutletVisit->updated_at = date('Y-m-d H:i:s');
            $detailOutletVisit->save();

            $purchaseAmount = explode(',', $request->purchaseAmount);
            $qtySample = explode(',', $request->qty_sample);

            if(!empty($request->usedProduct)){
                foreach($request->usedProduct as $number => $row){
                    $outletVisitProduct = OutletVisitProduct::insert([
                        'header_visit_id' => $id,
                        'product_id' => $row,
                        'purchase_price' => $purchaseAmount[$number],
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }

            foreach($request->reason as $number => $row){
                $outletVisitUnproductiveReason = OutletVisitUnproductiveReason::insert([
                    'header_visit_id' => $id,
                    'unproductive_reason_id' => $row,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }

            foreach($request->sample as $number => $row){
                $detailGiftVisit = DetailGiftVisit::insert([
                    'header_visit_id' => $id,
                    'product_id' => $row,
                    'qty' => $qtySample[$number],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }

            toastr()->success('Data kunjungan gerai berhasil disimpan');
            
            return redirect()->route('dashboard');
        }
    }

    public function SummaryVisit(SummaryVisitDatatable $dataTable){
        return $dataTable->render('visit.summary');
    }

    public function DailyVisit(BreakdownVisitDailyDatatable $dataTable, $date, $user){
        // return $date.$user;
        $headerVisit = HeaderVisit::where('date', $date)->where('user_id', $user)->first();
        return $dataTable->with(['date' => $date, 'user' => $user])->render('visit.daily', compact('headerVisit'));
    }
}
