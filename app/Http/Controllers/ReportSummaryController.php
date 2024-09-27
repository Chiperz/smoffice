<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Area;
use App\Models\User;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\HeaderVisit;

use Illuminate\Http\Request;
use App\Models\DisplayProduct;
use App\Models\DetailStoreVisit;
use App\Charts\SummaryStoreBranch;

use Illuminate\Support\Facades\Auth;

use App\Datatables\SummaryByAreaDataTable;
use App\DataTables\StoreHasDisplayDataTable;
use App\Datatables\SummaryByBranchDataTable;
use App\Datatables\IncrementDisplayBranchDataTable;
use App\DataTables\SummaryStoreHasDisplayDataTable;
use App\DataTables\SummaryStoreHasVisitedDataTable;
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

    public function SummaryAllBranch(){
        $branches = Branch::all();

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
        $accurate = ($storeHasDisplay/$visitedStore)*100;
        
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
                'months',
                'accurate'
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
        $area = Area::findOrFail($id);
        $totalStore = $area->customer()->count();
        $storeHasDisplay = $area->customer()->where('status_display', true)->count();
        $precentageDisplay = $storeHasDisplay == 0 ? 0 : ($storeHasDisplay/$totalStore)*100;
        $display = DisplayProduct::whereHas('visit', function ($query){
            return $query->whereHas('header_visit', function($q){
                return $q->with('customer');
            });
        })->latest()->get();
        // $customerHasManyDisplay = Customer::where('type', 'S')
        //     ->where('area_id', $id)
        //     ->distinct()
        //     ->with('visit')
        //     ->whereHas('visit', function($query){
        //         return $query->with('detail_store')
        //         ->whereHas('detail_store', function($q){
        //             return $q->whereNotNull('display_product_id');
        //         });
        //     })
        //     ->get();
        // dd($customerHasManyDisplay);
        return $dataTable
            ->with('id', $id)
            ->render('analyst.store-has-display', 
            compact(
                'area',
                'totalStore',
                'storeHasDisplay',
                'precentageDisplay',
                'display'
            ));
    }

    public function summaryStoreHasDisplay(SummaryStoreHasDisplayDataTable $dataTable,string $id){
        $branch = Branch::findOrFail($id);
        $totalStore = $branch->customers()->where('type', 'S')->count();
        $area = Area::where('branch_id', $id)->get('id');
        $totalStoreHasDisplay = $branch->customers()
            ->where('status_display', true)
            ->count();
        $totalStoreArea = Customer::where('type', 'S')
            ->where('status_display', true)
            ->where('branch_id', $id)
            ->whereIn('area_id', $area)
            ->count();
        $totalStoreNotArea = $totalStoreHasDisplay - $totalStoreArea;
        $coverage = ($totalStoreHasDisplay/$totalStore)*100;
        return $dataTable
            ->with('id', $id)
            ->render('analyst.summary-store-has-display', compact([
                'branch',
                'totalStoreHasDisplay',
                'totalStore',
                'totalStoreNotArea',
                'coverage'
            ]));
    }

    public function summaryStoreHasVisited(SummaryStoreHasVisitedDataTable $dataTable, string $id){
        $branch = Branch::findOrFail($id);
        $totalStore = $branch->customers()->where('type', 'S')->count();
        $visitedStore = $branch->customers()->where('type', 'S')->whereHas('visit', function($query){
            return $query->whereNotNull('time_out');
        })->count();
        $visited = ($visitedStore/$totalStore)*100;
        $notVisitedStore = $branch->customers()->where('type', 'S')->whereDoesntHave('visit')->count();
        $notEfectiveVisit = $branch->customers()->where('type', 'S')->whereHas('visit', function($query){
            return $query->whereNull('time_out');
        })->count();
        return $dataTable
            ->with('id', $id)
            ->render('analyst.summary-store-has-visited', compact(
                'branch',
                'totalStore',
                'visitedStore',
                'visited',
                'notVisitedStore',
                'notEfectiveVisit'
            ));
    }
}
