<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Area;
use App\Models\User;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\HeaderVisit;

use Illuminate\Http\Request;
use App\Models\DetailStoreVisit;
use App\Charts\SummaryStoreBranch;
use Illuminate\Support\Facades\Auth;

use App\Datatables\SummaryByAreaDataTable;

use App\DataTables\StoreHasDisplayDataTable;
use App\Datatables\SummaryByBranchDataTable;
use App\Datatables\IncrementDisplayBranchDataTable;
use App\Datatables\SummaryUnproductiveReasonBranchDataTable;

class ReportSummaryController extends Controller
{
    public function summaryCustomer(SummaryByBranchDataTable $dataTable){
        return $dataTable->render('analyst.summary-by-branch');
    }

    public function summaryArea(string $id, SummaryByAreaDataTable $dataTable){
        $branchData = Branch::findOrFail($id);

        return $dataTable->render('analyst.summary-by-area', compact('branchData'));
    }

    public function summaryUnproductiveReasonBranch(SummaryUnproductiveReasonBranchDataTable $dataTable, string $branch){
        return $dataTable->render('analyst.summary-unproductive-by-branch');
    }

    public function trialReport(){
        $branches = Branch::all();
        // $visitToko = HeaderVisit::whereHas('customer', function($query){
        //     $query->where('type', 'S');
        // })->get();
        // $visitGerai = HeaderVisit::whereHas('customer', function($query){
        //     $query->where('type', 'O');
        // })->get();
        // dd($visitGerai);

        return view('analyst.summary-all-branch', compact('branches'));
    }

    public function summaryStore(
        string $id,
        string $dateFrom,
        string $dateTo,
        SummaryStoreBranch $summaryStoreBranch,
        IncrementDisplayBranchDataTable $dataTable
    ){
        $branch = Branch::findOrFail($id);
        $branches = Branch::all();
        $areas = Area::where('branch_id', $id)->get();
        $months = DetailStoreVisit::selectRaw('
                    monthname(detail_store_visits.created_at) as month_name,
                    month(detail_store_visits.created_at) as serial
                ')
                ->whereHas('header_visit', function($query) use ($id){
                    $query->whereHas('customer', function($q) use ($id){
                        $q->where('branch_id', $id);
                    });
                })
                ->whereBetween('detail_store_visits.created_at', [
                    $dateFrom,
                    $dateTo
                ])
                ->groupBy('month_name', 'serial')
                ->orderBy('serial', 'asc')
                ->get();
        $totalStore = $branch->customers()->where('type', 'S')->count();
        $storeHasDisplay = $branch->customers()->where('status_display', true)->count();
        $coverage = ($storeHasDisplay/$totalStore)*100;
        $visitedStore = $branch->customers()->where('type', 'S')->whereHas('visit', function($query){
                return $query->whereNotNull('time_out');
            })->count();
        // $notVisitedStore = $branch->customers()->where('type', 'S')->doesntHave('visit')->count();
        $notVisitedStore = $totalStore-$visitedStore;
        $visited = ($visitedStore/$totalStore)*100;

        
        return $dataTable->render(
            'analyst.summary-store', 
            [
                'summaryStoreBranch' => $summaryStoreBranch->build()
            ],
            compact(
                'branch',
                'branches',
                'totalStore',
                'storeHasDisplay',
                'coverage',
                'visitedStore',
                'notVisitedStore',
                'visited',
                'areas',
                'months'
            )
        );
    }

    public function summarySearchStore(Request $request){
        $id = $request->branch;
        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;

        return redirect()->route('summary-store', ['id' => $id, 'dateFrom' => $dateFrom, 'dateTo' => $dateTo]);
    }

    public function storeHasDisplay(StoreHasDisplayDataTable $dataTable,string $id){
        // dd($id);
        return $dataTable
            ->with('id', $id)
            ->render('analyst.store-has-display');
    }
}
