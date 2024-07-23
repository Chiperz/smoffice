<?php

namespace App\Http\Controllers;

use App\Models\ScheduleVisit;
use App\Models\DetailScheduleVisit;
use App\Models\Customer;
use App\Models\User;

use App\DataTables\ScheduleVisitDataTable;
use App\DataTables\DetailScheduleVisitDataTable;

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
        $users = User::all();

        return view('schedule-visit.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required | max:200 | unique:schedule_visits,name',
            'date_start' => 'required | date',
            'date_end' => 'required | date',
            'looping' => 'integer | nullable',
            'looping_type' => 'required',
            'user' => 'required'
        ]);

        $schedule = new ScheduleVisit();
        $schedule->name = $request->name;
        $schedule->date_start = $request->date_start;
        $schedule->date_end = $request->date_end;
        $schedule->looping = $request->looping;
        $schedule->looping_type = $request->looping_type;
        $schedule->user_id = $request->user;
        $schedule->save();

        toastr()->success('Jadwal kunjung berhasil dibuat');

        $scheduleId = ScheduleVisit::latest()->first();

        return redirect()->route('schedule-visit.show', $scheduleId->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, DetailScheduleVisitDataTable $dataTable)
    {
        $scheduleMaster = ScheduleVisit::findOrFail($id);

        return $dataTable->with('id', $id)->render('schedule-visit.detail', compact('scheduleMaster'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $schedule = ScheduleVisit::findOrFail($id);
        $users = User::all();

        return view('schedule-visit.edit', compact('schedule', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required | max:200 | unique:schedule_visits,name,'.$id,
            'date_start' => 'required | date',
            'date_end' => 'required | date',
            'looping' => 'integer | nullable',
            'looping_type' => 'required',
            'user' => 'required'
        ]);

        $schedule = ScheduleVisit::findOrFail($id);
        $schedule->name = $request->name;
        $schedule->date_start = $request->date_start;
        $schedule->date_end = $request->date_end;
        $schedule->looping = $request->looping;
        $schedule->looping_type = $request->looping_type;
        $schedule->user_id = $request->user;
        $schedule->save();

        toastr()->success('Jadwal kunjung berhasil dibuat');

        $scheduleId = ScheduleVisit::latest()->get();

        return redirect()->route('schedule-visit.show', $id);
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

    public function addDetailSchedule(Request $request, string $id){
        $request->validate([
            'customer' => 'required | array'
        ]);
        $schedule = ScheduleVisit::findOrFail($id);
        for($i=0;$i<count($request->customer);$i++){
            DetailScheduleVisit::create([
                'schedule_visit_id' => $schedule->id,
                'customer_id' => $request->customer[$i]
            ]);
        }
        
        toastr()->success('Pelanggan berhasil ditambahkan ke jadwal kunjung');

        return redirect()->route('schedule-visit.show', $id);
    }

    public function destroyDetailSchedule(Request $request, string $id){
        $detailSchedule = DetailScheduleVisit::findOrFail($id);
        $detailSchedule->delete();

        return response(['status' => 'success', 'message' => 'Detail jadwal kunjung berhasil dihapus']);
    }
}
