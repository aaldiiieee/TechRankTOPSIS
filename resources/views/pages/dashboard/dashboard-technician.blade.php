@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard Teknisi</h1>
</div>

<div class="row">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Tugas
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $customersCount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-tasks fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Tugas Belum Selesai
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingTask }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Tugas Selesai
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $successTask }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">

    <!-- Area Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-area" id="chatArea">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Pie Chart -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Data Anggota</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2" id="chatArea">
                    <canvas id="myPieChart"></canvas>
                </div>
                <div class="mt-4 text-center small">
                    <span class="mr-2">
                        <i class="fas fa-circle text-primary"></i> Admin
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-success"></i> Teknisi
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Technician Scores</h6>
            </div>
            <div class="table-responsive">
                <table class="table project-list-table table-nowrap align-middle table-borderless">
                    <thead>
                        <tr class="shadow">
                            <th scope="col">Rank</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($technicianScores as $score)
                            <tr class="shadow">
                                <td>{{ $score->rank }}</td>
                                <td>
                                    <img src="{{ $score->avatar_url }}" alt="Avatar Icon" class="avatar-sm rounded-circle me-2" />
                                    <a href="#" class="text-body">{{ $score->technician->name ?? 'N/A' }}</a>
                                </td>
                                <td><span class="badge badge-soft-success mb-0">{{ $score->technician->email ?? 'N/A' }}</span></td>
                                <td>
                                    @php
                                        $badgeClass = '';
                                        if ($score->score <= 0.4) {
                                            $badgeClass = 'badge-soft-danger';
                                        } elseif ($score->score > 0.4 && $score->score <= 0.7) {
                                            $badgeClass = 'badge-soft-warning';
                                        } else {
                                            $badgeClass = 'badge-soft-success';
                                        }
                                    @endphp
                                    <span class="badge {{ $badgeClass }} mb-0">{{ number_format($score->score, 2) }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

    <script src="{{ asset('js/data-chart.js') }}"></script>

@endsection


