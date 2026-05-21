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
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap"
        rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- AOS (Animate On Scroll) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Marked.js (Markdown Parser) -->
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

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

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .brand-font {
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
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06);
            border-color: var(--btn-bg);
        }

        .section {
            padding: 80px 0;
        }

        .bg-soft {
            background-color: var(--bg-soft);
        }

        .bg-white-adaptive {
            background-color: #ffffff;
        }

        [data-bs-theme="dark"] .bg-white-adaptive {
            background-color: var(--card-bg);
        }

        .text-adaptive {
            color: var(--text-main);
        }

        .text-main {
            color: var(--text-main) !important;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-body);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--btn-bg);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--btn-hover);
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.8s ease forwards;
        }

        /* Active link animation */
        .nav-link {
            position: relative;
            transition: 0.3s;
        }

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

        .nav-link:hover::after {
            width: 70%;
        }

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
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .btn-back:hover {
            background-color: var(--border-color);
            transform: translateX(-5px);
            color: var(--btn-bg);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        /* ── Notification Dropdown ── */
        .notif-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 16px;
            border-bottom: 1px solid var(--border-color);
            cursor: pointer;
            transition: background 0.2s ease;
            text-decoration: none;
            color: var(--text-main);
        }

        .notif-item:last-child {
            border-bottom: none;
        }

        .notif-item:hover {
            background: var(--bg-soft);
        }

        .notif-item.unread {
            background: rgba(45, 90, 39, 0.06);
        }

        .notif-item.unread:hover {
            background: rgba(45, 90, 39, 0.1);
        }

        .notif-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
            border: 2px solid var(--border-color);
        }

        .notif-avatar-placeholder {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            flex-shrink: 0;
            background: linear-gradient(135deg, var(--btn-bg), var(--btn-hover));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
            font-weight: 700;
        }

        .notif-icon-badge {
            position: absolute;
            bottom: -2px;
            right: -2px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.6rem;
            border: 2px solid var(--card-bg);
        }

        .notif-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--btn-bg);
            flex-shrink: 0;
            margin-top: 6px;
        }

        /* AI Assistant Floating Button */
        .ai-assistant-btn {

            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--btn-bg), var(--btn-hover));
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 10px 20px rgba(45, 90, 39, 0.3);
            z-index: 9999;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            text-decoration: none;
            cursor: pointer;
        }

        .ai-assistant-btn:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 15px 25px rgba(45, 90, 39, 0.4);
            color: #fff;
        }

        .ai-assistant-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            width: 16px;
            height: 16px;
            background-color: #e74c3c;
            border-radius: 50%;
            border: 2px solid var(--bg-body);
        }

        /* AI Chat Window */
        .ai-chat-window {
            position: fixed;
            bottom: 100px;
            right: 30px;
            width: 380px;
            border-radius: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            border: 1px solid var(--border-color);
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            transform-origin: bottom right;
        }

        .ai-chat-window.d-none {
            transform: scale(0);
            opacity: 0;
            pointer-events: none;
        }

        .ai-chat-window:not(.d-none) {
            transform: scale(1);
            opacity: 1;
            pointer-events: all;
        }

        @media (max-width: 576px) {
            .ai-chat-window {
                width: calc(100% - 40px);
                right: 20px;
                bottom: 90px;
            }
        }

        .chat-message-user {
            background: linear-gradient(135deg, var(--btn-bg), var(--btn-hover));
            color: white;
            padding: 12px 16px;
            border-radius: 18px;
            border-bottom-right-radius: 0;
            max-width: 85%;
            margin-left: auto;
            margin-bottom: 15px;
            box-shadow: 0 4px 10px rgba(45, 90, 39, 0.15);
        }

        .chat-message-ai {
            background-color: var(--bg-soft);
            color: var(--text-main);
            padding: 12px 16px;
            border-radius: 18px;
            border-bottom-left-radius: 0;
            max-width: 90%;
            margin-bottom: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            line-height: 1.5;
        }

        .chat-message-ai p:last-child {
            margin-bottom: 0;
        }

        .chat-message-ai a {
            color: var(--btn-bg);
            font-weight: 600;
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .chat-message-ai ul,
        .chat-message-ai ol {
            padding-left: 20px;
            margin-bottom: 10px;
        }

        .typing-indicator span {
            display: inline-block;
            width: 8px;
            height: 8px;
            background-color: var(--text-main);
            border-radius: 50%;
            margin: 0 2px;
            opacity: 0.6;
            animation: typing 1.4s infinite ease-in-out both;
        }

        .typing-indicator span:nth-child(1) {
            animation-delay: -0.32s;
        }

        .typing-indicator span:nth-child(2) {
            animation-delay: -0.16s;
        }

        @keyframes typing {
            0%, 80%, 100% { transform: scale(0); }
            40%            { transform: scale(1); }
        }

        /* ── Message wrappers with hover actions ────────── */
        .msg-wrapper {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
            position: relative;
        }
        .msg-wrapper--user  { align-items: flex-end; }
        .msg-wrapper--assistant { align-items: flex-start; }

        /* Remove bottom margin from the bubble itself (wrapper handles it) */
        .msg-wrapper .chat-message-user,
        .msg-wrapper .chat-message-ai { margin-bottom: 4px; }

        /* Action buttons row */
        .msg-actions {
            display: flex;
            gap: 4px;
            opacity: 0;
            transition: opacity .18s;
            padding: 2px 6px;
        }
        .msg-wrapper:hover .msg-actions { opacity: 1; }

        .msg-btn {
            background: var(--bg-soft);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            border-radius: 50%;
            width: 28px; height: 28px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            font-size: .68rem;
            transition: all .15s;
            padding: 0;
        }
        .msg-btn:hover {
            background: var(--btn-bg);
            color: #fff;
            border-color: var(--btn-bg);
            transform: scale(1.12);
        }
        .msg-btn.copied { background: #16a34a; color: #fff; border-color: #16a34a; }

        /* Inline edit form */
        .msg-edit-form { width: 85%; }
        .msg-edit-form textarea {
            width: 100%;
            border-radius: 14px;
            border: 2px solid var(--btn-bg);
            background: var(--card-bg);
            color: var(--text-main);
            padding: 10px 14px;
            font-size: .875rem;
            resize: none;
            outline: none;
            min-height: 64px;
            font-family: inherit;
        }
        .msg-edit-actions { display: flex; gap: 8px; justify-content: flex-end; margin-top: 6px; }
        .msg-edit-btn {
            border: none; border-radius: 20px;
            padding: 5px 16px; font-size: .8rem; font-weight: 600; cursor: pointer;
            transition: all .15s;
        }
        .msg-edit-btn--cancel { background: var(--bg-soft); color: var(--text-main); }
        .msg-edit-btn--confirm { background: var(--btn-bg); color: #fff; }
        .msg-edit-btn:hover { opacity: .85; }

        /* Reply preview bar above input */
        .reply-preview-bar {
            display: flex; align-items: center; gap: 10px;
            background: var(--bg-soft);
            border-left: 3px solid var(--btn-bg);
            border-radius: 0 10px 10px 0;
            padding: 7px 12px;
            margin-bottom: 8px;
            font-size: .78rem;
            color: var(--text-main);
            animation: slideUp .2s ease;
        }
        .reply-preview-bar .reply-icon { color: var(--btn-bg); flex-shrink: 0; }
        .reply-preview-bar .reply-text {
            flex: 1; overflow: hidden;
            white-space: nowrap; text-overflow: ellipsis;
            opacity: .8;
        }
        .reply-preview-bar .reply-close {
            background: none; border: none;
            color: var(--text-main); opacity: .45;
            cursor: pointer; padding: 0; font-size: .9rem; flex-shrink: 0;
        }
        .reply-preview-bar .reply-close:hover { opacity: 1; }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(6px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>

    <script>
        (function () {
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

    <main>
        <div class="container mb-4">
            @if(!request()->routeIs('home'))
                <a href="javascript:history.back()" class="btn-back animate-fade-in mt-2">
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

    <div id="ai-chat-window" class="ai-chat-window shadow-2xl glass d-none">
        <div class="chat-header d-flex justify-content-between align-items-center p-3 border-bottom border-color"
            style="background-color: var(--btn-bg); color: white; border-radius: 20px 20px 0 0;">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-white rounded-circle d-flex align-items-center justify-content-center"
                    style="width: 40px; height: 40px; color: var(--btn-bg);">
                    <i class="fas fa-robot fs-5"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold brand-font" style="font-size: 1.1rem;">Gluto IA</h5>
                    <small class="opacity-75"
                        style="font-size: 0.75rem;">{{ __('Votre assistant Sans Gluten') }}</small>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                @auth
                    <button class="btn btn-sm btn-link text-white p-0 me-2" id="chat-history-toggle"
                        onclick="toggleHistoryView()" title="{{ __('Historique') }}" style="box-shadow: none;">
                        <i class="fas fa-history fs-5"></i>
                    </button>
                @endauth
                <button class="btn-close btn-close-white opacity-75 hover-opacity-100" onclick="toggleChat()"></button>
            </div>
        </div>
        <div class="chat-messages p-3" id="chat-messages"
            style="height: 380px; overflow-y: auto; background-color: var(--bg-body);">
            <!-- Default welcome message -->
            <div class="chat-message-ai">
                👋 <strong>Bonjour !</strong> Je suis <strong>Gluto</strong>. Je peux vous aider à trouver des produits,
                des recettes, ou répondre à vos questions sur le mode de vie Sans Gluten. Que cherchez-vous ?
            </div>

            <!-- Suggestion Chips -->
            <div class="d-flex flex-wrap gap-2 mt-2 mb-3" id="chat-suggestions">
                <button onclick="sendSuggestedQuestion('🛒 Chercher du pain sans gluten')"
                    class="btn btn-sm btn-outline-secondary rounded-pill bg-white text-dark shadow-sm border-0"
                    style="font-size: 0.85rem;">🛒 Pain sans gluten</button>
                <button onclick="sendSuggestedQuestion('🍽️ Idée de recette dessert')"
                    class="btn btn-sm btn-outline-secondary rounded-pill bg-white text-dark shadow-sm border-0"
                    style="font-size: 0.85rem;">🍽️ Recette dessert</button>
                <button onclick="sendSuggestedQuestion('📍 Magasins à Casablanca')"
                    class="btn btn-sm btn-outline-secondary rounded-pill bg-white text-dark shadow-sm border-0"
                    style="font-size: 0.85rem;">📍 Magasins à Casablanca</button>
                <button onclick="sendSuggestedQuestion('🩺 C\'est quoi la maladie cœliaque ?')"
                    class="btn btn-sm btn-outline-secondary rounded-pill bg-white text-dark shadow-sm border-0"
                    style="font-size: 0.85rem;">🩺 Maladie cœliaque ?</button>
            </div>
        </div>

        @auth
            <div class="chat-input p-3 border-top border-color"
                style="background-color: var(--card-bg); border-radius: 0 0 20px 20px;">
                <div id="reply-preview-bar" class="reply-preview-bar d-none">
                    <i class="fas fa-reply reply-icon"></i>
                    <span class="reply-text" id="reply-preview-text"></span>
                    <button class="reply-close" onclick="cancelReply()" title="Annuler"><i class="fas fa-times"></i></button>
                </div>
                <form id="chat-form" class="d-flex gap-2" onsubmit="sendChatMessage(event)">
                    <input type="text" id="chat-input-field"
                        class="form-control rounded-pill border-color bg-soft text-main shadow-none px-4"
                        placeholder="{{ __('Demandez à Gluto...') }}" required autocomplete="off">
                    <button type="submit"
                        class="btn btn-main rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 45px; height: 45px; flex-shrink: 0;" id="chat-submit-btn">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        @else
            <div class="chat-input p-4 border-top border-color text-center animate-fade-in"
                style="background-color: var(--card-bg); border-radius: 0 0 20px 20px;">
                <p class="mb-3 small fw-bold" style="color: var(--text-main);">
                    {{ __('Veuillez vous connecter pour discuter avec Gluto 😊') }}</p>
                <a href="{{ route('login') }}"
                    class="btn btn-main btn-sm rounded-pill px-4 py-2 w-100 fw-bold shadow-sm">{{ __('Se connecter') }}</a>
            </div>
        @endauth

        @auth
            <!-- Chat History Panel Overlay -->
            <div id="chat-history-panel" class="chat-history-panel d-none position-absolute w-100 h-100"
                style="top: 0; left: 0; border-radius: 20px; background-color: var(--card-bg); z-index: 10; display: flex; flex-direction: column;">
                <div class="d-flex justify-content-between align-items-center p-3 border-bottom border-color"
                    style="background-color: var(--btn-bg); color: white; border-radius: 20px 20px 0 0;">
                    <h6 class="mb-0 fw-bold brand-font"><i class="fas fa-history me-2"></i>{{ __('Historique') }}</h6>
                    <button class="btn-close btn-close-white opacity-75 hover-opacity-100"
                        onclick="toggleHistoryView()"></button>
                </div>
                <div class="p-3 border-bottom border-color d-flex gap-2">
                    <button class="btn btn-main btn-sm rounded-pill w-100 fw-bold shadow-sm"
                        onclick="startNewConversation()">
                        <i class="fas fa-plus me-1"></i> {{ __('Nouvelle discussion') }}
                    </button>
                </div>
                <div class="flex-grow-1 p-3 overflow-y-auto" id="history-list-container"
                    style="background-color: var(--bg-body);">
                    <!-- History list items will go here -->
                </div>
            </div>
        @endauth
    </div>

    <!-- AI Assistant Floating Button -->
    <a href="javascript:void(0)" onclick="toggleChat()" class="ai-assistant-btn animate-fade-in"
        title="{{ __('Gluto - Assistant IA') }}">
        <i class="fas fa-robot"></i>
        <span class="ai-assistant-badge d-none" id="chat-badge"></span>
    </a>

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

        // ── Notification System ──
        @auth
            let notificationsLoaded = false;

            function loadNotifications(forceReload = false) {
                if (notificationsLoaded && !forceReload) return;

                const list = document.getElementById('notif-list');
                const empty = document.getElementById('notif-empty');
                const loading = document.getElementById('notif-loading');

                loading.classList.remove('d-none');
                list.innerHTML = '';
                empty.classList.add('d-none');

                fetch('/notifications', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                    .then(r => r.json())
                    .then(data => {
                        loading.classList.add('d-none');
                        updateBadge(data.unread_count);

                        if (!data.notifications || data.notifications.length === 0) {
                            empty.classList.remove('d-none');
                            notificationsLoaded = true;
                            return;
                        }

                        data.notifications.forEach(n => {
                            const avatarHtml = n.avatar
                                ? `<img src="${n.avatar}" class="notif-avatar" alt="${n.actor_name}">`
                                : `<div class="notif-avatar-placeholder">${n.actor_name.charAt(0).toUpperCase()}</div>`;

                            const iconClass = n.type === 'like' ? 'fa-heart bg-danger' : 'fa-comment bg-primary';
                            const unreadClass = n.is_read ? '' : 'unread';
                            const dotHtml = n.is_read ? '' : '<div class="notif-dot ms-auto flex-shrink-0"></div>';

                            const item = document.createElement('a');
                            item.href = n.recipe_url;
                            item.className = `notif-item ${unreadClass}`;
                            item.innerHTML = `
                            <div class="position-relative flex-shrink-0">
                                ${avatarHtml}
                                <span class="notif-icon-badge text-white ${iconClass}" style="background-color: ${n.type === 'like' ? '#e74c3c' : '#3498db'}">
                                    <i class="fas ${n.type === 'like' ? 'fa-heart' : 'fa-comment'}" style="font-size:0.5rem;"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="mb-1 small fw-semibold" style="color: var(--text-main); line-height:1.4;">${n.message}</p>
                                <small class="opacity-50" style="font-size:0.75rem;">${n.time_ago}</small>
                            </div>
                            ${dotHtml}
                        `;

                            item.addEventListener('click', () => {
                                if (!n.is_read) {
                                    fetch(`/notifications/${n.id}/mark-read`, {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                            'Accept': 'application/json'
                                        }
                                    });
                                }
                            });

                            list.appendChild(item);
                        });

                        notificationsLoaded = true;
                    })
                    .catch(() => {
                        loading.classList.add('d-none');
                        empty.classList.remove('d-none');
                    });
            }

            function updateBadge(count) {
                const badge = document.getElementById('notif-badge');
                if (!badge) return;
                if (count > 0) {
                    badge.textContent = count > 9 ? '9+' : count;
                    badge.classList.remove('d-none');
                } else {
                    badge.classList.add('d-none');
                }
            }

            function markAllRead() {
                fetch('/notifications/mark-all-read', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                    .then(() => {
                        document.querySelectorAll('.notif-item.unread').forEach(el => el.classList.remove('unread'));
                        document.querySelectorAll('.notif-dot').forEach(el => el.remove());
                        updateBadge(0);
                        notificationsLoaded = false;
                    });
            }

            // Poll every 60 seconds for new notifications
            document.addEventListener('DOMContentLoaded', () => {
                // Initial badge load (lightweight)
                fetch('/notifications', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                })
                    .then(r => r.json())
                    .then(data => updateBadge(data.unread_count))
                    .catch(() => { });

                setInterval(() => {
                    fetch('/notifications', {
                        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                    })
                        .then(r => r.json())
                        .then(data => {
                            updateBadge(data.unread_count);
                            notificationsLoaded = false; // allow refresh on next open
                        })
                        .catch(() => { });
                }, 60000);
            });
        @endauth

        // Global Favorite Toggle AJAX
        document.addEventListener('submit', function (e) {

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
                            if (btn && btn.textContent.includes('{{ __('Ajouter aux favoris') }}')) {
                                btn.innerHTML = '<i class="fas fa-heart me-2"></i>{{ __('Retirer des favoris') }}';
                            }
                        } else if (data.status === 'removed') {
                            if (icon) {
                                icon.classList.remove('fas');
                                icon.classList.add('far');
                            }
                            // If there's text in the button, update it
                            if (btn && btn.textContent.includes('{{ __('Retirer des favoris') }}')) {
                                btn.innerHTML = '<i class="far fa-heart me-2"></i>{{ __('Ajouter aux favoris') }}';
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

        // Chatbot Logic
        let chatHistory = [];
        let userCoords = null;
        let activeConversationId = null;
        const isAuthenticated = @json(Auth::check());

        function toggleChat() {
            const chatWindow = document.getElementById('ai-chat-window');
            chatWindow.classList.toggle('d-none');

            if (!chatWindow.classList.contains('d-none')) {
                const inputField = document.getElementById('chat-input-field');
                if (inputField) inputField.focus();
            }
        }

        function appendMessage(role, content) {
            const messagesContainer = document.getElementById('chat-messages');
            const msgIndex = chatHistory.length; // index after push, used for edit re-send

            const wrapper = document.createElement('div');

            if (role === 'user') {
                wrapper.className = 'msg-wrapper msg-wrapper--user';
                wrapper.innerHTML = `
                    <div class="chat-message-user"></div>
                    <div class="msg-actions">
                        <button class="msg-btn" title="Modifier" onclick="editMessage(this)"><i class="fas fa-pencil-alt"></i></button>
                    </div>`;
                wrapper.querySelector('.chat-message-user').textContent = content;
            } else {
                wrapper.className = 'msg-wrapper msg-wrapper--assistant';
                const bubble = document.createElement('div');
                bubble.className = 'chat-message-ai';
                bubble.innerHTML = marked.parse(content);
                wrapper.appendChild(bubble);
                const actions = document.createElement('div');
                actions.className = 'msg-actions';
                actions.innerHTML = `
                    <button class="msg-btn" title="Répondre" onclick="replyToMessage(this)"><i class="fas fa-reply"></i></button>
                    <button class="msg-btn" title="Copier" onclick="copyMessage(this)"><i class="fas fa-copy"></i></button>`;
                wrapper.appendChild(actions);
            }

            wrapper.dataset.index = msgIndex;
            messagesContainer.appendChild(wrapper);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
            return wrapper;
        }

        // ── Message actions ────────────────────────────────────────────────
        let activeReply = null; // { text, role }

        function editMessage(btn) {
            const wrapper = btn.closest('.msg-wrapper--user');
            const bubble  = wrapper.querySelector('.chat-message-user');
            // Store original text safely on dataset (avoids quote issues in onclick attrs)
            wrapper.dataset.originalText = bubble.textContent;

            wrapper.innerHTML = `
                <div class="msg-edit-form" style="width:100%;">
                    <textarea class="form-control bg-soft text-main border-color" rows="2" style="resize:none;border-radius:12px;font-size:.93rem;"></textarea>
                    <div class="d-flex gap-2 mt-1 justify-content-end">
                        <button class="msg-edit-btn--cancel btn btn-sm btn-outline-secondary rounded-pill px-3"
                            onclick="cancelEdit(this)">Annuler</button>
                        <button class="msg-edit-btn--confirm btn btn-sm btn-main rounded-pill px-3"
                            onclick="confirmEdit(this)">Envoyer</button>
                    </div>
                </div>`;
            wrapper.querySelector('textarea').value = wrapper.dataset.originalText;
            wrapper.querySelector('textarea').focus();
        }

        function cancelEdit(btn) {
            const wrapper = btn.closest('.msg-wrapper--user');
            const originalText = wrapper.dataset.originalText || '';
            wrapper.innerHTML = `
                <div class="chat-message-user"></div>
                <div class="msg-actions">
                    <button class="msg-btn" title="Modifier" onclick="editMessage(this)"><i class="fas fa-pencil-alt"></i></button>
                </div>`;
            wrapper.querySelector('.chat-message-user').textContent = originalText;
        }

        function confirmEdit(btn) {
            const wrapper   = btn.closest('.msg-wrapper--user');
            const newText   = wrapper.querySelector('textarea').value.trim();
            if (!newText) return;

            const wrapperIndex = parseInt(wrapper.dataset.index, 10);
            chatHistory = chatHistory.slice(0, wrapperIndex);

            // Remove this wrapper and all subsequent message wrappers from DOM
            const container = document.getElementById('chat-messages');
            const allWrappers = [...container.querySelectorAll('.msg-wrapper')];
            allWrappers.forEach(w => {
                if (parseInt(w.dataset.index, 10) >= wrapperIndex) w.remove();
            });

            const inputField = document.getElementById('chat-input-field');
            inputField.value = newText;
            document.getElementById('chat-form').dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
        }

        function replyToMessage(btn) {
            const wrapper = btn.closest('.msg-wrapper--assistant');
            const bubble  = wrapper.querySelector('.chat-message-ai');
            const text    = bubble.innerText || bubble.textContent;
            activeReply   = { text };

            const bar = document.getElementById('reply-preview-bar');
            document.getElementById('reply-preview-text').textContent = text.substring(0, 120) + (text.length > 120 ? '…' : '');
            bar.classList.remove('d-none');
            document.getElementById('chat-input-field').focus();
        }

        function cancelReply() {
            activeReply = null;
            document.getElementById('reply-preview-bar').classList.add('d-none');
        }

        function copyMessage(btn) {
            const wrapper = btn.closest('.msg-wrapper--assistant');
            const text    = wrapper.querySelector('.chat-message-ai').innerText || wrapper.querySelector('.chat-message-ai').textContent;
            navigator.clipboard.writeText(text).then(() => {
                const icon = btn.querySelector('i');
                icon.className = 'fas fa-check';
                btn.title = 'Copié !';
                setTimeout(() => { icon.className = 'fas fa-copy'; btn.title = 'Copier'; }, 2000);
            });
        }
        // ──────────────────────────────────────────────────────────────────

        function showTypingIndicator() {
            const messagesContainer = document.getElementById('chat-messages');
            const div = document.createElement('div');
            div.className = 'chat-message-ai typing-indicator-container';
            div.id = 'typing-indicator';
            div.innerHTML = '<div class="typing-indicator"><span></span><span></span><span></span></div>';
            messagesContainer.appendChild(div);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        function hideTypingIndicator() {
            const indicator = document.getElementById('typing-indicator');
            if (indicator) indicator.remove();
        }

        function sendSuggestedQuestion(text) {
            if (!isAuthenticated) {
                appendMessage('user', text);
                showTypingIndicator();
                setTimeout(() => {
                    hideTypingIndicator();
                    appendMessage('assistant', '⚠️ **Connexion requise** : Veuillez vous connecter pour discuter avec Gluto et obtenir des réponses personnalisées ! 😊');
                }, 600);
                return;
            }
            const inputField = document.getElementById('chat-input-field');
            inputField.value = text;

            // Hide suggestions after clicking one
            const suggestions = document.getElementById('chat-suggestions');
            if (suggestions) suggestions.style.display = 'none';

            // Trigger form submission
            document.getElementById('chat-form').dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
        }

        async function sendChatMessage(e) {
            e.preventDefault();
            const inputField = document.getElementById('chat-input-field');
            const submitBtn = document.getElementById('chat-submit-btn');
            const userText = inputField.value.trim();

            if (!userText) return;

            // Build final content (include reply context if active)
            let finalContent = userText;
            if (activeReply) {
                finalContent = `[En réponse à: "${activeReply.text.substring(0, 80)}…"]\n${userText}`;
                cancelReply();
            }

            // Add user message to UI
            appendMessage('user', userText);
            inputField.value = '';

            // Add to history
            chatHistory.push({ role: 'user', content: finalContent });

            // Show loading
            inputField.disabled = true;
            submitBtn.disabled = true;
            showTypingIndicator();

            // Detect near-me / proximity intent
            const isNearMeQuery = /\b(proche|proximité|proximite|autour|near|près de moi|pres de moi)\b/i.test(userText);

            if (isNearMeQuery && navigator.geolocation && !userCoords) {
                try {
                    const position = await new Promise((resolve, reject) => {
                        navigator.geolocation.getCurrentPosition(resolve, reject, { timeout: 4000 });
                    });
                    userCoords = {
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude
                    };
                } catch (err) {
                    console.warn('Geolocation failed or timed out:', err);
                }
            }

            try {
                const payload = { messages: chatHistory };
                if (userCoords) {
                    payload.latitude = userCoords.latitude;
                    payload.longitude = userCoords.longitude;
                }
                if (activeConversationId) {
                    payload.conversation_id = activeConversationId;
                }

                const response = await fetch('/chatbot', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });

                const data = await response.json();
                hideTypingIndicator();

                if (data.message) {
                    appendMessage('assistant', data.message);
                    chatHistory.push({ role: 'assistant', content: data.message });
                    if (data.conversation_id) {
                        activeConversationId = data.conversation_id;
                    }
                }
            } catch (error) {
                console.error('Chat error:', error);
                hideTypingIndicator();
                appendMessage('assistant', 'Oups ! Une erreur est survenue lors de la communication. Veuillez réessayer.');
            } finally {
                inputField.disabled = false;
                submitBtn.disabled = false;
                inputField.focus();
            }
        }

        // Toggle History Overlay Panel
        function toggleHistoryView() {
            if (!isAuthenticated) return;
            const panel = document.getElementById('chat-history-panel');
            panel.classList.toggle('d-none');
            if (!panel.classList.contains('d-none')) {
                loadHistoryList();
            }
        }

        // Fetch user's past conversations and render them
        async function loadHistoryList() {
            const container = document.getElementById('history-list-container');
            container.innerHTML = '<div class="text-center py-4"><div class="spinner-border spinner-border-sm text-success" role="status"></div></div>';

            try {
                const response = await fetch('/chatbot/conversations', {
                    headers: { 'Accept': 'application/json' },
                    cache: 'no-store'
                });
                const conversations = await safeJson(response);
                container.innerHTML = '';

                if (conversations.length === 0) {
                    container.innerHTML = `<div class="text-center py-4 opacity-50 small fw-bold text-main"><i class="far fa-comments fa-2x mb-2 d-block"></i>Aucune discussion enregistrée</div>`;
                    return;
                }

                conversations.forEach(conv => {
                    const activeClass = conv.id === activeConversationId ? 'border-success bg-soft-success shadow-sm' : 'border-color bg-soft';
                    const item = document.createElement('div');
                    item.className = `history-item d-flex align-items-center justify-content-between p-2 mb-2 rounded-3 border ${activeClass}`;
                    item.style.cursor = 'pointer';
                    item.style.transition = 'all 0.2s';
                    item.id = `history-item-${conv.id}`;
                    item.innerHTML = `
                        <div class="d-flex align-items-center gap-2 flex-grow-1 overflow-hidden" onclick="loadConversation(${conv.id})">
                            <i class="far fa-comments text-main flex-shrink-0"></i>
                            <span class="history-title truncate fw-semibold small text-main" id="title-text-${conv.id}">${escapeHtml(conv.title)}</span>
                            <input type="text" class="form-control form-control-sm d-none mx-1" id="title-input-${conv.id}" value="${escapeHtml(conv.title)}" onblur="saveRename(${conv.id})" onkeyup="handleRenameKey(event, ${conv.id})" onclick="event.stopPropagation()">
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <button class="btn btn-sm text-secondary p-1 border-0" onclick="startRename(${conv.id}, event)" title="Renommer"><i class="fas fa-pencil-alt fs-7"></i></button>
                            <button class="btn btn-sm text-danger p-1 border-0" onclick="deleteConversation(${conv.id}, event)" title="Supprimer"><i class="fas fa-trash-alt fs-7"></i></button>
                        </div>
                    `;
                    container.appendChild(item);
                });
            } catch (err) {
                console.error(err);
                container.innerHTML = `<div class="text-center py-4 text-danger small fw-bold">Erreur de chargement de l'historique</div>`;
            }
        }

        function escapeHtml(text) {
            return text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        // Start a completely fresh chat session
        function startNewConversation() {
            activeConversationId = null;
            chatHistory = [];

            // Clear message list to original welcome message
            const container = document.getElementById('chat-messages');
            container.innerHTML = `
                <div class="chat-message-ai">
                    👋 <strong>Bonjour !</strong> Je suis <strong>Gluto</strong>. Je peux vous aider à trouver des produits, des recettes, ou répondre à vos questions sur le mode de vie Sans Gluten. Que cherchez-vous ?
                </div>
                <div class="d-flex flex-wrap gap-2 mt-2 mb-3" id="chat-suggestions">
                    <button onclick="sendSuggestedQuestion('🛒 Chercher du pain sans gluten')" class="btn btn-sm btn-outline-secondary rounded-pill bg-white text-dark shadow-sm border-0" style="font-size: 0.85rem;">🛒 Pain sans gluten</button>
                    <button onclick="sendSuggestedQuestion('🍽️ Idée de recette dessert')" class="btn btn-sm btn-outline-secondary rounded-pill bg-white text-dark shadow-sm border-0" style="font-size: 0.85rem;">🍽️ Recette dessert</button>
                    <button onclick="sendSuggestedQuestion('📍 Magasins à Casablanca')" class="btn btn-sm btn-outline-secondary rounded-pill bg-white text-dark shadow-sm border-0" style="font-size: 0.85rem;">📍 Magasins à Casablanca</button>
                    <button onclick="sendSuggestedQuestion('🩺 C\\\'est quoi la maladie cœliaque ?')" class="btn btn-sm btn-outline-secondary rounded-pill bg-white text-dark shadow-sm border-0" style="font-size: 0.85rem;">🩺 Maladie cœliaque ?</button>
                </div>
            `;

            // Close history view
            const panel = document.getElementById('chat-history-panel');
            if (panel) panel.classList.add('d-none');
        }

        // Load conversation messages into active chat window
        async function loadConversation(id) {
            try {
                const response = await fetch(`/chatbot/conversations/${id}`, {
                    headers: { 'Accept': 'application/json' }
                });
                const conversation = await response.json();

                activeConversationId = conversation.id;
                chatHistory = conversation.messages || [];

                const container = document.getElementById('chat-messages');
                container.innerHTML = '';

                if (chatHistory.length === 0) {
                    container.innerHTML = `
                        <div class="chat-message-ai">👋 Nouvelle discussion démarrée ! Comment puis-je vous aider ?</div>
                    `;
                } else {
                    chatHistory.forEach(msg => {
                        appendMessage(msg.role, msg.content);
                    });
                }

                // Hide the suggestion chips if history loaded
                const suggestions = document.getElementById('chat-suggestions');
                if (suggestions) suggestions.style.display = 'none';

                // Close history view
                const panel = document.getElementById('chat-history-panel');
                if (panel) panel.classList.add('d-none');
            } catch (err) {
                console.error(err);
                alert("Erreur lors de la récupération des messages de cette conversation.");
            }
        }

        // Inline Rename functions
        function startRename(id, event) {
            event.stopPropagation();
            const textSpan = document.getElementById(`title-text-${id}`);
            const input = document.getElementById(`title-input-${id}`);
            // Sync input value with current displayed title before showing
            input.value = textSpan.textContent.trim();
            input.dataset.saving = 'false';
            textSpan.classList.add('d-none');
            input.classList.remove('d-none');
            input.focus();
            input.select();
        }

        function handleRenameKey(event, id) {
            if (event.key === 'Enter') {
                event.target.blur(); // let onblur → saveRename handle it (avoids double-call)
            } else if (event.key === 'Escape') {
                const input = document.getElementById(`title-input-${id}`);
                const textSpan = document.getElementById(`title-text-${id}`);
                // Restore original value and block the upcoming blur from saving
                input.value = textSpan.textContent.trim();
                input.dataset.saving = 'true';
                textSpan.classList.remove('d-none');
                input.classList.add('d-none');
                setTimeout(() => { input.dataset.saving = 'false'; }, 50);
            }
        }

        // Detect real session expiry: only when the final URL is /login
        function isSessionExpired(response) {
            try {
                if (response.url && new URL(response.url).pathname === '/login') {
                    window.location.href = '/login';
                    return true;
                }
            } catch (_) { }
            return false;
        }

        // Safe JSON parse — throws a clear error if server returned HTML instead of JSON
        async function safeJson(response) {
            const ct = response.headers.get('Content-Type') || '';
            if (!ct.includes('application/json')) {
                throw new Error(`Réponse serveur invalide (${response.status}). Vérifiez la console.`);
            }
            return response.json();
        }

        async function saveRename(id) {
            const input = document.getElementById(`title-input-${id}`);
            const textSpan = document.getElementById(`title-text-${id}`);

            // Guard: block re-entrant calls (Escape flag, or hiding input triggers blur again)
            if (input.dataset.saving === 'true') return;
            input.dataset.saving = 'true';

            const newTitle = input.value.trim();
            const oldTitle = textSpan.textContent.trim();

            // Nothing to save
            if (!newTitle || newTitle === oldTitle) {
                textSpan.classList.remove('d-none');
                input.classList.add('d-none');
                input.dataset.saving = 'false';
                return;
            }

            try {
                const response = await fetch(`/chatbot/conversations/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ title: newTitle })
                });

                if (isSessionExpired(response)) return;

                if (!response.ok) {
                    alert(`Erreur lors de la sauvegarde (${response.status}). Veuillez réessayer.`);
                    input.value = oldTitle;
                    return;
                }

                const data = await safeJson(response);
                textSpan.textContent = data.title ?? newTitle;
            } catch (err) {
                console.error('saveRename error:', err);
                alert('Erreur réseau. Veuillez réessayer.');
                input.value = oldTitle;
            } finally {
                input.dataset.saving = 'false';
                textSpan.classList.remove('d-none');
                input.classList.add('d-none');
            }
        }

        // Delete conversation
        async function deleteConversation(id, event) {
            event.stopPropagation();
            if (!confirm('Voulez-vous vraiment supprimer cette discussion ?')) return;

            const btn = event.currentTarget;
            btn.disabled = true;

            try {
                const response = await fetch(`/chatbot/conversations/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                if (isSessionExpired(response)) return;

                if (!response.ok) {
                    alert(`Erreur lors de la suppression (${response.status}). Veuillez réessayer.`);
                    return;
                }

                // Reload history from server — confirms record is actually deleted in DB
                if (id === activeConversationId) {
                    startNewConversation();
                }
                await loadHistoryList();
            } catch (err) {
                console.error('deleteConversation error:', err);
                alert('Erreur réseau lors de la suppression. Veuillez réessayer.');
            } finally {
                btn.disabled = false;
            }
        }
    </script>

</body>

</html>