@extends('layouts.main')

@section('title', 'Add Employee')

@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Akun</h6>
        </div>

        <div class="card-body">
            <form>
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Masukan nama lengkap" required>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <label for="phone">No. Phone</label>
                            <input type="number" name="phone" id="phone" class="form-control" placeholder="Masukan nomor telepon" required>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Masukan email" required>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Masukan kata sandi" required>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <label for="password_confirmation">Ketik Ulang Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Masukan ulang kata sandi" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="role" id="role" class="form-control" required>
                                @switch (auth()->user()->role)
                                    @case('super_admin')
                                        <option value="admin">Admin</option>
                                        <option value="user">Teknisi</option>
                                        <option value="super_admin">Super Admin</option>
                                        @break
                                    @case('admin')
                                        <option value="user">Teknisi</option>
                                        @break
                                @endswitch
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-center pt-4">
                    <button type="submit" id="btnAddEmployee" class="btn btn-primary btn-add-employee">Submit</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')

<script>
    $(document).ready(function() {
        $('#btnAddEmployee').on('click', function(e) {
            e.preventDefault();

            const name = $('#name').val();
            const email = $('#email').val();
            const password = $('#password').val();
            const password_confirmation = $('#password_confirmation').val();
            const phone = $('#phone').val();
            const role = $('#role').val();

            const token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: "POST",
                url: "{{ route('create-employee') }}",
                data: {
                    name: name,
                    email: email,
                    password: password,
                    password_confirmation: password_confirmation,
                    role: role,
                    phone: phone,
                    _token: token
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Employee Added',
                        text: 'New employee has been added.',
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Show List Employee",
                        cancelButtonText: "Stay Here"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('list-employee') }}";
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            location.reload();
                        }
                    });
                },
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        Swal.fire({
                            title: 'Add Employee Failed',
                            text: 'Please check your credentials and try again.',
                            icon: 'error',
                        });
                    } else {
                        Swal.fire({
                            title: 'An error occurred',
                            text: 'Please try again later.',
                            icon: 'error',
                        });
                    }
                }
            })
        })
    });
</script>

@endsection