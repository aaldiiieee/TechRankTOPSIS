@extends('layouts.main')

@section('title', 'Add Customer')

@section('content')
    
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Customer</h6>
        </div>

        <div class="card-body">
            <form>
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Masukan nama lengkap" required>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <input type="address" name="address" id="address" class="form-control" placeholder="Masukan alamat lengkap" required>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <label for="phone">No. Telepon</label>
                            <input type="number" name="phone" id="phone" class="form-control" placeholder="Masukan nomor telepon" required>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" placeholder="Masukan email" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="form-floating">
                            <label for="keluhan">Tugas</label>
                            <textarea class="form-control" name="keluhan" placeholder="Leave a comment here" id="keluhan"></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-center pt-4">
                    <button type="submit" id="btnAddCustomer" class="btn btn-primary btn-add-customer">Tambah Pelanggan</button>
                </div>
            </form>
        </div>
    </div>

@endSection

@section('scripts')

<script>
    $(document).ready(function() {
        $('#btnAddCustomer').on('click', function(e) {
            e.preventDefault();

            const name = $('#name').val();
            const address = $('#address').val();
            const phone = $('#phone').val();
            const email = $('#email').val();
            const purpose = $('#keluhan').val();

            const token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: "POST",
                url: "{{ route('customer.store') }}",
                data: {
                    name: name,
                    address: address,
                    phone: phone,
                    email: email,
                    keluhan: purpose,
                    _token: token
                },
                success: function(data) {
                    Swal.fire({
                        title: 'Customer Added',
                        text: 'New customer has been added.',
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Show List Customers",
                        cancelButtonText: "Stay Here"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('customer.index') }}";
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            location.reload();
                        }
                    });
                },
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        Swal.fire({
                            title: 'Add Customer Failed',
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
            });
        })
    });
</script>

@endSection
