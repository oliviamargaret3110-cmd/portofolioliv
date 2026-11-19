@extends('layouts.auth')

@section('title', 'Login Admin')

@section('content')
    <div class="text-center">
        <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-600 text-xl text-white shadow-lg shadow-indigo-600/30">
            <i class="fa-solid fa-user-shield"></i>
        </span>

        <h1 class="mt-4 text-2xl font-extrabold text-slate-900 dark:text-white">Login Admin</h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Masuk untuk mengelola konten portofolio.</p>
    </div>

    <form method="POST" action="{{ route('login.store') }}" class="mt-6 space-y-4">
        @csrf

        <div>
            <label for="email" class="label">Email</label>
            <div class="relative">
                <i class="fa-solid fa-envelope pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-sm text-slate-400"></i>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    class="input pl-10"
                    placeholder="admin@portfolio.test"
                >
            </div>
        </div>

        <div>
            <label for="password" class="label">Password</label>
            <div class="relative">
                <i class="fa-solid fa-lock pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-sm text-slate-400"></i>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    class="input pl-10"
                    placeholder="Masukkan password"
                >
            </div>
        </div>

        <label class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
            <input type="checkbox" name="remember" value="1" @checked(old('remember')) class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-900">
            Ingat saya
        </label>

        <button type="submit" class="btn-primary w-full">
            <i class="fa-solid fa-right-to-bracket"></i>
            Masuk
        </button>
    </form>

    <div class="mt-6 rounded-xl border border-slate-200 bg-slate-50 p-3 text-center text-[11px] leading-relaxed text-slate-500 dark:border-slate-800 dark:bg-slate-800/50 dark:text-slate-400">
        Akun bawaan: <span class="font-semibold text-slate-700 dark:text-slate-200">admin@portfolio.test</span> /
        <span class="font-semibold text-slate-700 dark:text-slate-200">password</span>
        <br>
        Segera ganti password melalui Dashboard Admin.
    </div>
@endsection
