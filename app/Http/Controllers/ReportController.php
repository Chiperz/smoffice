<?php

namespace App\Http\Controllers;

use App\Models\HeaderVisit;
use App\Models\User;
use App\Models\Foto;
use App\Models\Customer;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

use App\DataTables\UnproductiveVisitDataTable;
use App\DataTables\GiftingSampleDataTable;
use App\DataTables\SwitchingCustomerDataTable;

use App\Exports\UnproductiveReasonVisitExport;
use App\Exports\GiftingSampleCustomerExport;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function UnproductiveReason(UnproductiveVisitDataTable $dataTable)
    {
        $users = User::all();
        return $dataTable->render('report.unproductive-visit', compact('users'));
    }

    public function ExportUnproductiveReason(Request $request){
        return Excel::download(new UnproductiveReasonVisitExport($request->start_date, $request->end_date, $request->staff), 'Report Unproductive_Visit_'.date('d-M-Y H-i-s').'.xlsx');
    }

    public function GiftingCustomer(GiftingSampleDataTable $dataTable)
    {
        $users = User::all();
        return $dataTable->render('report.gifting-customer', compact('users'));
    }
    
    public function ExportGiftingCustomer(Request $request)
    {
        return Excel::download(new GiftingSampleCustomerExport($request->start_date, $request->end_date, $request->staff), 'Report Pengeluaran_Hadiah atau Sampel_'.date('d-M-Y H-i-s').'.xlsx');
    }

    public function ClaimVisitStaff(Request $request)
    {
        
    }

    public function ClaimVisitStaffPDF(Request $request)
    {
        // $visit = HeaderVisit::all();
        $summary = HeaderVisit::selectRaw(
                'header_visits.date as date,
                header_visits.user_id as user_id, 
                users.name as username,
                count(distinct header_visits.serial) as total_visit,
                count(case customers.type when "S" then 1 else NULL end) as store_visit,
                count(case customers.type when "O" then 1 else NULL end) as outlet_visit'
            )
            ->groupBy('header_visits.date', 'header_visits.user_id', 'users.name')
            ->join('users', 'header_visits.user_id', '=', 'users.id')
            ->join('customers', 'header_visits.customer_id', '=', 'customers.id')
            // ->whereBetween('date', [$from, $to])
            ->whereDate('date', date('Y-m-d'))
            ->orderBy('header_visits.date', 'DESC')->get();

        $data = HeaderVisit::
            // select('date','user_id', 'customer_id')
            // ->with(['user' => function($query){
            //     $query->select('user:id, name');
            // }])
            // ->with(['customer' => function($query){
            //     $query->select('customer:id','code','name','type');
            // }])
            select('date','user_id')
            ->with('user:id,name')
            ->with('customer:id,code,name,type')
            ->whereDate('date', date('Y-m-d'))
            ->groupBy('date','user_id')
            ->get();
        $foto = Foto::with('headerVisit')
            ->whereHas('headerVisit', function($query){
                $query->whereDate('date', date('Y-m-d'));
            })
            ->get();
        // $pdf = Pdf::loadView('report.print-pdf', ['data' => $summary])
        //     ->setPaper('A4', 'landscape');
        // dd($foto[0]->headerVisit->customer->type);

        // return $pdf->stream('testing-pdf_'.date('d-M-Y'), array("Attachment" => false));
        return view('report.print-pdf', compact('summary','data','foto'));
    }

    public function SwitchingCustomer(SwitchingCustomerDataTable $dataTable){
        $customers = Customer::all();
        return $dataTable->render('report.switching-customer', compact('customers'));
    }
}
