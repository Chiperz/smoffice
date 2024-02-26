<?php

namespace App\Http\Controllers;

use App\Models\Branch;

use App\Datatables\BranchDataTable;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BranchDataTable $dataTable)
    {
        return $dataTable->render('branch.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('branch.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required | max:5 | string',
            'name' => 'required | max:100 | string',
        ]);

        $branch = new Branch();
        $branch->code = $request->code;
        $branch->name = $request->name;
        $branch->notes = $request->notes;
        $branch->created_by = Auth::user()->id;
        $branch->save();

        toastr()->success('Cabang berhasil ditambahkan');

        return redirect()->route('branch.index');
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
        return view('branch.edit');
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
