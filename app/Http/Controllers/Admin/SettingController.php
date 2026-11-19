<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Daftar pengaturan yang bisa diubah dari dashboard.
     *
     * @var array<string, array{label: string, type: string, placeholder?: string}>
     */
    private const FIELDS = [
        'site_name' => ['label' => 'Nama Website', 'type' => 'text', 'placeholder' => 'Portofolio Olivia Margaret'],
        'site_tagline' => ['label' => 'Tagline', 'type' => 'text', 'placeholder' => 'Personal Portfolio'],
        'site_description' => ['label' => 'Deskripsi Website', 'type' => 'textarea', 'placeholder' => 'Deskripsi singkat website'],
        'footer_text' => ['label' => 'Teks Footer', 'type' => 'text', 'placeholder' => 'Seluruh hak cipta dilindungi.'],
        'availability_text' => ['label' => 'Status Ketersediaan', 'type' => 'text', 'placeholder' => 'Terbuka untuk kolaborasi & peluang baru'],
    ];

    public function edit(): View
    {
        $settings = Setting::query()->pluck('value', 'key')->all();

        return view('admin.settings.edit', [
            'fields' => self::FIELDS,
            'settings' => $settings,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $rules = [];
        $labels = [];

        foreach (self::FIELDS as $key => $field) {
            $rules[$key] = ['nullable', 'string', 'max:255'];
            $labels[$key.'.max'] = $field['label'].' maksimal 255 karakter.';
        }

        $validated = $request->validate($rules, $labels);

        foreach (array_keys(self::FIELDS) as $key) {
            Setting::put($key, $validated[$key] ?? null);
        }

        return redirect()
            ->route('admin.settings.edit')
            ->with('success', 'Pengaturan website berhasil disimpan.');
    }
}
