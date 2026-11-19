<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use App\Support\ImageStorage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function index(): View
    {
        return view('admin.experiences.index', [
            'experiences' => Experience::query()->ordered()->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('admin.experiences.form', [
            'experience' => new Experience(['type' => 'plk', 'is_current' => false, 'sort_order' => 0]),
            'types' => Experience::TYPES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);
        $validated['image'] = ImageStorage::store($request->file('image'), 'experiences');

        Experience::query()->create($validated);

        return redirect()
            ->route('admin.experiences.index')
            ->with('success', 'Pengalaman berhasil ditambahkan.');
    }

    public function show(Experience $experience): RedirectResponse
    {
        return redirect()->route('admin.experiences.edit', $experience);
    }

    public function edit(Experience $experience): View
    {
        return view('admin.experiences.form', [
            'experience' => $experience,
            'types' => Experience::TYPES,
        ]);
    }

    public function update(Request $request, Experience $experience): RedirectResponse
    {
        $validated = $this->validated($request);
        $validated['image'] = ImageStorage::replace($request->file('image'), 'experiences', $experience->image);

        $experience->update($validated);

        return redirect()
            ->route('admin.experiences.index')
            ->with('success', 'Pengalaman berhasil diperbarui.');
    }

    public function destroy(Experience $experience): RedirectResponse
    {
        ImageStorage::delete($experience->image);
        $experience->delete();

        return redirect()
            ->route('admin.experiences.index')
            ->with('success', 'Pengalaman berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'organization' => ['required', 'string', 'max:150'],
            'position' => ['nullable', 'string', 'max:100'],
            'type' => ['required', 'in:'.implode(',', array_keys(Experience::TYPES))],
            // Tanggal boleh kosong untuk pengalaman yang periodenya hanya
            // diketahui sebagai teks (contoh: "Saat Kelas XI").
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', ...($request->filled('start_date') ? ['after_or_equal:start_date'] : [])],
            'is_current' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string', 'max:2000'],
            'image' => ['nullable', 'image', 'max:4096'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [
            'title.required' => 'Judul pengalaman wajib diisi.',
            'organization.required' => 'Nama organisasi wajib diisi.',
            'end_date.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
        ]);

        $validated['is_current'] = $request->boolean('is_current');

        if ($validated['is_current']) {
            $validated['end_date'] = null;
        }

        return $validated;
    }
}
