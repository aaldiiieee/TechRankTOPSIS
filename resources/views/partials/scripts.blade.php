<script>
    $(document).ready(function() {
        $('.logoutBtn').on('click', function(e) {
            e.preventDefault();

            const token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: "POST",
                url: "{{ route('logout') }}",
                data: {
                    _token: token
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Logout Successful',
                        text: 'You have been logged out.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = "/";
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'An error occurred',
                        text: 'Unable to logout. Please try again later.',
                        icon: 'error',
                    });
                }
            });
        });
    });
</script>