<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <label for="nama">Nama:</label>
            <input id="nama" type="text" name="nama" value="{{ old('nama') }}" required>
            @error('nama')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="username">Username:</label>
            <input id="username" type="text" name="username" value="{{ old('username') }}" required>
            @error('username')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password">Password:</label>
            <input id="password" type="password" name="password" required>
            @error('password')
                <span>{{ $message }}</span>
            @enderror
            <small>Password harus mengandung huruf besar, huruf kecil, angka, dan simbol.</small>
        </div>

        <div>
            <label for="password_confirmation">Konfirmasi Password:</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required>
            @error('password_confirmation')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="level">Level:</label>
            <select id="level" name="level" required>
                <option value="VERIFIKATOR_BPJSKES" {{ old('level') == 'VERIFIKATOR_BPJSKES' ? 'selected' : '' }}>VERIFIKATOR BPJSKES</option>
                <option value="VERIFIKATOR_RS" {{ old('level') == 'VERIFIKATOR_RS' ? 'selected' : '' }}>VERIFIKATOR RS</option>
                <option value="ADMIN" {{ old('level') == 'ADMIN' ? 'selected' : '' }}>ADMIN</option>
            </select>
            @error('level')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">Register</button>
    </form>
</body>
</html>