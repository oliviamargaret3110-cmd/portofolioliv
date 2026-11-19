<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function index(): View
    {
        return view('admin.educations.index', [
            'educations' => Education::query()->ordered()->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('admin.educations.form', [
            'education' => new Education(['sort_order' => 0]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Education::query()->create($this->validated($request));

        return redirect()
            ->route('admin.educations.index')
            ->with('success', 'Pendidikan berhasil ditambahkan.');
    }

    public function show(Education $education): RedirectResponse
    {
        return redirect()->route('admin.educations.edit', $education);
    }

    public function edit(Education $education): View
    {
        return view('admin.educations.form', ['education' => $education]);
    }

    public function update(Request $request, Education $education): RedirectResponse
    {
        $education->update($this->validated($request));

        return redirect()
            ->route('admin.educations.index')
            ->with('success', 'Pendidikan berhasil diperbarui.');
    }

    public function destroy(Education $education): RedirectResponse
    {
        $education->delete();

        return redirect()
            ->route('admin.educations.index')
            ->with('success', 'Pendidikan berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        return $request->validate([
            'level' => ['required', 'string', 'max:50'],
            'school_name' => ['required', 'string', 'max:150'],
            'major' => ['nullable', 'string', 'max:100'],
            'start_year' => ['required', 'integer', 'min:1900', 'max:2100'],
            'end_year' => ['nullable', 'integer', 'min:1900', 'max:2100', 'gte:start_year'],
            'description' => ['nullable', 'string', 'max:2000'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [
            'level.required' => 'Jenjang pendidikan wajib diisi.',
            'school_name.required' => 'Nama sekolah wajib diisi.',
            'start_year.required' => 'Tahun mulai wajib diisi.',
            'end_year.gte' => 'Tahun selesai tidak boleh lebih kecil dari tahun mulai.',
        ]);
    }
}
