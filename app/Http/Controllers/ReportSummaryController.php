<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\HeaderVisit;
use App\Models\User;
use App\Models\Branch;

use App\Datatables\SummaryByBranchDataTable;
use App\Datatables\SummaryByAreaDataTable;
use App\Datatables\SummaryUnproductiveReasonBranchDataTable;

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

    public function summaryStore(string $id,SummaryStoreBranch $summaryStoreBranch){
        $branch = Branch::findOrFail($id);

        return view('analyst.summary-store', [
            'summaryStoreBranch' => $summaryStoreBranch->build()
        ],compact(
            'branch'
        )
        );
    }
}
