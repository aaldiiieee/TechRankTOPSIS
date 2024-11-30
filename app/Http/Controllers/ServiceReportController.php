<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;
use App\Models\Report;
use App\Models\TechReport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReportMail;

class ServiceReportController extends Controller
{
    public function index($id) {
        $customerData = Customer::find($id);
        $techData = User::find($customerData->techID);
        
        return view('pages.report.report-technician', compact('customerData', 'techData'));
    }

    public function createReport(Request $request, $id)
    {
        $data = $request->all();
        $report_id = uuid_create();

        Report::create([
            'id' => $report_id,
            'customerID' => $id,
            'techID' => $request->input('techID'),
            'taskDate' => $request->input('taskDate'),
            'reportDate' => $request->input('reportDate'),
        ]);

        $imageData = $request->input("capturedPhotoInput");
        $imagePath = null;

        if ($imageData) {
            $imageData = str_replace('data:image/png;base64,', '', $imageData);
            $imageData = str_replace(' ', '+', $imageData);

            $image = base64_decode($imageData);

            $fileName = uniqid() . '.png';
            Storage::disk('public')->put('images/' . $fileName, $image);

            $imagePath = 'storage/images/' . $fileName;
        }

        TechReport::create([
            'report_id' => $report_id,
            'device' => $request->input('device'),
            'brand' => $request->input('brand'),
            'kerusakan' => $request->input('kerusakan'),
            'imageUrl' => $imagePath,
            'imageDesc' => $request->input('imageDesc'),
        ]);

        // Update customer status
        $customer = Customer::findOrFail($request->customerID);
        $customer->status = 'success';
        $customer->save();

        // Kirim email
        $feedbackUrl = url("/feedback/{$customer->id}"); // URL ke halaman feedback
        Mail::to($customer->email)->send(new ReportMail($customer, $feedbackUrl));

        return redirect('/customers')->with('success', 'Report saved and email sent successfully!');
    }
}
