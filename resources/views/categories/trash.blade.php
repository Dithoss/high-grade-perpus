<!DOCTYPE html>
<html>
<head>
    <title>Trash Book</title>
</head>
<body>
    <h1>Trash Book</h1>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="8">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Aksi</th>
        </tr>

        @foreach($book as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->name }}</td>
            <td>
                <form action="{{ route('book.restore', $item->id) }}" method="POST">
                    @csrf
                    <button>Restore</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

    <br>
    {{ $book->links() }}

    <br>
    <a href="{{ route('book.index') }}">Kembali</a>
</body>
</html>
