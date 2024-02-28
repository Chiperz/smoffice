<?php

namespace App\Http\Controllers;

use App\Traits\ImageUploadTraits;

use App\Models\Branch;
use App\Models\Customer;

use App\Datatables\CustomerDataTable;
use App\Datatables\CustomerTrashedDataTable;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CustomerDataTable $dataTable)
    {
        return $dataTable->render('customer.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::all();

        return view('customer.create', compact('branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_customer' => 'required | string',
            'photo' => 'image | mimes:jpeg,jpg,png',
            'regist' => 'required',
            'type' => 'required',
            'branch' => 'required | integer',
        ]);

        if(empty($request->code)){
            $codeBranch = Branch::findOrFail($request->branch)->code;
            $lastCodeCustomer = Customer::orderBy('code', 'desc')->where('code', 'LIKE', '%'.$codeBranch.'%')->first();

            if(empty($lastCodeCustomer)){
                $request->code = $codeBranch.'001';
            }else{
                $lastDigit = intval(substr($lastCodeCust->code,3));
                if($lastDigit < 10){
                    $generator
                }
            }
        }

        if(empty($request->name_owner)){
            $request->competitor = 0;
        }

        // $product = new Product();

        // // HANDLING FILE UPLOAD(IMAGE)
        // $imagePath = $this->uploadImage($request, date('d-M-Y H:i:s'), $request->code, $request->name, 'image', 'uploads/product/');
        // // dd($imagePath);
        // $product->image = $imagePath;
        // $product->code = $request->code;
        // $product->name = $request->name;
        // $product->description = $request->description;
        // $product->competitor = $request->competitor;
        // $product->competitor_name = $request->competitor_name;
        // $product->category_product_id = $request->category;
        // $product->brand_product_id = $request->brand;
        // $product->sub_brand_product_id = $request->sub_brand;
        // $product->created_by = Auth::user()->id;
        // $product->save();

        // toastr()->success('Produk berhasil ditambahkan');
        
        // return redirect()->route('product.index');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
