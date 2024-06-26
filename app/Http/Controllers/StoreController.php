<?php

namespace App\Http\Controllers;

use App\Traits\ImageUploadTraits;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\Owner;
use App\Models\Area;
use App\Models\SubArea;

use App\Datatables\StoreDataTable;
use App\Datatables\StoreTrashedDataTable;

use App\Exports\StoreExport;
use App\Imports\StoreImport;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Maatwebsite\Excel\Facades\Excel;
use File;

class StoreController extends Controller
{
    use ImageUploadTraits;
    /**
     * Display a listing of the resource.
     */
    public function index(StoreDataTable $dataTable)
    {
        $branches = Branch::all();
        $areas = Area::all();
        $subAreas = SubArea::all();

        return $dataTable->render('store.index', compact('branches','areas','subAreas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::all();
        $areas = Area::all();
        $subAreas = SubArea::all();

        return view('store.create', compact('branches','areas','subAreas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required | string',
            'photo' => 'image | mimes:jpeg,jpg,png',
            'regist' => 'required',
            'branch' => 'required | integer',
        ]);
        $code='';$area='';$subArea='';

        if(empty($request->code)){
            $codeBranch = Branch::findOrFail($request->branch)->code;
            $lastCodeCustomer = Customer::orderBy('code', 'desc')->where('code', 'LIKE', '%'.$codeBranch.'%')->first();

            if(empty($lastCodeCustomer)){
                $code = $codeBranch.'001';
            }else{
                $lastDigit = intval(substr($lastCodeCustomer->code,3));
                if($lastDigit < 10){
                    if($lastDigit == 0){
                        $generator = '001';    
                    }else{
                        $generator = '00'.$lastDigit+1;
                    }
                }elseif($lastDigit >= 10 && $lastDigit <100){
                    $generator = '0'.$lastDigit+1;
                }else{
                    $generator = $lastDigit+1;
                }
                $code = $codeBranch.$generator;
            }

            $cekCode = Customer::where('code', $code)->first();
            if(!empty($cekCode)){
                $lastDigit = intval(substr($cekCode->code,3));
                    if($lastDigit < 10){
                        if($lastDigit == 0){
                            $generator = '001';    
                        }else{
                            $generator = '00'.$lastDigit+1;
                        }
                    }elseif($lastDigit >= 10 && $lastDigit <100){
                        $generator = '0'.$lastDigit+1;
                    }else{
                        $generator = $lastDigit+1;
                    }
                    $code = $codeBranch.$generator;
            }
        }else{
            $code = $request->code;
        }

        $areaId = Area::where('name', $request->area)->first();
        $subAreaId = SubArea::where('name',$request->subarea)->first();
        if(empty($areaId)){
            Area::create([
                'branch_id' => $request->branch,
                'name' => strtoupper($request->area)
            ]);
            $area = Area::latest()->first();
        }else{
            $area = $areaId;
        }

        if(empty($subAreaId)){
            SubArea::create([
                'branch_id' => $request->branch,
                'area_id' => is_numeric($request->area) ? $request->area : $area->id,
                'name' => strtoupper($request->subarea)
            ]);
            $subArea = SubArea::latest()->first();
        }else{
            $subArea = $subAreaId;
        }

        $customer = new Customer();
        $imagePath = $this->uploadImage($request, date('d-M-Y His'), $code, $request->customer_name, 'photo', 'uploads/customer/');
        $customer->code = str_replace('/', ' - ',$code);
        $customer->name = str_replace('/', ' - ',$request->customer_name);
        $customer->phone = $request->customer_phone;
        $customer->photo = $imagePath;
        $customer->address = $request->customer_address;
        $customer->LA = $request->la;
        $customer->LO = $request->lo;
        $customer->area_id = is_numeric($request->area) ? $request->area : $area->id;
        $customer->sub_area_id = is_numeric($request->subarea) ? $request->subarea : $subArea->id;
        $customer->status_registration = $request->regist;
        $customer->type = 'S';
        $customer->banner = empty($request->banner) ? 0 : $request->banner;
        $customer->branch_id = $request->branch;
        $customer->created_by = Auth::user()->id;
        $customer->save();

        if(empty($request->owner_name)){
            toastr()->warning('Toko yang ditambahkan tidak memiliki data pemilik');
            toastr()->success('Toko berhasil ditambahkan');

            return redirect()->route('store.index');
        }

        $owner = New Owner();
        $idCust = Customer::where('code', $code)->first()->id;
        $owner->name = $request->owner_name;
        $owner->nik = $request->nik;
        $owner->phone = $request->owner_phone;
        $owner->address = $request->owner_address;
        $owner->customer_id = $idCust;
        $owner->created_by = Auth::user()->id;
        $owner->save();

        toastr()->success('Toko berhasil ditambahkan');
        
        return redirect()->route('store.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $branches = Branch::all();
        $customer = Customer::findOrFail($id);
        $owner = Owner::where('customer_id', $id)->first();
        // dd($owner);

        return view('store.edit', compact('customer', 'branches', 'owner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'customer_name' => 'required | string',
            'photo' => 'image | mimes:jpeg,jpg,png',
            'regist' => 'required',
        ]);
        $area='';$subArea='';

        $areaId = Area::where('name', $request->area)->first();
        $subAreaId = SubArea::where('name',$request->subarea)->first();
        if(empty($areaId)){
            Area::create([
                'branch_id' => $request->branch,
                'name' => strtoupper($request->area)
            ]);
            $area = Area::latest()->first();
        }else{
            $area = $areaId;
        }

        if(empty($subAreaId)){
            SubArea::create([
                'branch_id' => $request->branch,
                'area_id' => is_numeric($request->area) ? $request->area : $area->id,
                'name' => strtoupper($request->subarea)
            ]);
            $subArea = SubArea::latest()->first();
        }else{
            $subArea = $subAreaId;
        }

        $customer = Customer::findOrFail($id);
        $imagePath = $this->updateImage($request, date('d-M-Y His'), $request->code, $request->customer_name, 'photo', 'uploads/customer/');
        $customer->name = str_replace('/',' - ',$request->customer_name);
        $customer->phone = $request->customer_phone;
        $customer->photo = empty(!$imagePath) ? $imagePath : $customer->photo;
        $customer->address = $request->customer_address;
        $customer->LA = $request->la;
        $customer->LO = $request->lo;
        $customer->area_id = is_numeric($request->area)  ? $request->area : $area->id;
        $customer->sub_area_id = is_numeric($request->subarea) ? $request->subarea : $subArea->id;
        $customer->status_registration = $request->regist;
        $customer->type = 'S';
        $customer->banner = empty($request->banner) ? 0 : $request->banner;
        $customer->branch_id = $request->branch;
        $customer->updated_by = Auth::user()->id;
        $customer->save();

        if(empty($request->owner_name)){
            toastr()->warning('Toko yang ditambahkan tidak memiliki data pemilik');
            toastr()->success('Toko berhasil ditambahkan');

            return redirect()->route('store.index');
        }

        $owner = Owner::where('customer_id', $id)->first();
        $owner->name = $request->owner_name;
        $owner->nik = $request->nik;
        $owner->phone = $request->owner_phone;
        $owner->address = $request->owner_address;
        $owner->customer_id = $id;
        $owner->updated_by = Auth::user()->id;
        $owner->save();

        toastr()->success('Toko berhasil ditambahkan');
        
        return redirect()->route('store.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);
        $owner = Owner::where('customer_id', $id)->first();
        // $this->deleteImage($product->image);
        $customer->deleted_by = Auth::user()->id;
        if(!empty($owner)){
            $owner->deleted_by = Auth::user()->id;
            $owner->save();
            $owner->delete();
        }
        $customer->save();
        $customer->delete();

        return response(['status' => 'success', 'message' => 'Toko berhasil dihapus']);
    }

    public function trashed(StoreTrashedDataTable $dataTable){
        return $dataTable->render('store.trashed');
    }

    public function restore($id){

        $customer = Customer::onlyTrashed()->findOrFail($id);
        $owner = Owner::onlyTrashed()->where('customer_id',$id)->first();
        $customer->deleted_by = NULL;
        $owner->deleted_by = NULL;
        $customer->save();
        $owner->save();
        $customer->restore();
        $owner->restore();

        toastr()->success('Toko berhasil dikembalikan');

        return redirect()->route('store.trashed');
    }

    public function forceDelete($id){
        
        $customer = Customer::onlyTrashed()->findOrFail($id);
        $owner = Owner::onlyTrashed()->where('customer_id', $id)->first();
        // return $customer->photo;
        !empty($customer->photo) ? $this->deleteImage($customer->photo) : '';
        !empty($owner) ? $owner->forceDelete() : '';
        $customer->forceDelete();

        return response(['status' => 'success', 'message' => 'Toko berhasil dihapus permanen']);
    }

    public function export(){
        return Excel::download(new StoreExport, 'Ekspor Toko_'.date('d-M-Y H-i-s').'.xlsx');
    }

    public function import(Request $request){
        $request->validate([
            'import' => 'required | file',
        ]);
        Excel::import(new StoreImport, $request->file('import'));

        toastr()->success('Data toko berhasil diimpor');
        return redirect()->back();
    }

    public function downloadFormatImport($file_name){
        $file_path = public_path('format/'.$file_name);
        return response()->download($file_path);
    }

    public function autocomplete(Request $request){
        $data = [];

        if($request->filled('q')){
            $data = Customer::select('name', 'id', 'address')
                    ->where('name', 'LIKE', '%'.$request->get('q').'%')
                    ->where('type', 'S')
                    ->get();
        }

        return response()->json($data);
    }

    public function customerAutocomplete(Request $request){
        $data = [];

        if($request->filled('q')){
            $data = Customer::select('name','code' ,'id', 'address')
                    ->where('name', 'LIKE', '%'.$request->get('q').'%')
                    ->orWhere('code', 'LIKE', '%'.$request->get('q').'%')
                    ->get();
        }

        return response()->json($data);
    }
}
