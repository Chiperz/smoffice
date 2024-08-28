<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\HeaderVisit;
use App\Models\User;
use App\Models\Branch;
use App\Models\Area;
use App\Models\DetailStoreVisit;

use App\Datatables\SummaryByBranchDataTable;
use App\Datatables\SummaryByAreaDataTable;
use App\Datatables\SummaryUnproductiveReasonBranchDataTable;
use App\Datatables\IncrementDisplayBranchDataTable;

use App\Charts\SummaryStoreBranch;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

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
        // $detailDisplay = DetailStoreVisit::selectRaw('
        //         areas.name as area_name,
        //         month(detail_store_visits.created_at) as no,
        //         monthname(detail_store_visits.created_at) as month,
        //         COUNT(detail_store_visits.display_product_id) as count_diplay
        //     ')
        //     ->join('header_visits', 'header_visits.id', 'detail_store_visits.header_visit_id')
        //     ->join('customers', 'customers.id', 'header_visits.customer_id')
        //     ->join('branches', 'branches.id', 'customers.branch_id')
        //     ->join('areas', 'areas.id', 'customers.area_id')
        //     ->whereHas('header_visit', function($query) use ($id){
        //         $query->whereHas('customer', function($q) use ($id){
        //             $q->where('branch_id', $id);
        //         });
        //     })
        //     ->groupBy('area_name', 'no', 'month')
        //     ->get();
        // dd($months);
        
        return $dataTable->render(
            'analyst.summary-store', 
            [
                'summaryStoreBranch' => $summaryStoreBranch->build()
            ],
            compact(
                'branch',
                'branches',
                // 'detailDisplay',
                'areas',
                'months'
            )
        );

        // return view('analyst.summary-store', [
        //     'summaryStoreBranch' => $summaryStoreBranch->build()
        // ],compact(
        //     'branch',
        //     'branches'
        // )
        // );
    }

    public function summarySearchStore(Request $request){
        $id = $request->branch;
        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;

        return redirect()->route('summary-store', ['id' => $id, 'dateFrom' => $dateFrom, 'dateTo' => $dateTo]);
    }
}
