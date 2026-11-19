<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Support\ImageStorage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index(): View
    {
        return view('admin.certificates.index', [
            'certificates' => Certificate::query()->ordered()->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('admin.certificates.form', [
            'certificate' => new Certificate(['category' => 'pelatihan', 'sort_order' => 0]),
            'categories' => Certificate::CATEGORIES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);
        $validated['image'] = ImageStorage::store($request->file('image'), 'certificates');

        Certificate::query()->create($validated);

        return redirect()
            ->route('admin.certificates.index')
            ->with('success', 'Sertifikat berhasil ditambahkan.');
    }

    public function show(Certificate $certificate): RedirectResponse
    {
        return redirect()->route('admin.certificates.edit', $certificate);
    }

    public function edit(Certificate $certificate): View
    {
        return view('admin.certificates.form', [
            'certificate' => $certificate,
            'categories' => Certificate::CATEGORIES,
        ]);
    }

    public function update(Request $request, Certificate $certificate): RedirectResponse
    {
        $validated = $this->validated($request);
        $validated['image'] = ImageStorage::replace($request->file('image'), 'certificates', $certificate->image);

        $certificate->update($validated);

        return redirect()
            ->route('admin.certificates.index')
            ->with('success', 'Sertifikat berhasil diperbarui.');
    }

    public function destroy(Certificate $certificate): RedirectResponse
    {
        ImageStorage::delete($certificate->image);
        $certificate->delete();

        return redirect()
            ->route('admin.certificates.index')
            ->with('success', 'Sertifikat berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'organizer' => ['required', 'string', 'max:150'],
            'date' => ['required', 'date'],
            'description' => ['nullable', 'string', 'max:2000'],
            'image' => ['nullable', 'image', 'max:4096'],
            'category' => ['required', 'in:'.implode(',', array_keys(Certificate::CATEGORIES))],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [
            'title.required' => 'Judul sertifikat wajib diisi.',
            'organizer.required' => 'Penerbit wajib diisi.',
            'date.required' => 'Tanggal wajib diisi.',
        ]);
    }
}
