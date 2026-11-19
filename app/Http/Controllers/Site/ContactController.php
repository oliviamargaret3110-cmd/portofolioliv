<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Contracts\View\View;

class ContactController extends Controller
{
    /**
     * Halaman kontak berisi informasi kontak dan form pesan.
     */
    public function index(): View
    {
        return view('pages.contact', [
            'profile' => Profile::query()->first(),
        ]);
    }
}
