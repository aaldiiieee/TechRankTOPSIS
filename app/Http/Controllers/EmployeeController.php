<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        $employee = new User();
        return view('pages.employee.add-employee', compact('employee'));
    }

    public function createEmployee(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // 'phone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:super_admin,admin,user',
        ]);

        $user = new User();
        $user->name = $request->input('name');
        // $user->phone = $request->input('phone');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->role = $request->input('role');
        $user->save();

        return redirect('/add-employee')->with('success', 'Employee created successfully!');
    }

    public function showEmployee()
    {
        $users = User::all();
        return view('pages.employee.list-employee', compact('users'));
    }

    public function updateEmployee(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect('/list-employee')->with('error', 'Employee not found!');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            // 'phone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:super_admin,admin,user',
        ]);

        $user->name = $request->input('name');
        // $user->phone = $request->input('phone');
        $user->email = $request->input('email');
        $user->role = $request->input('role');

        $user->save();

        return redirect('/list-employee')->with('success', 'Employee updated successfully!');
    }

    public function deleteEmployee($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
            return response()->json(['success' => true, 'message' => 'Employee deleted successfully!']);
        } else {
            return response()->json(['error' => false, 'message' => 'Employee not found!'], 404);   
        }
    }
}
