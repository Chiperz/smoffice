<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\SubArea;
use App\Models\Branch;

use App\Datatables\SubAreaDataTable;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SubAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SubAreaDataTable $dataTable)
    {
        return $dataTable->render('subarea.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::all();
        $areas = Area::all();
        return view('subarea.create', compact('branches', 'areas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'branch' => 'required',
            'area' => 'required',
            'name' => 'required | max:200'
        ]);

        $subArea = new SubArea();
        $subArea->branch_id = $request->branch;
        $subArea->area_id = $request->area;
        $subArea->name = strtoupper($request->name);
        $subArea->save();

        toastr()->success('Sub Area berhasil ditambahkan');

        return redirect()->route('subarea.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubArea $subArea)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $branches = Branch::all();
        $areas = Area::all();
        $subarea = SubArea::findOrFail($id);

        return view('subarea.edit',compact('areas', 'branches','subarea'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'branch' => 'required',
            'area' => 'required',
            'name' => 'required | max:200'
        ]);

        $subArea = SubArea::findOrFail($id);
        $subArea->branch_id = $request->branch;
        $subArea->area_id = $request->area;
        $subArea->name = strtoupper($request->name);
        $subArea->save();

        toastr()->success('Sub Area berhasil diubah!');

        return redirect()->route('subarea.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subArea = SubArea::findOrFail($id);
        $subArea->delete();

        return response(['status' => 'success', 'message' => 'Sub Area berhasil dihapus']);
    }

    public function autocomplete(Request $request){
        $data = [];

        if($request->filled('q')){
            $data = SubArea::select('name', 'id', 'area_id')
                    ->where('name', 'LIKE', '%'.$request->get('q').'%')
                    ->get();
        }

        return response()->json($data);
    }
}
