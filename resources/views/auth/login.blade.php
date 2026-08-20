@extends('layouts.app', ['title' => 'Login GALERIA'])

@section('content')
    <section class="page-head">
        <div>
            <h1>Login</h1>
            <p class="muted">Masuk sebagai Admin Provinsi atau Admin Satker untuk mengelola data aplikasi.</p>
        </div>
    </section>

    <form class="panel" method="post" action="{{ route('login') }}" style="max-width:520px">
        @csrf
        <div class="form-grid" style="grid-template-columns:1fr">
            <div>
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>
            <div>
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
            </div>
            <label>
                <input type="checkbox" name="remember" value="1" style="width:auto">
                Ingat sesi login
            </label>
        </div>
        <div class="actions" style="margin-top:18px">
            <button class="button" type="submit">Login</button>
            <a class="button secondary" href="{{ route('dashboard') }}">Kembali</a>
        </div>
        <p class="muted" style="margin-top:16px">Akun demo: admin.provinsi@bps.go.id / password</p>
    </form>
@endsection
