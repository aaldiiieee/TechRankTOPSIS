@extends('layouts.main')

@section('title', 'List Employee')

@section('styles')

    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">

@endSection

@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Data Anggota</h6>
            <a class="btn btn-primary" href="{{ route('add-employee') }}">Tambah Anggota</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tableEmployee" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>No. Telepon</th>
                            <th>Email</th>
                            <th>Posisi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user['name'] }}</td>
                                <td>{{ $user['phone'] }}</td>
                                <td>{{ $user['email'] }}</td>
                                <td>{{ $user['role'] }}</td>
                                <td>
                                    <button class="btn btn-danger" type="button" onclick="deleteEmployee({{ $user['id'] }})">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                    <button 
                                        href="#" 
                                        class="btn btn-success" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editEmployeeModal" 
                                        onclick="populateModal({{ $user }})"
                                    >
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <x-modal.modal-edit id="editEmployeeModal" title="Edit Akun" formId="editEmployeeForm" action="{{ route('employee.update', $user->id) }}" submitLabel="Perbarui">
        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" name="name" id="editName" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="phone">No. Telepon</label>
            <input type="text" name="phone" id="editPhone" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="editEmail" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="role">Posisi</label>
            <select name="role" id="editRole" class="form-control" required>
                <option value="super_admin">Super Admin</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
        </div>
    </x-modal.modal-edit>

@endsection

@section('scripts')

    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#tableEmployee').DataTable();

            window.deleteEmployee = function(id) {
                const token = $('meta[name="csrf-token"]').attr('content');

                Swal.fire({
                    title: 'Apa kamu yakin?',
                    text: 'Data yang di hapus, tidak bisa di kembalikan',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    cancelButtonText: "Batal",
                    confirmButtonText: "Ya, hapus ini!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ url('employee/delete') }}/" + id,
                            data: {
                                _token: token
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Berhasil dihapus',
                                    text: 'Data telah di hapus.',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.href = "{{ route('list-employee') }}";
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: 'An error occurred',
                                    text: 'Unable to delete. Please try again later.',
                                    icon: 'error',
                                });
                            }
                        });
                    }
                });
            }

            function populateModal(user) {
                document.getElementById('editEmployeeForm').action = `/employee/update/${user.id}`;

                document.getElementById('editName').value = user.name;
                document.getElementById('editPhone').value = user.phone;
                document.getElementById('editEmail').value = user.email;
                document.getElementById('editRole').value = user.role;
            }
        });
    </script>

@endSection