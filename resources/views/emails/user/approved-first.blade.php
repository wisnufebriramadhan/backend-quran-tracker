<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Akun Aktif</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f6f8; font-family:Arial, Helvetica, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f8; padding:20px 0;">
        <tr>
            <td align="center">
                <!-- Card -->
                <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 4px 10px rgba(0,0,0,0.08);">

                    <!-- Header -->
                    <tr>
                        <td style="background:#16a34a; padding:20px; text-align:center; color:#ffffff;">
                            <h1 style="margin:0; font-size:22px;">
                                🎉 Akun Anda Telah Aktif
                            </h1>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:30px; color:#333333; font-size:15px; line-height:1.6;">
                            <p style="margin-top:0;">
                                Assalamu’alaikum <strong>{{ $user->name }}</strong>,
                            </p>

                            <p>
                                Kami informasikan bahwa akun Anda telah
                                <strong>disetujui oleh administrator</strong>
                                dan sekarang sudah <strong>aktif</strong>.
                            </p>

                            <p>
                                Anda sudah dapat login dan menggunakan seluruh
                                fitur yang tersedia, termasuk fitur absensi
                                sesuai dengan jadwal dan lokasi yang ditentukan.
                            </p>

                            <!-- Button -->
                            <div style="text-align:center; margin:30px 0;">
                                <a href="{{ config('app.url') }}"
                                    style="
                                        background:#16a34a;
                                        color:#ffffff;
                                        text-decoration:none;
                                        padding:12px 28px;
                                        border-radius:6px;
                                        font-weight:bold;
                                        display:inline-block;
                                   ">
                                    Login ke Aplikasi
                                </a>
                            </div>

                            <p style="margin-bottom:0;">
                                Jika Anda mengalami kendala, silakan hubungi administrator.
                            </p>

                            <p style="margin-top:25px;">
                                Terima kasih,<br>
                                <strong>{{ config('app.name') }}</strong>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f1f5f9; padding:15px; text-align:center; font-size:12px; color:#64748b;">
                            Email ini dikirim secara otomatis, mohon tidak membalas email ini.
                        </td>
                    </tr>

                </table>
                <!-- End Card -->
            </td>
        </tr>
    </table>

</body>

</html>