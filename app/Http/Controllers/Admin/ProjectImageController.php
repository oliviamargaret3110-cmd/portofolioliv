<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Support\ImageStorage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProjectImageController extends Controller
{
    /**
     * Upload satu gambar dokumentasi proyek.
     */
    public function store(Request $request, Project $project): RedirectResponse
    {
        $validated = $request->validate([
            'image' => ['required', 'image', 'max:4096'],
            'caption' => ['nullable', 'string', 'max:150'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [
            'image.required' => 'Pilih gambar yang akan diunggah.',
            'image.image' => 'File harus berupa gambar.',
            'image.max' => 'Ukuran gambar maksimal 4 MB.',
        ]);

        $project->images()->create([
            'image' => ImageStorage::store($request->file('image'), 'projects'),
            'caption' => $validated['caption'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()
            ->route('admin.projects.show', $project)
            ->with('success', 'Gambar dokumentasi berhasil diunggah.');
    }

    /**
     * Hapus gambar dokumentasi beserta file fisiknya.
     */
    public function destroy(ProjectImage $projectImage): RedirectResponse
    {
        $project = $projectImage->project;

        ImageStorage::delete($projectImage->image);
        $projectImage->delete();

        return redirect()
            ->route('admin.projects.show', $project)
            ->with('success', 'Gambar dokumentasi berhasil dihapus.');
    }
}
