<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\HeaderVisit;
use App\Models\User;
use App\Models\Branch;

use App\Datatables\SummaryByBranchDataTable;
use App\Datatables\SummaryByAreaDataTable;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportSummaryController extends Controller
{
    public function summaryCustomer(SummaryByBranchDataTable $dataTable){
        return $dataTable->render('analyst.summary-by-branch');
    }

    public function summaryArea(string $id, SummaryByAreaDataTable $dataTable){
        $branchData = Branch::findOrFail($id);

        return $dataTable->render('analyst.summary-by-area', compact('branchData'));
    }
}
