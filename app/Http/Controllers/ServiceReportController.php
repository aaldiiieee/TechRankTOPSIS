<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;
use App\Models\Report;
use App\Models\TechReport;
use Illuminate\Support\Facades\Storage;

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
            'brand' => $request->input('brand'),
            'service_type' => $request->input('serviceType'),
            'payment_method' => $request->input('paymentMethod'),
            'imageUrl' => $imagePath,
            'imageDesc' => $request->input('imageDesc'),
        ]);

        $customer = Customer::findOrFail($request->customerID);
        $customer->status = 'success';
        $customer->save();

        return redirect()->back()->with('success', 'Report saved successfully!');
    }
}
