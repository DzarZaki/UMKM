<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Reservasi</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 6px; }
        th { background: #eee; }
    </style>
</head>
<body>

<h2>Laporan Reservasi</h2>
<p>Generated: {{ $generatedAt->format('d M Y H:i') }}</p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>No HP</th>
            <th>Paket</th>
            <th>Tanggal</th>
            <th>Waktu</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reservasi as $i => $r)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $r->nama }}</td>
            <td>{{ $r->email }}</td>
            <td>{{ $r->no_hp }}</td>
            <td>{{ $r->tipe_paket }}</td>
            <td>{{ \Carbon\Carbon::parse($r->tanggal)->format('d M Y') }}</td>
            <td>{{ substr($r->waktu_mulai,0,5) }} - {{ substr($r->waktu_selesai,0,5) }}</td>
            <td>{{ strtoupper($r->status) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
