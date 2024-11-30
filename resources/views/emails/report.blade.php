<!DOCTYPE html>
<html>
<head>
    <title>Laporan Servis</title>
</head>
<body>
    <h1>Halo, {{ $customer->name }}</h1>
    <p>Terima kasih telah menggunakan layanan kami. Berikut laporan servis Anda:</p>
    <p><strong>Alamat:</strong> {{ $customer->address }}</p>
    <p><strong>Tanggal Servis:</strong> {{ $customer->updated_at->format('d-m-Y') }}</p>

    <p>Silakan klik tombol di bawah ini untuk memberikan feedback:</p>
    <a href="{{ $feedbackUrl }}" 
       style="display:inline-block; padding:10px 20px; color:white; background-color:blue; text-decoration:none; border-radius:5px;">
        Berikan Feedback
    </a>
</body>
</html>
