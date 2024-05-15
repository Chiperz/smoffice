<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Branch;

use App\Datatables\AreaDataTable;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AreaDataTable $dataTable)
    {
        return $dataTable->render('area.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::all();
        return view('area.create', compact('branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'branch' => 'required',
            'name' => 'required | max:200'
        ]);

        $area = new Area();
        $area->branch_id = $request->branch;
        $area->name = strtoupper($request->name);
        $area->save();

        toastr()->success('Area berhasil ditambahkan');

        return redirect()->route('area.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Area $area)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $branches = Branch::all();
        $area = Area::findOrFail($id);

        return view('area.edit',compact('area', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $area = Area::findOrFail($id);

        $request->validate([
            'branch' => 'required',
            'name' => 'required | max:200'
        ]);

        $area->branch_id = $request->branch;
        $area->name = strtoupper($request->name);
        $area->save();

        toastr()->success('Area berhasil diubah');

        return redirect()->route('area.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $area = Area::findOrFail($id);
        $area->delete();

        return response(['status' => 'success', 'message' => 'Area berhasil dihapus']);
    }

    public function autocomplete(Request $request){
        $data = [];

        if($request->filled('q')){
            $data = Area::select('name', 'id', 'branch_id')
                    ->where('name', 'LIKE', '%'.$request->get('q').'%')
                    ->get();
        }

        return response()->json($data);
    }
}
