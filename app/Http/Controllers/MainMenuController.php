<?php

namespace App\Http\Controllers;

use App\Models\MainMenu;

use App\Datatables\MainMenuDataTable;
use App\Datatables\MainMenuTrashedDataTable;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MainMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(MainMenuDataTable $dataTable)
    {
        return $dataTable->render('main_menu.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('main_menu.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required | max:50',
            'serial' => 'required'
        ]);

        $mainMenu = new MainMenu();
        $mainMenu->title = $request->title;
        $mainMenu->icon = $request->icon;
        $mainMenu->url = $request->url;
        $mainMenu->parent = $request->parent;
        $mainMenu->show = $request->show;
        $mainMenu->serial = $request->serial;
        $mainMenu->created_by = Auth::user()->id;
        $mainMenu->created_at = date('Y-m-d H:i:s');
        $mainMenu->save();

        toastr()->success('Main Menu berhasil dibuat');

        return redirect()->route('main_menu.index');
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
