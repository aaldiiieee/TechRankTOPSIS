<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class TechicianController extends Controller
{
    public function getCustomer() {
        $user = Auth::user();
        $customers = Customer::where('techID', $user->id)->get();

        return view('pages.customer.list-customer', ['customers' => $customers]);
    }
}
