@extends('layouts.main')

@section('title', 'List Customer')

@section('styles')

    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">

@endSection

@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin')
                <h6 class="m-0 font-weight-bold text-primary">Data Customer</h6>
                <a class="btn btn-primary" href="{{ route('customer.create') }}">Tambah Customer</a>
            @else
                <h6 class="m-0 font-weight-bold text-primary">Daftar Tugas</h6>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tableCustomer" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>No. Telepon</th>
                            <th>Email</th>
                            <th>Tugas</th>
                            <th>Teknisi (PIC)</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $customer)
                            <tr>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->address }}</td>
                                <td>{{ $customer->phone }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->keluhan }}</td>
                                <td>
                                    {{ $customer->techName }}
                                    
                                    @if($customer->techName == "")
                                        <select id="techId_{{ $customer->id }}" class="form-select">
                                            @foreach($technicians as $technician)
                                                <option value="{{$technician->id}}">{{$technician->name}}</option>
                                            @endforeach
                                        </select>
                                        <button type="button" id="btnSaveTechnician" data-customer="{{ $customer->id }}" class="btn btn-success ">
                                            <i class="fa-solid fa-floppy-disk"></i>
                                        </button>
                                    @endif
                                </td>
                                
                                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin')
                                    <td>
                                        <form action="{{ route('customer.destroy', $customer->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </td>
                                @endif

                                @if (Auth::user()->role == 'user' )
                                    <td class="text-nowrap">
                                        @if($customer->status == 'pending')
                                            <a class="btn btn-warning" href="{{ route('report.technician', $customer->id) }}">
                                                Tambahkan Report
                                            </a>
                                        @elseif($customer->status == 'success')
                                            <a class="btn btn-success" href="{{ route('report.index', $customer->id) }}">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('pdf.generate', $customer->id) }}" class="btn btn-primary">
                                                <i class="fas fa-solid fa-download"></i> 
                                            </a>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endSection

@section('scripts')

    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#tableCustomer').DataTable();

            $('#btnSaveTechnician').on('click', function(e) {
                e.preventDefault();

                const customerId = $(this).data('customer');
                const techId = $('#techId_' + customerId).val();

                const token = $('meta[name="csrf-token"]').attr('content');
                
                $.ajax({
                    url: "{{ url('customer') }}/" + customerId,
                    type: 'PUT',
                    data: {
                        techid: techId,
                        _token: token
                    },
                    success: function(response) {
                        alert('Technician updated successfully');
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred: ' + error);
                    }
                });
            });

        });
    </script>

@endSection