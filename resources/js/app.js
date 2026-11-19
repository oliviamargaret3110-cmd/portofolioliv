import AOS from 'aos';
import 'aos/dist/aos.css';

document.addEventListener('DOMContentLoaded', () => {
    // Animasi muncul saat scroll (AOS)
    AOS.init({
        duration: 700,
        easing: 'ease-out-cubic',
        once: true,
        offset: 80,
    });

    const root = document.documentElement;

    // ===== Dark / Light Mode =====
    const applyTheme = (isDark) => {
        root.classList.toggle('dark', isDark);
        document.querySelectorAll('[data-theme-icon="sun"]').forEach((icon) => {
            icon.classList.toggle('hidden', !isDark);
        });
        document.querySelectorAll('[data-theme-icon="moon"]').forEach((icon) => {
            icon.classList.toggle('hidden', isDark);
        });
    };

    applyTheme(root.classList.contains('dark'));

    document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
        button.addEventListener('click', () => {
            const isDark = !root.classList.contains('dark');
            applyTheme(isDark);
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        });
    });

    // ===== Menu mobile =====
    document.querySelectorAll('[data-mobile-menu-toggle]').forEach((button) => {
        const target = document.querySelector(button.dataset.mobileMenuToggle);
        if (!target) {
            return;
        }

        const openIcon = button.querySelector('[data-menu-open-icon]');
        const closeIcon = button.querySelector('[data-menu-close-icon]');
        const setMenuOpen = (isOpen) => {
            target.classList.toggle('hidden', !isOpen);
            button.setAttribute('aria-expanded', String(isOpen));
            button.setAttribute('aria-label', isOpen ? 'Tutup menu' : 'Buka menu');
            openIcon?.classList.toggle('hidden', isOpen);
            closeIcon?.classList.toggle('hidden', !isOpen);
        };

        button.addEventListener('click', () => {
            setMenuOpen(target.classList.contains('hidden'));
        });

        target.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => setMenuOpen(false));
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && button.getAttribute('aria-expanded') === 'true') {
                setMenuOpen(false);
                button.focus();
            }
        });
    });

    // ===== Tombol kembali ke atas =====
    const backToTop = document.querySelector('[data-back-to-top]');
    if (backToTop) {
        const toggleBackToTop = () => {
            backToTop.classList.toggle('opacity-0', window.scrollY < 400);
            backToTop.classList.toggle('pointer-events-none', window.scrollY < 400);
        };

        toggleBackToTop();
        window.addEventListener('scroll', toggleBackToTop, { passive: true });

        backToTop.addEventListener('click', (event) => {
            event.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // ===== Lightbox gambar (sertifikat & screenshot) =====
    const lightbox = document.getElementById('lightbox');
    if (lightbox) {
        const image = lightbox.querySelector('[data-lightbox-image]');

        const closeLightbox = () => {
            lightbox.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            if (image) {
                image.src = '';
            }
        };

        document.querySelectorAll('[data-lightbox]').forEach((element) => {
            element.addEventListener('click', () => {
                if (!image) {
                    return;
                }

                image.src = element.dataset.lightbox;
                image.alt = element.dataset.lightboxAlt || 'Preview gambar';
                lightbox.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            });
        });

        lightbox.querySelectorAll('[data-lightbox-close]').forEach((button) => {
            button.addEventListener('click', closeLightbox);
        });

        lightbox.addEventListener('click', (event) => {
            if (event.target === lightbox) {
                closeLightbox();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeLightbox();
            }
        });
    }

    // ===== Konfirmasi hapus =====
    document.querySelectorAll('form[data-confirm]').forEach((form) => {
        form.addEventListener('submit', (event) => {
            if (!window.confirm(form.dataset.confirm)) {
                event.preventDefault();
            }
        });
    });

    // ===== Notifikasi flash hilang otomatis =====
    document.querySelectorAll('[data-flash]').forEach((element) => {
        window.setTimeout(() => {
            element.classList.add('opacity-0', 'translate-y-2');
            window.setTimeout(() => element.remove(), 400);
        }, 5000);
    });
});
