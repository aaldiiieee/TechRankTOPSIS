<!DOCTYPE html>
<html>
<head>
    <title>Technician List</title>
</head>
<body>
    <h1>Technician List</h1>
    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif
    <a href="{{ route('technicians.create') }}">Add Technician</a>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($technicians as $technician)
            <tr>
                <td>{{ $technician->name }}</td>
                <td>{{ $technician->email }}</td>
                <td>{{ $technician->phone }}</td>
                <td>
                    <form action="{{ route('technicians.destroy', $technician->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
