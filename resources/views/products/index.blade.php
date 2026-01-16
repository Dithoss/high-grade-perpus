<!DOCTYPE html>
<html>
<head>
    <title>Daftar Buku</title>
</head>
<body>

<h1>Daftar Buku</h1>

<a href="/products/create">Tambah Buku</a>

<table border="1" cellpadding="10">
    <tr>
        <th>Nama</th>
        <th>Stock</th>
        <th>Aksi</th>
    </tr>

    @foreach ($products as $book)
    <tr>
        <td>{{ $book->title }}</td>
        <td>{{ $book->stock }}</td>
        <td>
            <a href="/products/{{ $book->id }}/edit">Edit</a>

            <form action="/products/{{ $book->id }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

</body>
</html>
