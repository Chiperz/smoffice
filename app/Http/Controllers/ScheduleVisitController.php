<?php

namespace App\Http\Controllers;

use App\Models\ScheduleVisit;
use App\Models\Customer;
use App\Models\User;

use App\DataTables\ScheduleVisitDataTable;

use Illuminate\Http\Request;

class ScheduleVisitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ScheduleVisitDataTable $dataTable)
    {
        $users = User::all();

        return $dataTable->render('schedule-visit.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

    public function export(){

    }

    public function import(){
        
    }
}
