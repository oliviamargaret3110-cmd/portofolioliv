<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index(): View
    {
        return view('admin.skills.index', [
            'skills' => Skill::query()->ordered()->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('admin.skills.form', [
            'skill' => new Skill(['category' => 'hard', 'percentage' => 80, 'sort_order' => 0]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Skill::query()->create($this->validated($request));

        return redirect()
            ->route('admin.skills.index')
            ->with('success', 'Keahlian berhasil ditambahkan.');
    }

    public function show(Skill $skill): RedirectResponse
    {
        return redirect()->route('admin.skills.edit', $skill);
    }

    public function edit(Skill $skill): View
    {
        return view('admin.skills.form', ['skill' => $skill]);
    }

    public function update(Request $request, Skill $skill): RedirectResponse
    {
        $skill->update($this->validated($request));

        return redirect()
            ->route('admin.skills.index')
            ->with('success', 'Keahlian berhasil diperbarui.');
    }

    public function destroy(Skill $skill): RedirectResponse
    {
        $skill->delete();

        return redirect()
            ->route('admin.skills.index')
            ->with('success', 'Keahlian berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'category' => ['required', 'in:hard,soft'],
            'percentage' => ['required', 'integer', 'min:0', 'max:100'],
            'icon' => ['nullable', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [
            'name.required' => 'Nama keahlian wajib diisi.',
            'percentage.required' => 'Persentase wajib diisi.',
        ]);
    }
}
