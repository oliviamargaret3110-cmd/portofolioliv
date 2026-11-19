@if (session('success') || session('error') || session('status'))
    <div class="container-page no-print mt-6">
        @if (session('success'))
            <div data-flash class="flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 transition duration-300 dark:border-emerald-900 dark:bg-emerald-950/50 dark:text-emerald-300">
                <i class="fa-solid fa-circle-check mt-0.5"></i>
                <p class="flex-1">{{ session('success') }}</p>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800 dark:text-emerald-400" aria-label="Tutup">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if (session('status'))
            <div data-flash class="flex items-start gap-3 rounded-2xl border border-indigo-200 bg-indigo-50 px-4 py-3 text-sm text-indigo-800 transition duration-300 dark:border-indigo-900 dark:bg-indigo-950/50 dark:text-indigo-300">
                <i class="fa-solid fa-circle-info mt-0.5"></i>
                <p class="flex-1">{{ session('status') }}</p>
                <button type="button" onclick="this.parentElement.remove()" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400" aria-label="Tutup">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div data-flash class="flex items-start gap-3 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800 transition duration-300 dark:border-rose-900 dark:bg-rose-950/50 dark:text-rose-300">
                <i class="fa-solid fa-circle-exclamation mt-0.5"></i>
                <p class="flex-1">{{ session('error') }}</p>
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-800 dark:text-rose-400" aria-label="Tutup">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif
    </div>
@endif
