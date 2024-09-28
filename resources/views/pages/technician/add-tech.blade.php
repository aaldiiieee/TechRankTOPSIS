<!DOCTYPE html>
<html>
<head>
    <title>Add Technician</title>
</head>
<body>
    <h1>Add Technician</h1>
    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif
    <form action="{{ route('technicians.store') }}" method="POST">
        @csrf
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone" required>
        <br>
        <button type="submit">Add Technician</button>
    </form>
</body>
</html>
