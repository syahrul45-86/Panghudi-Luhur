<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Denda Belum Lunas</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Laporan Denda Belum Lunas</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dendas as $key => $denda)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $denda->anggota->name }}</td>
                <td>{{ date('d-m-Y', strtotime($denda->tanggal)) }}</td>
                <td>{{ $denda->keterangan }}</td>
                <td>Rp {{ number_format($denda->jumlah, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
