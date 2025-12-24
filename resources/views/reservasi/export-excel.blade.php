<table>
    <thead>
        <tr>
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
        @foreach($reservasi as $r)
        <tr>
            <td>{{ $r->nama }}</td>
            <td>{{ $r->email }}</td>
            <td>{{ $r->no_hp }}</td>
            <td>{{ $r->tipe_paket }}</td>
            <td>{{ $r->tanggal }}</td>
            <td>{{ $r->waktu_mulai }} - {{ $r->waktu_selesai }}</td>
            <td>{{ $r->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
