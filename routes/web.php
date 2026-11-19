<?php

use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EducationController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ProjectImageController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Site\AboutController;
use App\Http\Controllers\Site\BlogController;
use App\Http\Controllers\Site\CertificateController as SiteCertificateController;
use App\Http\Controllers\Site\ContactController;
use App\Http\Controllers\Site\CvController;
use App\Http\Controllers\Site\ExperienceController as SiteExperienceController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\MessageController as SiteMessageController;
use App\Http\Controllers\Site\ProjectController as SiteProjectController;
use App\Http\Controllers\Site\SkillController as SiteSkillController;
use App\Http\Controllers\Site\TestimonialController as SiteTestimonialController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman Publik
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/skills', [SiteSkillController::class, 'index'])->name('skills');
Route::get('/projects', [SiteProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project}', [SiteProjectController::class, 'show'])->name('projects.show');
Route::get('/certificates', [SiteCertificateController::class, 'index'])->name('certificates.index');
Route::get('/experiences', [SiteExperienceController::class, 'index'])->name('experiences.index');
Route::get('/cv', [CvController::class, 'show'])->name('cv.show');
Route::get('/cv/print', [CvController::class, 'print'])->name('cv.print');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/testimonials', [SiteTestimonialController::class, 'index'])->name('testimonials.index');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');

// Form kesan & pesan pengunjung
Route::post('/messages', [SiteMessageController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('messages.store');

/*
|--------------------------------------------------------------------------
| Autentikasi Admin
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function (): void {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Dashboard Admin (wajib login + admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function (): void {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('projects', ProjectController::class);
    Route::post('projects/{project}/images', [ProjectImageController::class, 'store'])->name('projects.images.store');
    Route::delete('project-images/{projectImage}', [ProjectImageController::class, 'destroy'])->name('project-images.destroy');

    Route::resource('certificates', CertificateController::class);
    Route::resource('experiences', ExperienceController::class);
    Route::resource('skills', SkillController::class);
    Route::resource('educations', EducationController::class);
    Route::resource('testimonials', TestimonialController::class);
    Route::resource('posts', PostController::class);

    Route::get('messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('messages/{message}', [MessageController::class, 'show'])->name('messages.show');
    Route::patch('messages/{message}/read', [MessageController::class, 'markAsRead'])->name('messages.read');
    Route::delete('messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
});
