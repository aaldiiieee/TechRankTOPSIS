<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> --}}

    <title>CMS | Login</title>

    <link rel="stylesheet" href="{{ asset('vendor/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<body>
    <section class="bg-primary py-3 py-md-5 py-xl-8 login-wrapper">
        <div class="container">
            <div class="row gy-4 align-items-center">
                <div class="col-12 col-md-6 col-xl-7">
                    <div class="d-flex justify-content-center text-bg-primary">
                        <div class="col-12 col-xl-9">
                            <img 
                                class="img-fluid rounded mb-4" 
                                src="{{ asset('images/logo-brand.png') }}"
                                width="245" 
                                height="80" 
                                alt="BootstrapBrain Logo"
                            />

                            <hr class="border-primary-subtle mb-4">

                            <h2 class="h1 mb-4">We make digital products that drive you to stand out.</h2>
                            <p class="lead mb-5">We write words, take photos, make videos, and interact with artificial intelligence.</p>
                            <div class="text-endx">
                                <svg 
                                    xmlns="http://www.w3.org/2000/svg" 
                                    width="48" 
                                    height="48"
                                    fill="currentColor" 
                                    class="bi bi-grip-horizontal" 
                                    viewBox="0 0 16 16"
                                >
                                    <path
                                        d="M2 8a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-5">
                    <div class="card border-0 rounded-4">
                        <div class="card-body p-3 p-md-4 p-xl-5">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-4">
                                        <h3>Sign in</h3>
                                    </div>
                                </div>
                            </div>
                            <form action="#!">
                                <div class="row gy-3 overflow-hidden">
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input 
                                                type="email" 
                                                class="form-control" 
                                                name="email" 
                                                id="email"
                                                placeholder="name@example.com" 
                                                value="{{ old('email') }}"
                                                required
                                            />
                                            <label for="email" class="form-label">Email</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input 
                                                type="password" 
                                                class="form-control" 
                                                name="password" 
                                                id="password"
                                                placeholder="Password" 
                                                required
                                            />
                                            <label for="password" class="form-label">Password</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                name="remember_me" id="remember_me">
                                            <label class="form-check-label text-secondary" for="remember_me">
                                                Keep me logged in
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button class="btn btn-primary btn-lg" id="loginBtn" type="submit">Login</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            {{-- <div class="row">
                                <div class="col-12">
                                    <div
                                        class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-end mt-4">
                                        <a href="#!">Forgot password</a>
                                    </div>
                                </div>
                            </div> --}}
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('vendor/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('vendor/js/sweetalert2@11.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#loginBtn').click(function(e) {
                e.preventDefault();

                const email = $('#email').val();
                const password = $('#password').val();
                const token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    type: "POST",
                    url: "{{ route('login') }}",
                    data: {
                        email: email,
                        password: password,
                        _token: token
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Login Successful',
                                text: 'You will be redirected to the dashboard.',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = "/";
                            });
                        } else {
                            Swal.fire({
                                title: 'Login Failed',
                                text: response.message,
                                icon: 'error',
                            });
                        }
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            Swal.fire({
                                title: 'Login Failed',
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
            });
        })
    </script>
</body>

</html>
