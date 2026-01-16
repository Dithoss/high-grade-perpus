<form method="POST" action="{{ route('users.store') }}">
    @csrf

    <input name="name" placeholder="Name"><br>
    <input name="email" placeholder="Email"><br>
    <input name="password" placeholder="Password"><br>

    <button type="submit">Simpan</button>
</form>
