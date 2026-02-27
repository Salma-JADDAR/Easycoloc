<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'EasyColoc'))</title>
    
    <!-- Fonts - Même style que welcome -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=cormorant-garamond:300,500|dm-sans:300,400,500&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* ===== VARIABLES ===== */
        :root {
            --primary-green: #064e3b;
            --accent-green: #10b981;
            --bg-light: #f9fafb;
            --glow-green: rgba(16, 185, 129, 0.15);
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            --shadow-2xl: 0 25px 50px -12px rgb(0 0 0 / 0.25);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg-light);
            background-image: 
                radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(6, 78, 59, 0.05) 0px, transparent 50%);
            min-height: 100vh;
            overflow-x: hidden;
            color: var(--primary-green);
        }

        /* ===== BLOBS ANIMÉS (comme welcome) ===== */
        .blob {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            z-index: 0;
            animation: move 20s infinite alternate;
            pointer-events: none;
        }
        .blob-1 { 
            width: 500px; 
            height: 500px; 
            background: var(--glow-green); 
            top: -10%; 
            right: -5%; 
        }
        .blob-2 { 
            width: 400px; 
            height: 400px; 
            background: rgba(6, 78, 59, 0.05); 
            bottom: -10%; 
            left: -5%; 
            animation-delay: -5s; 
        }
        .blob-3 {
            width: 300px;
            height: 300px;
            background: rgba(16, 185, 129, 0.08);
            top: 40%;
            left: 60%;
            animation-delay: -10s;
        }

        @keyframes move {
            from { transform: translate(0, 0) scale(1); }
            to { transform: translate(50px, 100px) scale(1.1); }
        }

        /* ===== LAYOUT PRINCIPAL ===== */
        .app-layout {
            display: flex;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }

        /* ===== PANEL LATÉRAL ===== */
        .sidebar {
            width: 280px;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-right: 1px solid rgba(6, 78, 59, 0.1);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 50;
            box-shadow: var(--shadow-xl);
            animation: slideInLeft 0.5s ease;
        }

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        /* Logo */
        .sidebar-logo {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(6, 78, 59, 0.1);
        }

        .logo-link {
            display: flex;
            align-items: center;
            gap: 1rem;
            text-decoration: none;
            transition: transform 0.3s;
        }

        .logo-link:hover {
            transform: scale(1.02);
        }

        .logo-icon {
            width: 3rem;
            height: 3rem;
            background: linear-gradient(135deg, var(--primary-green), var(--accent-green));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: var(--shadow-lg);
        }

        .logo-icon svg {
            width: 1.5rem;
            height: 1.5rem;
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: 500;
            font-family: 'Cormorant Garamond', serif;
            color: var(--primary-green);
        }

        .logo-text i {
            color: var(--accent-green);
            font-style: italic;
        }

        /* Navigation */
        .sidebar-nav {
            flex: 1;
            padding: 2rem 1rem;
            overflow-y: auto;
        }

        .nav-section {
            margin-bottom: 2rem;
        }

        .nav-section-title {
            padding: 0 1rem;
            margin-bottom: 1rem;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--gray-400);
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.875rem 1rem;
            margin-bottom: 0.5rem;
            border-radius: 12px;
            color: var(--gray-700);
            text-decoration: none;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .nav-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, var(--glow-green), transparent);
            opacity: 0;
            transition: opacity 0.3s;
            z-index: -1;
        }

        .nav-item:hover {
            color: var(--primary-green);
            transform: translateX(5px);
        }

        .nav-item:hover::before {
            opacity: 1;
        }

        .nav-item.active {
            background: var(--glow-green);
            color: var(--primary-green);
            box-shadow: var(--shadow-md);
        }

        .nav-item.active .nav-icon {
            color: var(--accent-green);
        }

        .nav-icon {
            width: 1.5rem;
            height: 1.5rem;
            color: var(--gray-500);
            transition: color 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-item:hover .nav-icon {
            color: var(--accent-green);
        }

        .nav-text {
            flex: 1;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .nav-badge {
            padding: 0.25rem 0.5rem;
            background: var(--glow-green);
            color: var(--primary-green);
            font-size: 0.6rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            border-radius: 100px;
            text-transform: uppercase;
        }

        /* Admin section */
        .admin-section {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(6, 78, 59, 0.1);
        }

        .admin-item {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), transparent);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .admin-item .nav-icon {
            color: var(--accent-green);
        }

        .admin-badge {
            background: var(--primary-green);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 100px;
            font-size: 0.6rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* User info */
        .sidebar-user {
            padding: 1.5rem;
            border-top: 1px solid rgba(6, 78, 59, 0.1);
            background: rgba(255, 255, 255, 0.5);
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .user-avatar {
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-green), var(--accent-green));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.2rem;
            box-shadow: var(--shadow-md);
        }

        .user-info {
            flex: 1;
            min-width: 0;
        }

        .user-name {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--primary-green);
            margin-bottom: 0.25rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-email {
            font-size: 0.7rem;
            color: var(--gray-500);
            font-weight: 300;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Badges */
        .user-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.25rem 0.5rem;
            border-radius: 100px;
            font-size: 0.6rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .badge-admin {
            background: linear-gradient(135deg, var(--primary-green), var(--accent-green));
            color: white;
        }

        .badge-xp {
            background: var(--glow-green);
            color: var(--primary-green);
        }

        .badge-banned {
            background: #fee2e2;
            color: #b91c1c;
        }

        /* Logout button */
        .logout-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem;
            background: none;
            border: 1px solid #fee2e2;
            border-radius: 12px;
            color: #b91c1c;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
        }

        .logout-btn:hover {
            background: #fee2e2;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* ===== CONTENU PRINCIPAL ===== */
        .main-content {
            flex: 1;
            margin-left: 280px;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }

        /* Messages */
        .alert {
            margin: 1.5rem;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 1rem;
            animation: slideDown 0.3s ease;
        }

        .alert-success {
            background: linear-gradient(135deg, var(--glow-green), rgba(16, 185, 129, 0.1));
            border: 1px solid var(--accent-green);
            color: var(--primary-green);
        }

        .alert-error {
            background: linear-gradient(135deg, #fee2e2, #fff);
            border: 1px solid #fecaca;
            color: #b91c1c;
        }

        .alert-icon {
            width: 1.5rem;
            height: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Page content */
        .page-content {
            padding: 2rem;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-menu-toggle {
                display: block;
                position: fixed;
                top: 1rem;
                left: 1rem;
                z-index: 60;
                width: 3rem;
                height: 3rem;
                background: white;
                border: 1px solid var(--gray-200);
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                box-shadow: var(--shadow-lg);
            }
        }

        /* Scrollbar personnalisée */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--gray-100);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--accent-green);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-green);
        }
    </style>
</head>
<body>
    <!-- Blobs d'arrière-plan (comme welcome) -->
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>

    <!-- Mobile Menu Toggle (caché sur desktop) -->
    <div class="mobile-menu-toggle" onclick="toggleSidebar()" style="display: none;">
        <i class="fas fa-bars"></i>
    </div>

    <div class="app-layout">
        <!-- Panel Latéral -->
        <div class="sidebar" id="sidebar">
            <!-- Logo -->
            <div class="sidebar-logo">
                <a href="{{ route('dashboard') }}" class="logo-link">
                    <div class="logo-icon">
                        <svg fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                    </div>
                    <span class="logo-text">Easy<i>Coloc</i></span>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="sidebar-nav">
                <div class="nav-section">
                    <div class="nav-section-title">Menu principal</div>
                    
                    <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <span class="nav-icon"><i class="fas fa-home"></i></span>
                        <span class="nav-text">Dashboard</span>
                    </a>

                    <a href="{{ route('colocations.index') }}" class="nav-item {{ request()->routeIs('colocations.*') ? 'active' : '' }}">
                        <span class="nav-icon"><i class="fas fa-building"></i></span>
                        <span class="nav-text">Colocations</span>
                    </a>

                    <a href="{{ route('profile.edit') }}" class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                        <span class="nav-icon"><i class="fas fa-user"></i></span>
                        <span class="nav-text">Profil</span>
                    </a>
                </div>

                <!-- Section Admin (visible uniquement pour les admins) -->
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <div class="admin-section">
                        <div class="nav-section-title">Administration</div>
                        
                        <a href="{{ route('admin.dashboard') }}" class="nav-item admin-item {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                            <span class="nav-icon"><i class="fas fa-crown"></i></span>
                            <span class="nav-text">Panneau admin</span>
                            <span class="admin-badge">Admin</span>
                        </a>
                    </div>
                @endif
            </nav>

            <!-- User Info -->
            <div class="sidebar-user">
                <div class="user-card">
                    <div class="user-avatar">
                        @if(auth()->check())
    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
@else
    <i class="fas fa-user"></i>
@endif
                    </div>
                    <div class="user-info">
                        <div class="user-name">{{ auth()->user()->name }}</div>
                        <div class="user-email">{{ auth()->user()->email }}</div>
                    </div>
                </div>

                <!-- Badges -->
                <div class="user-badges">
                    @if(auth()->user()->role === 'admin')
                        <span class="badge badge-admin">
                            <i class="fas fa-crown"></i> Admin
                        </span>
                    @endif
                    
                    <span class="badge badge-xp">
                        <i class="fas fa-star"></i> {{ auth()->user()->reputation }} XP
                    </span>

                    @if(auth()->user()->estBanni())
                        <span class="badge badge-banned">
                            <i class="fas fa-ban"></i> Banni
                        </span>
                    @endif
                </div>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Déconnexion</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="main-content">
            <!-- Messages -->
            @if(session('success'))
                <div class="alert alert-success">
                    <div class="alert-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    <div class="alert-icon">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Page Content -->
            <div class="page-content">
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        // Mobile sidebar toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('open');
        }

        // Fermer la sidebar en cliquant en dehors (mobile)
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.mobile-menu-toggle');
            
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(event.target) && !toggle.contains(event.target)) {
                    sidebar.classList.remove('open');
                }
            }
        });

        // Afficher le toggle sur mobile
        if (window.innerWidth <= 768) {
            document.querySelector('.mobile-menu-toggle').style.display = 'flex';
        }

        // Gérer le redimensionnement
        window.addEventListener('resize', function() {
            const toggle = document.querySelector('.mobile-menu-toggle');
            if (window.innerWidth <= 768) {
                toggle.style.display = 'flex';
            } else {
                toggle.style.display = 'none';
                document.getElementById('sidebar').classList.remove('open');
            }
        });

        
        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-20px)';
                setTimeout(() => alert.remove(), 300);
            }, 5000);
        });
    </script>
</body>
</html>