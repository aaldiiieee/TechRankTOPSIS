<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;

class CustomerController extends Controller
{
    public function index() {
        $customers = Customer::all();
        $technicians = User::where('role', 'user')->get();
        return view('pages.customer.list-customer', compact('customers'), compact('technicians'));
    }

    public function create() {
        return view('pages.customer.add-customer');
    }

    public function store(Request $request) {
        $request -> validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255',
            'purpose' => 'required|string|max:255'
        ]);

        $customer = new Customer();
        $customer->id = uuid_create();
        $customer->name = $request->input('name');
        $customer->address = $request->input('address');
        $customer->phone = $request->input('phone');
        $customer->email = $request->input('email');
        $customer->purpose = $request->input('purpose');
        $customer->techID = "";
        $customer->techName = "";
        $customer->save();

        return redirect('/add-customer')->with('success', 'Customer created successfully!');
    }

    public function updateTech(Request $request, $id) {
        $customer = Customer::find($id);
        $technician = User::find($request->input('techid'));

        if ($customer && $technician) {
            $customer->techID = $request->input('techid');
            $customer->techName = $technician->name;
            $customer->save();
            return response()->json(['success' => true, 'message' => 'Technician choosing successfully!']);
        } else {
            return response()->json(['error' => false, 'message' => 'Customer not found!'], 404);
        }
    }

    public function destroy($id) {
        $customer = Customer::find($id);

        if ($customer) {
            $customer->delete();
            return response()->json(['success' => true, 'message' => 'Customer deleted succsesfully!']);
        } else {
            return response()->json(['error' => false, 'message' => 'Customer not found!'], 404);
        }
    }
}
