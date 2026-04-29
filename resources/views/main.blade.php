<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', __('Guide Gluten-Free'))</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts: Outfit & Playfair Display -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- AOS (Animate On Scroll) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Canvas Confetti -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        

        :root {
            --bg-body: #fcfbf7;
            --text-main: #1a1f1a;
            --bg-soft: #f4f1ea;
            --btn-bg: #2d5a27;
            --btn-hover: #1e3d1a;
            --card-bg: #ffffff;
            --border-color: #e9e5de;
            --accent: #d4a373;
            --glass-bg: rgba(255, 255, 255, 0.8);
            --header-height: 80px;
        }
        
        [data-bs-theme="dark"] {
            --bg-body: #0a0c0a;
            --text-main: #e8ede8;
            --bg-soft: #141814;
            --btn-bg: #4a8c3d;
            --btn-hover: #5db04d;
            --card-bg: #1a1f1a;
            --border-color: #2a332a;
            --glass-bg: rgba(26, 31, 26, 0.85);
        }

        body { 
            font-family: 'Outfit', sans-serif; 
            background-color: var(--bg-body); 
            color: var(--text-main);
            transition: background-color 0.4s cubic-bezier(0.4, 0, 0.2, 1), color 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-x: hidden;
        }
        
        h1, h2, h3, h4, h5, h6, .brand-font {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
        }

        /* Glassmorphism Utilities */
        .glass {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--border-color);
        }

        /* Premium Buttons */
        .btn-main { 
            background-color: var(--btn-bg); 
            color: #fff; 
            border-radius: 50px; 
            border: none; 
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); 
            font-weight: 600;
            padding: 10px 25px;
            letter-spacing: 0.5px;
        }
        .btn-main:hover { 
            background-color: var(--btn-hover); 
            color: #fff; 
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 10px 20px rgba(45, 90, 39, 0.2);
        }
        
        /* Modern Cards */
        .card-custom { 
            background-color: var(--card-bg); 
            border: 1px solid var(--border-color);
            border-radius: 24px; 
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); 
            color: var(--text-main);
            overflow: hidden;
        }
        .card-custom:hover { 
            transform: translateY(-10px); 
            box-shadow: 0 20px 40px rgba(0,0,0,0.06); 
            border-color: var(--btn-bg);
        }

        .section { padding: 80px 0; }
        .bg-soft { background-color: var(--bg-soft); }
        .bg-white-adaptive { background-color: #ffffff; }
        [data-bs-theme="dark"] .bg-white-adaptive { background-color: var(--card-bg); }
        .text-adaptive { color: var(--text-main); }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: var(--bg-body); }
        ::-webkit-scrollbar-thumb { background: var(--btn-bg); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--btn-hover); }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fadeIn 0.8s ease forwards; }

        /* Active link animation */
        .nav-link { position: relative; transition: 0.3s; }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--btn-bg);
            transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateX(-50%);
        }
        .nav-link:hover::after { width: 70%; }

        /* Back Button Style */
        .btn-back {
            background-color: var(--bg-soft);
            color: var(--text-main);
            border: 1px solid var(--border-color);
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .btn-back:hover {
            background-color: var(--border-color);
            transform: translateX(-5px);
            color: var(--btn-bg);
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        }
    </style>
    
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
                document.documentElement.setAttribute('data-bs-theme', 'dark');
            }
        })();
    </script>
</head>
<body>

@include('header')

<main style="margin-top: calc(var(--header-height) + 20px);">
    <div class="container mb-4">
        @if(!request()->routeIs('home'))
            <a href="javascript:history.back()" class="btn-back animate-fade-in">
                <i class="fas fa-arrow-left"></i>
                {{ __('Retour') }}
            </a>
        @endif
    </div>

    <div id="swup" class="transition-fade">
        @yield('content')
    </div>
</main>

@include('footer')

<x-daily-challenge />

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Init AOS
        AOS.init({
            duration: 800,
            once: true,
            easing: 'ease-out-cubic'
        });

        const themeToggle = document.getElementById('theme-toggle');
        if (themeToggle) {
            const icon = themeToggle.querySelector('i');
            
            function updateIcon(theme) {
                if (theme === 'dark') {
                    icon.classList.remove('fa-moon');
                    icon.classList.add('fa-sun');
                } else {
                    icon.classList.remove('fa-sun');
                    icon.classList.add('fa-moon');
                }
            }
            
            const currentTheme = document.documentElement.getAttribute('data-bs-theme');
            updateIcon(currentTheme);
 
            themeToggle.addEventListener('click', () => {
                let theme = document.documentElement.getAttribute('data-bs-theme');
                let newTheme = theme === 'dark' ? 'light' : 'dark';
                
                document.documentElement.setAttribute('data-bs-theme', newTheme);
                localStorage.setItem('theme', newTheme);
                updateIcon(newTheme);
            });
        }
    });

    // Global Favorite Toggle AJAX
    document.addEventListener('submit', function(e) {
        if (e.target.classList && e.target.classList.contains('favorite-toggle-form')) {
            e.preventDefault();
            const form = e.target;
            const btn = form.querySelector('button[type="submit"]') || form.querySelector('button');
            const icon = btn ? btn.querySelector('i') : null;
            const formData = new FormData(form);
            const url = form.action;

            if (btn) btn.disabled = true;

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'added') {
                    if (icon) {
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                    }
                    // If there's text in the button, update it
                    if (btn && btn.textContent.includes('Ajouter aux favoris')) {
                        btn.innerHTML = '<i class="fas fa-heart me-2"></i>Retirer des favoris';
                    }
                } else if (data.status === 'removed') {
                    if (icon) {
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                    }
                    // If there's text in the button, update it
                    if (btn && btn.textContent.includes('Retirer des favoris')) {
                        btn.innerHTML = '<i class="far fa-heart me-2"></i>Ajouter aux favoris';
                    }
                    
                    // Specific behavior for favorites page: hide the card
                    if (window.location.pathname.includes('/favorites')) {
                        const cardColumn = form.closest('.col-md-6, .col-lg-4, .col-xl-3');
                        if (cardColumn) {
                            cardColumn.style.transition = 'all 0.4s ease';
                            cardColumn.style.opacity = '0';
                            cardColumn.style.transform = 'scale(0.8)';
                            setTimeout(() => {
                                cardColumn.remove();
                                // Check if tab is now empty
                                const tabPane = form.closest('.tab-pane') || document.querySelector('.row.g-4');
                                if (tabPane && tabPane.querySelectorAll('.card').length === 0) {
                                    location.reload(); // Quick way to show "No favorites" message
                                }
                            }, 400);
                        }
                    }
                } else if (data.status === 'error') {
                    // Show login prompt if unauthenticated
                    alert(data.message);
                }
            })
            .catch(err => {
                console.error(err);
                if (err.status === 401) {
                    window.location.href = '/login';
                }
            })
            .finally(() => {
                if (btn) btn.disabled = false;
            });
        }
    });

    // Header scroll effect
    window.addEventListener('scroll', () => {
        const header = document.querySelector('.navbar-custom');
        if (window.scrollY > 50) {
            header.classList.add('glass', 'shadow-sm', 'py-2');
            header.classList.remove('py-3');
        } else {
            header.classList.remove('glass', 'shadow-sm', 'py-2');
            header.classList.add('py-3');
        }
    });
</script>

</body>
</html>