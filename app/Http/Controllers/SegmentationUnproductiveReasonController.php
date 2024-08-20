<?php

namespace App\Http\Controllers;

use App\Models\SegmentationUnproductiveReason;

use App\DataTables\SegmentationUnproductiveReasonDataTable;

use Illuminate\Http\Request;

class SegmentationUnproductiveReasonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SegmentationUnproductiveReasonDataTable $dataTable)
    {
        return $dataTable->render('segmentation.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('segmentation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required | max:100',
        ]);

        $segmentation = new SegmentationUnproductiveReason();
        $segmentation->name = $request->name;
        $segmentation->save();

        toastr()->success('Data berhasil ditambahkan!');

        return redirect()->route('segmentation-reason.index');
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
        $segmentation = SegmentationUnproductiveReason::findOrFail($id);

        return view('segmentation.edit', compact('segmentation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required | max:100',
        ]);

        $segmentation = SegmentationUnproductiveReason::findOrFail($id);
        $segmentation->name = $request->name;
        $segmentation->save();

        toastr()->success('Data berhasil ditambahkan!');

        return redirect()->route('segmentation-reason.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $segmentation = SegmentationUnproductiveReason::findOrFail($id);
        $segmentation->delete();

        return response(['status' => 'success', 'message' => 'Data berhasil dihapus!']);
    }
}
