<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="EasyColoc - La solution complète pour gérer votre colocation en toute simplicité">
    <title>{{ config('app.name', 'EasyColoc') }} - Simplifiez votre colocation</title>
    
  
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=cormorant-garamond:300,500|dm-sans:300,400,500&display=swap" rel="stylesheet" />
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,500;1,300&family=DM+Sans:wght@300;400;500&display=swap');

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

       
        .blob {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            z-index: -1;
            animation: move 20s infinite alternate;
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

        @keyframes move {
            from { transform: translate(0, 0) scale(1); }
            to { transform: translate(50px, 100px) scale(1.1); }
        }

      
        .header {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(6, 78, 59, 0.1);
            padding: 1rem 2rem;
            transition: all 0.3s;
        }

        .header.scrolled {
            padding: 0.75rem 2rem;
            box-shadow: var(--shadow-lg);
        }

        .header-container {
            max-width: 1280px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            position: relative;
        }

        .logo-icon {
            width: 2.5rem;
            height: 2.5rem;
            background: var(--primary-green);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 10px 20px rgba(6, 78, 59, 0.15);
            transition: transform 0.3s;
        }

        .logo:hover .logo-icon {
            transform: scale(1.05) rotate(5deg);
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

      
        .nav-desktop {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        @media (max-width: 768px) {
            .nav-desktop {
                display: none;
            }
        }

        .nav-link {
            color: var(--gray-600);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 400;
            transition: color 0.2s;
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent-green);
            transition: width 0.3s;
            border-radius: 2px;
        }

        .nav-link:hover {
            color: var(--primary-green);
        }

        .nav-link:hover::after {
            width: 100%;
        }

       
        .btn-login {
            padding: 0.5rem 1.25rem;
            color: var(--gray-700);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            border-radius: 12px;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .btn-login:hover {
            color: var(--primary-green);
            background: var(--glow-green);
            transform: translateY(-1px);
        }

        .btn-register {
            padding: 0.5rem 1.25rem;
            background: var(--primary-green);
            color: white;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(6, 78, 59, 0.15);
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .btn-register:hover {
            background: #08634c;
            transform: translateY(-2px);
            box-shadow: 0 15px 25px rgba(6, 78, 59, 0.2);
        }

    
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
        }

        @media (max-width: 768px) {
            .mobile-menu-btn {
                display: block;
            }
        }

        .hamburger {
            width: 24px;
            height: 20px;
            position: relative;
        }

        .hamburger span {
            position: absolute;
            width: 100%;
            height: 2px;
            background: var(--primary-green);
            border-radius: 2px;
            transition: all 0.3s;
        }

        .hamburger span:nth-child(1) { top: 0; }
        .hamburger span:nth-child(2) { top: 9px; }
        .hamburger span:nth-child(3) { top: 18px; }

        .hamburger.active span:nth-child(1) {
            transform: rotate(45deg);
            top: 9px;
        }

        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active span:nth-child(3) {
            transform: rotate(-45deg);
            top: 9px;
        }

      
        .mobile-menu {
            position: fixed;
            top: 0;
            right: -100%;
            width: 300px;
            height: 100vh;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-left: 1px solid rgba(6, 78, 59, 0.1);
            padding: 5rem 2rem 2rem;
            transition: right 0.3s;
            z-index: 40;
        }

        .mobile-menu.active {
            right: 0;
        }

        .mobile-menu-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(6, 78, 59, 0.2);
            backdrop-filter: blur(4px);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
            z-index: 39;
        }

        .mobile-menu-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .mobile-nav-link {
            display: block;
            padding: 1rem 0;
            color: var(--gray-700);
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 400;
            border-bottom: 1px solid rgba(6, 78, 59, 0.1);
            transition: color 0.2s;
        }

        .mobile-nav-link:hover {
            color: var(--accent-green);
        }

        .mobile-buttons {
            margin-top: 2rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .mobile-btn {
            padding: 1rem;
            text-align: center;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.85rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            transition: all 0.2s;
        }

        .mobile-btn-login {
            background: var(--gray-100);
            color: var(--primary-green);
        }

        .mobile-btn-register {
            background: var(--primary-green);
            color: white;
            box-shadow: 0 10px 20px rgba(6, 78, 59, 0.15);
        }

        .mobile-btn-register:hover {
            background: #08634c;
            transform: translateY(-2px);
            box-shadow: 0 15px 25px rgba(6, 78, 59, 0.2);
        }

   
        .main {
            max-width: 1280px;
            margin: 0 auto;
            padding: 4rem 2rem;
        }

   
        .hero {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            margin-bottom: 8rem;
            position: relative;
        }

        @media (max-width: 768px) {
            .hero {
                grid-template-columns: 1fr;
                gap: 3rem;
            }
        }

        .hero-content {
            animation: slideInLeft 0.8s ease;
        }

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .hero-content h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 3.5rem;
            font-weight: 300;
            line-height: 1.1;
            color: var(--primary-green);
            margin-bottom: 1.5rem;
        }

        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2.5rem;
            }
        }

        .hero-gradient {
            color: var(--accent-green);
            font-style: italic;
        }

        .hero-description {
            font-size: 1rem;
            color: var(--gray-600);
            margin-bottom: 2rem;
            line-height: 1.8;
            font-weight: 300;
            animation: fadeUp 0.8s ease 0.1s both;
        }

        .hero-stats {
            display: flex;
            gap: 2rem;
            margin-bottom: 2.5rem;
            animation: fadeUp 0.8s ease 0.2s both;
        }

        .hero-stat {
            display: flex;
            flex-direction: column;
        }

        .hero-stat-number {
            font-size: 1.5rem;
            font-weight: 500;
            color: var(--primary-green);
        }

        .hero-stat-label {
            font-size: 0.75rem;
            color: var(--gray-500);
            font-weight: 300;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            animation: fadeUp 0.8s ease 0.3s both;
        }

        .btn-primary {
            padding: 0.875rem 2rem;
            background: var(--primary-green);
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(6, 78, 59, 0.15);
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .btn-primary:hover {
            background: #08634c;
            transform: translateY(-2px);
            box-shadow: 0 15px 25px rgba(6, 78, 59, 0.2);
        }

        .btn-secondary {
            padding: 0.875rem 2rem;
            background: white;
            color: var(--primary-green);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            border-radius: 12px;
            border: 1px solid rgba(6, 78, 59, 0.2);
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-secondary:hover {
            border-color: var(--accent-green);
            background: var(--gray-50);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.1);
        }

    
        .hero-image {
            position: relative;
            animation: slideInRight 0.8s ease;
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .hero-image-wrapper {
            position: relative;
            width: 100%;
            height: 450px;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(6, 78, 59, 0.05);
        }

        .hero-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .hero-image-wrapper:hover img {
            transform: scale(1.05);
        }

        .hero-image-wrapper::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(6, 78, 59, 0.1) 0%, transparent 50%);
            pointer-events: none;
        }

        .floating-card {
            position: absolute;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 1rem 1.5rem;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(6, 78, 59, 0.1);
            display: flex;
            align-items: center;
            gap: 1rem;
            animation: floatCard 3s ease-in-out infinite;
            border: 1px solid rgba(6, 78, 59, 0.1);
        }

        @keyframes floatCard {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .floating-card-1 {
            top: 15%;
            left: -20px;
            animation-delay: 0s;
        }

        .floating-card-2 {
            bottom: 15%;
            right: -20px;
            animation-delay: 1.5s;
        }

        @media (max-width: 768px) {
            .floating-card-1 {
                left: 10px;
            }
            .floating-card-2 {
                right: 10px;
            }
            .floating-card {
                padding: 0.75rem 1rem;
            }
        }

        .card-icon {
            width: 2.5rem;
            height: 2.5rem;
            background: var(--glow-green);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-green);
        }

        .card-content h4 {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--primary-green);
        }

        .card-content p {
            font-size: 0.75rem;
            color: var(--gray-500);
            font-weight: 300;
        }

        /* Trusted By Section */
        .trusted-by {
            text-align: center;
            margin-bottom: 6rem;
            animation: fadeUp 0.8s ease 0.4s both;
        }

        .trusted-by p {
            color: var(--gray-500);
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            margin-bottom: 2rem;
            opacity: 0.7;
        }

        .trusted-logos {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 4rem;
            flex-wrap: wrap;
            opacity: 0.5;
        }

        .trusted-logos span {
            font-size: 1rem;
            font-weight: 300;
            color: var(--primary-green);
            letter-spacing: 0.1em;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-subtitle {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: var(--glow-green);
            color: var(--primary-green);
            border-radius: 9999px;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            margin-bottom: 1rem;
        }

        .section-header h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.5rem;
            font-weight: 300;
            color: var(--primary-green);
            margin-bottom: 1rem;
        }

        .section-header p {
            color: var(--gray-500);
            font-size: 1rem;
            font-weight: 300;
            max-width: 600px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-bottom: 6rem;
        }

        @media (max-width: 768px) {
            .features-grid {
                grid-template-columns: 1fr;
            }
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(6, 78, 59, 0.1);
            border-radius: 24px;
            padding: 2rem;
            transition: all 0.3s;
            box-shadow: 0 20px 40px rgba(6, 78, 59, 0.05);
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--accent-green), var(--primary-green));
            transform: translateX(-100%);
            transition: transform 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            border-color: var(--accent-green);
            box-shadow: 0 30px 50px rgba(6, 78, 59, 0.1);
        }

        .feature-card:hover::before {
            transform: translateX(0);
        }

        .feature-icon {
            width: 3.5rem;
            height: 3.5rem;
            background: var(--glow-green);
            color: var(--accent-green);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            transition: all 0.3s;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
            background: var(--accent-green);
            color: white;
        }

        .feature-icon svg {
            width: 1.75rem;
            height: 1.75rem;
        }

        .feature-card h3 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem;
            font-weight: 300;
            color: var(--primary-green);
            margin-bottom: 0.75rem;
        }

        .feature-card p {
            color: var(--gray-600);
            line-height: 1.6;
            margin-bottom: 1.5rem;
            font-weight: 300;
        }

        .feature-link {
            color: var(--accent-green);
            text-decoration: none;
            font-weight: 400;
            font-size: 0.85rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: gap 0.2s;
        }

        .feature-link:hover {
            gap: 0.75rem;
            color: var(--primary-green);
        }

      
        .how-it-works {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-bottom: 6rem;
        }

        @media (max-width: 768px) {
            .how-it-works {
                grid-template-columns: 1fr;
            }
        }

        .step-card {
            text-align: center;
            position: relative;
        }

        .step-number {
            width: 3rem;
            height: 3rem;
            background: var(--primary-green);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: 500;
            margin: 0 auto 1.5rem;
            box-shadow: 0 10px 20px rgba(6, 78, 59, 0.15);
        }

        .step-card h3 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem;
            font-weight: 300;
            color: var(--primary-green);
            margin-bottom: 0.75rem;
        }

        .step-card p {
            color: var(--gray-500);
            line-height: 1.6;
            font-weight: 300;
        }

    
        .stats-section {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(6, 78, 59, 0.1);
            border-radius: 40px;
            padding: 4rem;
            margin-bottom: 6rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(6, 78, 59, 0.05);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        .stat-item {
            padding: 2rem;
        }

        .stat-item h3 {
            font-size: 3rem;
            font-weight: 300;
            font-family: 'Cormorant Garamond', serif;
            color: var(--primary-green);
            margin-bottom: 0.5rem;
        }

        .stat-item p {
            color: var(--gray-500);
            font-size: 1rem;
            font-weight: 300;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        
        
        /* Scroll Reveal */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <!-- Header -->
    <header class="header" id="header">
        <div class="header-container">
            <a href="/" class="logo">
                <div class="logo-icon">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                    </svg>
                </div>
                <span class="logo-text">Easy<i>Coloc</i></span>
            </a>

           

            <!-- Desktop Buttons - Login et Inscription uniquement -->
            <div class="nav-desktop">
                <a href="{{ route('login') }}" class="btn-login">SE CONNECTER</a>
                <a href="{{ route('register') }}" class="btn-register">S'INSCRIRE</a>
            </div>

            <!-- Mobile Menu Button -->
            <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
                <div class="hamburger" id="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>
        </div>
    </header>

    <!-- Mobile Menu -->
    <div class="mobile-menu-overlay" id="mobileMenuOverlay" onclick="closeMobileMenu()"></div>
    <div class="mobile-menu" id="mobileMenu">
        <a href="#features" class="mobile-nav-link" onclick="closeMobileMenu()">Fonctionnalités</a>
        <a href="#how-it-works" class="mobile-nav-link" onclick="closeMobileMenu()">Comment ça marche</a>
        <a href="#testimonials" class="mobile-nav-link" onclick="closeMobileMenu()">Témoignages</a>
        
        <div class="mobile-buttons">
            <a href="{{ route('login') }}" class="mobile-btn mobile-btn-login" onclick="closeMobileMenu()">
                SE CONNECTER
            </a>
            <a href="{{ route('register') }}" class="mobile-btn mobile-btn-register" onclick="closeMobileMenu()">
                S'INSCRIRE
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <main class="main">
        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-content">
                <h1>
                    Vivez la colocation<br>
                    <span class="hero-gradient">sans stress</span>
                </h1>
                <p class="hero-description">
                    EasyColoc vous aide à gérer votre colocation en toute sérénité. 
                    Dépenses partagées, tâches ménagères, calendrier commun... 
                    Tout ce dont vous avez besoin dans une seule application.
                </p>

                <div class="hero-stats">
                    <div class="hero-stat">
                        <span class="hero-stat-number">10k+</span>
                        <span class="hero-stat-label">UTILISATEURS</span>
                    </div>
                    <div class="hero-stat">
                        <span class="hero-stat-number">5k+</span>
                        <span class="hero-stat-label">COLOCATIONS</span>
                    </div>
                    <div class="hero-stat">
                        <span class="hero-stat-number">98%</span>
                        <span class="hero-stat-label">SATISFAITS</span>
                    </div>
                </div>

                <div class="hero-buttons">
                    <a href="{{ route('register') }}" class="btn-primary">
                        COMMENCER GRATUITEMENT
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    <a href="#features" class="btn-secondary">
                        EN SAVOIR PLUS
                    </a>
                </div>
            </div>

            <div class="hero-image">
                <div class="hero-image-wrapper">
                    <img 
                        src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2340&q=80" 
                        alt="Colocation - Appartement moderne avec des colocataires"
                    />
                    
                    <div class="floating-card floating-card-1">
                        <div class="card-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="card-content">
                            <h4>Dépenses partagées</h4>
                            <p>234€ économisés</p>
                        </div>
                    </div>

                    <div class="floating-card floating-card-2">
                        <div class="card-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <div class="card-content">
                            <h4>Tâches organisées</h4>
                            <p>15 tâches ce mois</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        
    <script>
        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.getElementById('header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Mobile menu
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
            const hamburger = document.getElementById('hamburger');
            
            mobileMenu.classList.toggle('active');
            mobileMenuOverlay.classList.toggle('active');
            hamburger.classList.toggle('active');
        }

        function closeMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
            const hamburger = document.getElementById('hamburger');
            
            mobileMenu.classList.remove('active');
            mobileMenuOverlay.classList.remove('active');
            hamburger.classList.remove('active');
        }

        // Scroll reveal animation
        function reveal() {
            const reveals = document.querySelectorAll('.reveal');
            
            reveals.forEach((element) => {
                const windowHeight = window.innerHeight;
                const elementTop = element.getBoundingClientRect().top;
                const elementVisible = 150;
                
                if (elementTop < windowHeight - elementVisible) {
                    element.classList.add('active');
                }
            });
        }

        window.addEventListener('scroll', reveal);
        window.addEventListener('load', reveal);

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    closeMobileMenu();
                }
            });
        });
    </script>
</body>
</html>