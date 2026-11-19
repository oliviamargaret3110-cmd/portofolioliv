<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    /**
     * Galeri sertifikat dan prestasi dengan filter kategori dan pencarian.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q'));
        $category = (string) $request->query('category');

        $certificates = Certificate::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('title', 'like', "%{$search}%")
                        ->orWhere('organizer', 'like', "%{$search}%");
                });
            })
            ->when(array_key_exists($category, Certificate::CATEGORIES), fn ($query) => $query->where('category', $category))
            ->ordered()
            ->paginate(9)
            ->withQueryString();

        return view('pages.certificates.index', [
            'certificates' => $certificates,
            'categories' => Certificate::CATEGORIES,
            'search' => $search,
            'activeCategory' => $category,
        ]);
    }
}
