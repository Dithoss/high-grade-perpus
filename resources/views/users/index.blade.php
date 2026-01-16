<h1>User List</h1>

@if (session('success'))
    <p>{{ session('success') }}</p>
@endif

<a href="{{ route('users.create') }}">Tambah User</a>

<ul>
@foreach ($users as $user)
    <li>
        {{ $user->name }} - {{ $user->email }}

        <a href="{{ route('users.edit', $user->id) }}">Edit</a>

        <form method="POST" action="{{ route('users.destroy', $user->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit">Hapus</button>
        </form>
    </li>
@endforeach
</ul>

{{ $users->links() }}
