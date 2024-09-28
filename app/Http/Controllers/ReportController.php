<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Customer;
use App\Models\User;
use App\Models\TechReport;
use App\Models\Report;

class ReportController extends Controller
{
    public function index($id) {
        $customerData = Customer::find($id);
        $techData = User::find($customerData->techID);
        $reportData = Report::where('customerID', $id)->first();
        $acDatas = TechReport::where('report_id', $reportData->id)->get();

        return view('pages.report.report-pdf', compact('customerData', 'techData', 'reportData', 'acDatas'));
    }

    public function generate($id) {
        $customerData = Customer::find($id);
        $techData = User::find($customerData->techID);
        $reportData = Report::where('customerID', $id)->first();
        $acDatas = TechReport::where('report_id', $reportData->id)->get();
        
        $pdf = Pdf::loadView('pages.report.report-pdf-dl', compact('customerData', 'techData', 'reportData', 'acDatas'))
            ->setPaper('a4', 'portrait');
        return $pdf->download($customerData->name . '_report.pdf');
    }
}
