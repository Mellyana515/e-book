<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kode Verifikasi Login</title>
</head>
<body style="margin:0; padding:24px; background:#f9fafb; font-family:Arial, Helvetica, sans-serif; color:#1f2937;">
    <div style="max-width:560px; margin:0 auto; background:#ffffff; border:1px solid #e5e7eb; border-radius:16px; overflow:hidden;">
        <div style="padding:32px;">
            <p style="margin:0 0 12px; font-size:14px; color:#6b7280;">Halo {{ $user->name }},</p>
            <h1 style="margin:0 0 16px; font-size:24px; line-height:1.3; color:#111827;">Kode verifikasi login Anda</h1>
            <p style="margin:0 0 24px; font-size:15px; line-height:1.7; color:#4b5563;">
                Gunakan kode berikut untuk menyelesaikan proses login. Kode ini berlaku selama 10 menit.
            </p>

            <div style="margin:0 0 24px; padding:18px 20px; text-align:center; background:#fff7ed; border:1px solid #fed7aa; border-radius:14px;">
                <div style="font-size:32px; font-weight:700; letter-spacing:8px; color:#ea580c;">{{ $code }}</div>
            </div>

            <p style="margin:0; font-size:14px; line-height:1.7; color:#6b7280;">
                Jika Anda tidak merasa melakukan login, abaikan email ini dan pertimbangkan mengganti password akun Anda.
            </p>
        </div>
    </div>
</body>
</html>
