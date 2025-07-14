<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undangan Karang Taruna</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url("{{ public_path($pengumuman->gambar) }}");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
            line-height: 1.5;
            font-size: 12px
        }

        .container {
            width: 80%;
            margin: 50px auto;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .header {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .content {
            text-align: justify;
            line-height: 20px;
        }

        .table-info {
            margin: 10px 0;
            margin-top: 45px
        }


        .footer {
            margin-top: 30px;
            text-align: right;
        }

        .signature {
            margin-top: 50px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">

        </div>

        <div class="content">
            <table class="table-info">
                <tr>
                    <td><strong>Nomor</strong></td>
                    <td>: {{ $pengumuman->nomor_surat }}</td>
                </tr>
                <tr>
                    <td><strong>Lampiran</strong></td>
                    <td>: -</td>
                </tr>
                <tr>
                    <td><strong>Perihal</strong></td>
                    <td>: {{ $pengumuman->perihal }}</td>
                </tr>
            </table>

            <p>Kepada, Yth.<br>
            {{ $pengumuman->kepada }}<br>
            Di tempat</p>

            <p>Assalaamu’alaikum Warahmatullaahi Wabarakaatuh.</p>
            <p>Puji syukur kehadirat Allah SWT yang telah melimpahkan rahmat dan karunia-Nya kepada kita semua. Sholawat serta salam semoga tetap tercurah kepada baginda Nabi Muhammad SAW beserta keluarga, sahabat, dan para pengikutnya.</p>

            <p>{{ $pengumuman->deskripsi }}</p>

            <table class="table-info">
                <tr>
                    <td><strong>Hari, tanggal</strong></td>
                    <td>: {{ $pengumuman->hari }}, {{ $pengumuman->created_at->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td><strong>Waktu</strong></td>
                    <td>: {{ $pengumuman->waktu }}</td>
                </tr>
                <tr>
                    <td><strong>Tempat</strong></td>
                    <td>: {{ $pengumuman->tempat }}</td>
                </tr>
                <tr>
                    <td><strong>Acara</strong></td>
                    <td>: {{ $pengumuman->acara }}</td>
                </tr>
            </table>

            <p>Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Saudara/Saudari berkenan hadir pada acara tersebut. Atas kehadiran Anda kami sampaikan terima kasih.</p>

            <p>Wassalaamu’alaikum Warahmatullaahi Wabarakaatuh.</p>
        </div>

        <div class="footer">
            <p>Hormat kami,</p>
            @if ($pengumuman?->ttd_ketua)
            <x-image-preview src="{{ public_path($pengumuman?->ttd_ketua) }}" />
            @endif

            <p class="signature">Ketua RT 25<br>H. Abdul</p>
        </div>
    </div>
</body>
</html>
