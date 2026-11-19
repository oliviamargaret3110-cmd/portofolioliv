<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Support\ImageStorage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Form edit profil pemilik portofolio dan akun admin.
     */
    public function edit(): View
    {
        $user = request()->user();

        $profile = Profile::query()->firstOrCreate(
            ['user_id' => $user->id],
            ['full_name' => $user->name, 'email' => $user->email],
        );

        return view('admin.profile.edit', [
            'profile' => $profile,
            'user' => $user,
        ]);
    }

    /**
     * Simpan perubahan profil dan (opsional) akun admin.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $profile = Profile::query()->firstOrCreate(
            ['user_id' => $user->id],
            ['full_name' => $user->name, 'email' => $user->email],
        );

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:100'],
            'headline' => ['nullable', 'string', 'max:150'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'class_name' => ['nullable', 'string', 'max:50'],
            'major' => ['nullable', 'string', 'max:100'],
            'bio' => ['nullable', 'string', 'max:3000'],
            'career_goal' => ['nullable', 'string', 'max:1000'],
            'email' => ['nullable', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:30'],
            'location' => ['nullable', 'string', 'max:150'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'account_name' => ['required', 'string', 'max:100'],
            'account_email' => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'full_name.required' => 'Nama lengkap wajib diisi.',
            'account_name.required' => 'Nama akun wajib diisi.',
            'account_email.required' => 'Email akun wajib diisi.',
            'account_email.unique' => 'Email akun sudah digunakan.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $validated['photo'] = ImageStorage::replace($request->file('photo'), 'profile', $profile->photo);
        $profile->update($validated);

        $user->name = $validated['account_name'];
        $user->email = $validated['account_email'];

        if ($request->filled('password')) {
            $user->password = Hash::make($request->string('password')->toString());
        }

        $user->save();

        return redirect()
            ->route('admin.profile.edit')
            ->with('success', 'Profil dan akun berhasil diperbarui.');
    }
}
