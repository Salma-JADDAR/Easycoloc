<nav x-data="{ open: false }" class="header">
    <div class="header-container">
        <!-- Logo -->
        <div class="logo">
            <div class="logo-icon">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                </svg>
            </div>
            <span class="logo-text">EasyColoc</span>
        </div>

        <!-- Desktop Navigation Links -->
        <div class="hidden sm:flex sm:items-center sm:space-x-8">
            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-primary-600 transition {{ request()->routeIs('dashboard') ? 'text-primary-600' : '' }}">
                {{ __('Dashboard') }}
            </a>
        </div>

        <!-- Header Actions -->
        <div class="header-actions">
            @if(auth()->user()->role === 'admin')
                <div class="badge badge-admin" data-tooltip="Accès administrateur">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    Admin
                </div>
            @endif

            <div class="xp-badge">
                <svg class="w-4 h-4 xp-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
                <span class="xp-label">XP</span>
                <span class="xp-value">{{ number_format(auth()->user()->reputation) }}</span>
            </div>

            <!-- User Menu -->
            <div class="user-menu" x-data="{ open: false }">
                <button @click="open = !open" @click.away="open = false" class="user-menu-button" :aria-expanded="open">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="user-info">
                        <span class="user-name">{{ auth()->user()->name }}</span>
                        <span class="user-role">{{ auth()->user()->role === 'admin' ? 'Administrateur' : 'Membre' }}</span>
                    </div>
                    <svg class="dropdown-icon" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div class="dropdown-menu" :class="{ 'show': open }">
                    <div class="dropdown-header">
                        <div class="user-name">{{ auth()->user()->name }}</div>
                        <div class="user-email">{{ auth()->user()->email }}</div>
                    </div>

                    <div class="dropdown-items">
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span>Mon Profil</span>
                        </a>

                        <a href="#" class="dropdown-item">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>Paramètres</span>
                        </a>

                        <div class="dropdown-divider"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item logout">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                <span>Déconnexion</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hamburger (Mobile) -->
        <div class="flex items-center sm:hidden">
            <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-base font-medium text-gray-700 hover:text-primary-600 hover:bg-gray-50 {{ request()->routeIs('dashboard') ? 'text-primary-600 bg-gray-50' : '' }}">
                {{ __('Dashboard') }}
            </a>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                <div class="mt-2 flex items-center gap-2">
                    <div class="xp-badge">
                        <svg class="w-4 h-4 xp-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                        <span class="xp-label">XP</span>
                        <span class="xp-value">{{ number_format(auth()->user()->reputation) }}</span>
                    </div>
                    @if(auth()->user()->role === 'admin')
                        <div class="badge badge-admin text-xs">
                            Admin
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-base font-medium text-gray-700 hover:text-primary-600 hover:bg-gray-50">
                    {{ __('Profile') }}
                </a>

                <a href="#" class="block px-4 py-2 text-base font-medium text-gray-700 hover:text-primary-600 hover:bg-gray-50">
                    {{ __('Paramètres') }}
                </a>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-base font-medium text-red-600 hover:text-red-700 hover:bg-red-50">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<style>
:root {
    --primary-50: #f0fdf4;
    --primary-100: #dcfce7;
    --primary-200: #bbf7d0;
    --primary-300: #86efac;
    --primary-400: #4ade80;
    --primary-500: #22c55e;
    --primary-600: #16a34a;
    --primary-700: #15803d;
    --primary-800: #166534;
    --primary-900: #14532d;
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
}

.header {
    position: sticky;
    top: 0;
    z-index: 50;
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-bottom: 1px solid rgba(229, 231, 235, 0.5);
    padding: 1rem 2rem;
}

.header-container {
    max-width: 1400px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.logo {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.logo-icon {
    width: 2.5rem;
    height: 2.5rem;
    background: linear-gradient(135deg, var(--primary-600), var(--primary-500));
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    box-shadow: 0 4px 10px rgba(22, 163, 74, 0.3);
}

.logo-text {
    font-size: 1.5rem;
    font-weight: 700;
    background: linear-gradient(135deg, var(--primary-800), var(--primary-600));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.header-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.badge {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    border-radius: 100px;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.025em;
    transition: all 0.2s;
}

.badge-admin {
    background: linear-gradient(135deg, var(--primary-700), var(--primary-600));
    color: white;
    box-shadow: 0 2px 8px rgba(22, 163, 74, 0.3);
    position: relative;
    overflow: hidden;
}

.badge-admin::before {
    content: "";
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    transform: rotate(45deg);
    animation: shimmer 3s infinite;
}

@keyframes shimmer {
    0% { transform: translateX(-100%) rotate(45deg); }
    100% { transform: translateX(100%) rotate(45deg); }
}

.xp-badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: white;
    padding: 0.5rem 1rem;
    border-radius: 100px;
    border: 1px solid var(--gray-200);
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    transition: all 0.2s;
    cursor: default;
}

.xp-badge:hover {
    border-color: var(--primary-300);
    box-shadow: 0 4px 12px rgba(34, 197, 94, 0.15);
    transform: translateY(-1px);
}

.xp-icon {
    color: var(--primary-500);
}

.xp-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--gray-500);
    letter-spacing: 0.025em;
    margin-right: 0.25rem;
}

.xp-value {
    font-size: 0.875rem;
    font-weight: 700;
    color: var(--primary-700);
    background: linear-gradient(135deg, var(--primary-600), var(--primary-500));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.user-menu {
    position: relative;
}

.user-menu-button {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.5rem 1rem;
    background: white;
    border: 1px solid var(--gray-200);
    border-radius: 100px;
    cursor: pointer;
    transition: all 0.2s;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

.user-menu-button:hover {
    border-color: var(--primary-300);
    box-shadow: 0 4px 12px rgba(34, 197, 94, 0.15);
}

.user-avatar {
    width: 2rem;
    height: 2rem;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-600), var(--primary-500));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 0.875rem;
}

.user-info {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.user-name {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--gray-900);
}

.user-role {
    font-size: 0.75rem;
    color: var(--gray-500);
}

.dropdown-icon {
    width: 1rem;
    height: 1rem;
    color: var(--gray-400);
    transition: transform 0.2s;
}

.rotate-180 {
    transform: rotate(180deg);
}

.dropdown-menu {
    position: absolute;
    top: calc(100% + 0.5rem);
    right: 0;
    width: 240px;
    background: white;
    border: 1px solid var(--gray-200);
    border-radius: 12px;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.2s;
    z-index: 100;
}

.dropdown-menu.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-header {
    padding: 1rem;
    border-bottom: 1px solid var(--gray-100);
}

.dropdown-header .user-name {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--gray-900);
}

.dropdown-header .user-email {
    font-size: 0.75rem;
    color: var(--gray-500);
    margin-top: 0.25rem;
}

.dropdown-items {
    padding: 0.5rem;
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    color: var(--gray-700);
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s;
    cursor: pointer;
    text-decoration: none;
    width: 100%;
    border: none;
    background: none;
}

.dropdown-item:hover {
    background: var(--gray-50);
    color: var(--primary-700);
}

.dropdown-item:hover svg {
    color: var(--primary-600);
}

.dropdown-item svg {
    width: 1.25rem;
    height: 1.25rem;
    color: var(--gray-400);
    transition: color 0.2s;
}

.dropdown-divider {
    height: 1px;
    background: var(--gray-200);
    margin: 0.5rem 0;
}

.dropdown-item.logout {
    color: #dc2626;
}

.dropdown-item.logout:hover {
    background: #fef2f2;
}

.dropdown-item.logout:hover svg {
    color: #dc2626;
}

[data-tooltip] {
    position: relative;
    cursor: help;
}

[data-tooltip]:before {
    content: attr(data-tooltip);
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    padding: 0.5rem 1rem;
    background: var(--gray-900);
    color: white;
    font-size: 0.75rem;
    border-radius: 6px;
    white-space: nowrap;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.2s;
    z-index: 100;
}

[data-tooltip]:hover:before {
    opacity: 1;
}

@media (max-width: 768px) {
    .header {
        padding: 1rem;
    }
    
    .user-info {
        display: none;
    }
    
    .badge-admin .mr-1 {
        margin-right: 0;
    }
    
    .badge-admin svg {
        margin-right: 0;
    }
}
@media (max-width: 640px) {
    .xp-badge {
        display: none;
    }
}
</style>