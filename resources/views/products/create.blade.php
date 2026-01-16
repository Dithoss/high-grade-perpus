<!DOCTYPE html>
<html>
<head>
    <title>Tambah Buku</title>
</head>
<body>

<h1>Tambah Buku</h1>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="/products" method="POST">
    @csrf

    <label>Nama</label><br>
    <input type="text" name="name"><br><br>

    <label>Stock</label><br>
    <input type="number" name="stock"><br><br>

    <button type="submit">Simpan</button>
</form>

<a href="/products">Kembali</a>

</body>
</html>
