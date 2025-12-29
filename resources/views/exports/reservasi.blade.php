<table>
    <thead>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>No HP</th>
            <th>Tanggal</th>
            <th>Waktu</th>
            <th>Paket</th>
            <th>Status</th>
            <th>Fotografer</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reservasi as $r)
            <tr>
                <td>{{ $r->nama }}</td>
                <td>{{ $r->email }}</td>
                <td>{{ $r->no_hp }}</td>
                <td>{{ $r->tanggal }}</td>
                <td>
                    {{ substr($r->waktu_mulai,0,5) }}
                    -
                    {{ substr($r->waktu_selesai,0,5) }}
                </td>
                <td>{{ $r->tipe_paket }}</td>
                <td>{{ ucfirst(str_replace('_',' ', $r->status)) }}</td>
                <td>{{ optional($r->fotografer)->nama_fotografer ?? '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
