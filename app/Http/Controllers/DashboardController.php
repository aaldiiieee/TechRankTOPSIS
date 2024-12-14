<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use App\Models\TechnicianScore;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // if ($user->hasRole('admin') or $user->hasRole('super_admin')) {
        //     $getRoleCounter = $this->countUsersByRole();
        //     $technicianScores = TechnicianScore::orderBy('rank', 'asc')->get();
        //     return view('pages.dashboard.dashboard', [
        //         'getRoleCounter' => $getRoleCounter,
        //         'technicianScores' => $technicianScores
        //     ]);
        // } elseif ($user->hasRole('user')) {
        //     $customersCount = Customer::where('techID', $user->id)->where('status', '!=', 'success')->count();
        //     $pendingTask = $this->countPendingTask($user->id);
        //     $successTask = $this->countSuccessTask($user->id);
        //     $technicianScores = TechnicianScore::orderBy('rank', 'asc')->get();

        //     return view('pages.dashboard.dashboard-technician', [
        //         'customersCount' => $customersCount,
        //         'successTask' => $successTask,
        //         'pendingTask' => $pendingTask,
        //         'technicianScores' => $technicianScores
        //     ]);
        // }

        if ($user->hasRole('admin') or $user->hasRole('super_admin')) {
            $getRoleCounter = $this->countUsersByRole();
            $userCount = $getRoleCounter['userCount'];
            $adminCount = $getRoleCounter['adminCount'];
            $superAdminCount = $getRoleCounter['superAdminCount'];
            $customerCount = $getRoleCounter['customerCount'];
            $technicianScores = TechnicianScore::orderBy('rank', 'asc')->get()->map(function ($score) {
                $score->avatar_url = 'https://api.dicebear.com/6.x/adventurer/svg?seed=' . urlencode($score->technician->name ?? uniqid());
                return $score;
            });
            
            return view('pages.dashboard.dashboard', [
                'userCount' => $userCount,
                'adminCount' => $adminCount,
                'superAdminCount' => $superAdminCount,
                'customerCount' => $customerCount,
                'technicianScores' => $technicianScores,
            ]);
        } elseif ($user->hasRole('user')) {
            $customersCount = Customer::where('techID', $user->id)->where('status', '!=', 'success')->count();
            $pendingTask = $this->countPendingTask($user->id);
            $successTask = $this->countSuccessTask($user->id);
            $technicianScores = TechnicianScore::orderBy('rank', 'asc')->get()->map(function ($score) {
                $score->avatar_url = 'https://api.dicebear.com/6.x/adventurer/svg?seed=' . urlencode($score->technician->name ?? uniqid());
                return $score;
            });

            return view('pages.dashboard.dashboard-technician', [
                'customersCount' => $customersCount,
                'successTask' => $successTask,
                'pendingTask' => $pendingTask,
                'technicianScores' => $technicianScores,
            ]);
        }
    }

    public function getDataChart()
    {
        $thisUser = Auth::user();
        $userCount = User::where('role', 'user')->count();
        $adminCount = User::where('role', 'admin')->count();
        $superAdminCount = User::where('role', 'super_admin')->count();
        $customerCount = Customer::count();
        $successTask = Customer::where('status', 'success')->count();

        if ($thisUser->role != 'user') {
            $successTaskPerDay = Customer::where('status', 'success')
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as task_count'))
                ->groupBy('date')
                ->orderBy('date', 'ASC')
                ->get();
        } else {
            $successTaskPerDay = Customer::where([['status', 'success'],['techID', $thisUser->id]])
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as task_count'))
                ->groupBy('date')
                ->orderBy('date', 'ASC')
                ->get();
        }

        // Formated success task per day
        $formattedSuccessTaskPerDay = $successTaskPerDay->map(function ($item) {
            $formattedDate = Carbon::parse($item->date)->translatedFormat('d M Y');
            return [
                'date' => $formattedDate,
                'task_count' => $item->task_count
            ];
        });
        
        return response()->json([
            'status' => 'success',
            'message' => 'Data retrieved successfully',
            'data' => [
                'total_users' => $userCount,
                'total_admins' => $adminCount,
                'total_super_admins' => $superAdminCount,
                'total_customers' => $customerCount,
                'success_task' => $successTask,
                'success_task_per_day' => $formattedSuccessTaskPerDay
            ]
        ]);
    }

    private function countUsersByRole()
    {
        $userCount = User::where('role', 'user')->count();
        $adminCount = User::where('role', 'admin')->count();
        $superAdminCount = User::where('role', 'super_admin')->count();
        $customerCount = Customer::count();

        return [
            'userCount' => $userCount,
            'adminCount' => $adminCount,
            'superAdminCount' => $superAdminCount,
            'customerCount' => $customerCount
        ];
    }

    private function countSuccessTask($tech_id)
    {
        $successTask = Customer::where([
            ['status', 'success'],
            ['techID', $tech_id]
        ])->count();
        
        return $successTask;
    }

    private function countPendingTask($tech_id)
    {
        $pendingTask = Customer::where([
            ['status', 'pending'],
            ['techID', $tech_id]
        ])->count();
        
        return $pendingTask;
    }
}
