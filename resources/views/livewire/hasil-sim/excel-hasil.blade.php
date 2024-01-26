<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Username</th>
            <th>Email</th>
            <th>TWK</th>
            <th>TIU</th>
            <th>TKP</th>
            <th>Total</th>
            <th>Selesai Tes</th>
        </tr>
    </thead>
    <tbody>
    @php $no = 1 @endphp
    @foreach($hasil_sim as $hasil)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $hasil->nama }}</td>
            <td>{{ $hasil->username }}</td>
            <td>{{ $hasil->email }}</td>
            <td>{{ $hasil->nilaitwk }}</td>
            <td>{{ $hasil->nilaitiu }}</td>
            <td>{{ $hasil->nilaitkp }}</td>
            <td>{{ $hasil->nilaitwk + $hasil->nilaitiu + $hasil->nilaitkp }}</td>
            <td>{{ $hasil->created_at->format('d M Y H:i') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>