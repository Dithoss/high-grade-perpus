<!DOCTYPE html>
<html>
<head>
    <title>Edit Buku</title>
</head>
<body>

<h1>Edit Buku</h1>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="/products/{{ $book->id }}" method="POST">
    @csrf
    @method('PUT')

    <label>Name</label><br>
    <input type="text" name="name" value="{{ $book->title }}"><br><br>

    <label>Stock</label><br>
    <input type="number" name="stock" value="{{ $book->stock }}"><br><br>

    <button type="submit">Update</button>
</form>

<a href="/products">Kembali</a>

</body>
</html>
