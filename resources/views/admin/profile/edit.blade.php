@extends('layouts.admin')

@section('title', 'Profil')
@section('subtitle', 'Kelola profil portofolio dan akun admin')

@section('content')
    @include('partials.form-errors')

    <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid gap-6 xl:grid-cols-[0.8fr_1.6fr]">
            <div class="space-y-6">
                <div class="card p-6">
                    <h2 class="text-sm font-bold text-slate-900 dark:text-white">Foto Profil</h2>

                    <div class="mt-4 flex flex-col items-center">
                        <img
                            id="photo-preview"
                            src="{{ media_url($profile->photo, 'seed/avatar.svg') }}"
                            alt="Foto profil"
                            class="h-32 w-32 rounded-2xl object-cover ring-4 ring-indigo-500/20"
                        >

                        <label for="photo" class="btn-outline mt-4 cursor-pointer">
                            <i class="fa-solid fa-upload"></i>
                            Pilih Foto
                        </label>
                        <input type="file" id="photo" name="photo" accept="image/*" class="hidden">
                        <p class="mt-2 text-center text-[11px] text-slate-400">JPG/PNG, maksimal 2 MB.</p>
                    </div>
                </div>

                <div class="card p-6">
                    <h2 class="text-sm font-bold text-slate-900 dark:text-white">Akun Admin</h2>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Digunakan untuk login ke dashboard.</p>

                    <div class="mt-4 space-y-4">
                        <div>
                            <label for="account_name" class="label">Nama Akun</label>
                            <input type="text" id="account_name" name="account_name" value="{{ old('account_name', $user->name) }}" required class="input">
                        </div>

                        <div>
                            <label for="account_email" class="label">Email Login</label>
                            <input type="email" id="account_email" name="account_email" value="{{ old('account_email', $user->email) }}" required class="input">
                        </div>
                    </div>
                </div>

                <div class="card p-6">
                    <h2 class="text-sm font-bold text-slate-900 dark:text-white">Ganti Password</h2>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Kosongkan jika tidak ingin mengganti password.</p>

                    <div class="mt-4 space-y-4">
                        <div>
                            <label for="password" class="label">Password Baru</label>
                            <input type="password" id="password" name="password" class="input" placeholder="Minimal 8 karakter" autocomplete="new-password">
                        </div>

                        <div>
                            <label for="password_confirmation" class="label">Konfirmasi Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="input" placeholder="Ulangi password baru" autocomplete="new-password">
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="card p-6">
                    <h2 class="text-sm font-bold text-slate-900 dark:text-white">Data Profil</h2>

                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="full_name" class="label">Nama Lengkap <span class="text-rose-500">*</span></label>
                            <input type="text" id="full_name" name="full_name" value="{{ old('full_name', $profile->full_name) }}" required class="input">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="headline" class="label">Headline</label>
                            <input type="text" id="headline" name="headline" value="{{ old('headline', $profile->headline) }}" class="input" placeholder="Contoh: Siswa PPLG | Web Developer Pemula">
                        </div>

                        <div>
                            <label for="class_name" class="label">Kelas</label>
                            <input type="text" id="class_name" name="class_name" value="{{ old('class_name', $profile->class_name) }}" class="input" placeholder="Contoh: XII PPLG 1">
                        </div>

                        <div>
                            <label for="major" class="label">Jurusan</label>
                            <input type="text" id="major" name="major" value="{{ old('major', $profile->major) }}" class="input" placeholder="Contoh: Pengembangan Perangkat Lunak dan Gim">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="bio" class="label">Bio</label>
                            <textarea id="bio" name="bio" rows="5" class="input resize-y" placeholder="Ceritakan tentang diri Anda...">{{ old('bio', $profile->bio) }}</textarea>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="career_goal" class="label">Tujuan Karier</label>
                            <textarea id="career_goal" name="career_goal" rows="3" class="input resize-y" placeholder="Contoh: Menjadi web developer profesional...">{{ old('career_goal', $profile->career_goal) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card p-6">
                    <h2 class="text-sm font-bold text-slate-900 dark:text-white">Kontak & Media Sosial</h2>

                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="email" class="label">Email Publik</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $profile->email) }}" class="input" placeholder="nama@email.com">
                        </div>

                        <div>
                            <label for="phone" class="label">Telepon</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', $profile->phone) }}" class="input" placeholder="0812xxxxxxx">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="location" class="label">Lokasi</label>
                            <input type="text" id="location" name="location" value="{{ old('location', $profile->location) }}" class="input" placeholder="Contoh: Bandung, Jawa Barat">
                        </div>

                        <div>
                            <label for="github_url" class="label">GitHub</label>
                            <input type="url" id="github_url" name="github_url" value="{{ old('github_url', $profile->github_url) }}" class="input" placeholder="https://github.com/username">
                        </div>

                        <div>
                            <label for="instagram_url" class="label">Instagram</label>
                            <input type="url" id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $profile->instagram_url) }}" class="input" placeholder="https://instagram.com/username">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="linkedin_url" class="label">LinkedIn</label>
                            <input type="url" id="linkedin_url" name="linkedin_url" value="{{ old('linkedin_url', $profile->linkedin_url) }}" class="input" placeholder="https://linkedin.com/in/username">
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap justify-end gap-3">
                    <a href="{{ route('admin.dashboard') }}" class="btn-outline">Batal</a>
                    <button type="submit" class="btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        const photoInput = document.getElementById('photo');
        const photoPreview = document.getElementById('photo-preview');

        photoInput?.addEventListener('change', () => {
            const file = photoInput.files?.[0];
            if (file) {
                photoPreview.src = URL.createObjectURL(file);
            }
        });
    </script>
@endpush
