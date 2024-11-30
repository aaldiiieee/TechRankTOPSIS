<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f8f9fa;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-header text-center bg-primary text-white">
                        <h2>We Value Your Feedback</h2>
                        <p>Your opinion helps us improve our services.</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/feedback/' . $customerId) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="rating" class="form-label fw-bold">Rating (1-5)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-star-fill text-warning"></i></span>
                                    <input type="number" name="rating" id="rating" class="form-control" min="1" max="5" placeholder="Give a rating between 1 to 5" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="comments" class="form-label fw-bold">Comments</label>
                                <textarea name="comments" id="comments" class="form-control" rows="4" placeholder="Share your experience with us" required></textarea>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Submit Feedback</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->z
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
