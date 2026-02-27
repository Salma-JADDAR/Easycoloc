<x-guest-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,500;1,300&family=DM+Sans:wght@300;400;500&display=swap');

        :root {
            --primary-green: #064e3b;
            --accent-green: #10b981;
            --bg-light: #f9fafb;
            --glow-green: rgba(16, 185, 129, 0.15);
        }

        .register-wrapper {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg-light); 
            background-image: 
                radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(6, 78, 59, 0.05) 0px, transparent 50%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 20px 20px;
            overflow: hidden;
            color: var(--primary-green);
        }

        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: 0;
            animation: move 20s infinite alternate;
        }
        .blob-1 { width: 500px; height: 500px; background: var(--glow-green); top: -10%; right: -5%; }
        .blob-2 { width: 400px; height: 400px; background: rgba(6, 78, 59, 0.05); bottom: -10%; left: -5%; animation-delay: -5s; }

        @keyframes move {
            from { transform: translate(0, 0) scale(1); }
            to { transform: translate(50px, 100px) scale(1.1); }
        }

        .register-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(6, 78, 59, 0.1);
            border-radius: 24px;
            padding: 50px;
            width: 100%;
            max-width: 600px; 
            position: relative;
            z-index: 1;
            box-shadow: 0 20px 40px rgba(6, 78, 59, 0.05);
            animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .brand-logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-box {
            display: inline-block;
            background: var(--primary-green);
            color: white;
            padding: 8px 20px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.2rem;
            box-shadow: 0 10px 20px rgba(6, 78, 59, 0.2);
        }

        .register-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.5rem;
            font-weight: 300;
            color: var(--primary-green);
            margin-bottom: 8px;
            line-height: 1;
        }

        .register-title i { color: var(--accent-green); }

        .field-group { margin-bottom: 20px; }

        .field-label {
            display: block;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--primary-green);
            opacity: 0.7;
            margin-bottom: 8px;
        }

        .field-input {
            width: 100%;
            background: #ffffff;
            border: 1px solid rgba(6, 78, 59, 0.15);
            border-radius: 12px;
            padding: 12px 16px;
            color: var(--primary-green);
            font-size: 0.95rem;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .field-input:focus {
            outline: none;
            border-color: var(--accent-green);
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.1);
        }

        .security-note {
            background: rgba(16, 185, 129, 0.05);
            border: 1px solid rgba(16, 185, 129, 0.1);
            padding: 12px;
            border-radius: 10px;
            font-size: 0.75rem;
            color: var(--primary-green);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .submit-btn {
            width: 100%;
            padding: 16px;
            background: var(--primary-green);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-weight: 600;
            font-size: 0.85rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(6, 78, 59, 0.15);
        }

        .submit-btn:hover {
            background: #08634c;
            transform: translateY(-2px);
        }

        .footer-link {
            text-align: center;
            margin-top: 25px;
            font-size: 0.85rem;
            color: #6b7280;
        }

        .footer-link a {
            color: var(--accent-green);
            font-weight: 600;
            text-decoration: none;
        }

        .error-text { color: #dc2626; font-size: 0.75rem; margin-top: 5px; }
    </style>

    <div class="register-wrapper">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>

        <div class="register-card">
            <div class="brand-logo">
                <div class="logo-box">EasyColoc</div>
            </div>

            <h1 class="register-title">Create<i> account.</i></h1>
            <p style="color: #6b7280; font-size: 0.9rem; margin-bottom: 35px;">Join our community today.</p>

            <form method="POST" action="{{ route('register.store') }}">
                @csrf

                <div class="field-group">
                    <label class="field-label">Full Name</label>
                    <input class="field-input" type="text" name="name" value="{{ old('name') }}" placeholder="John Doe" required autofocus />
                    @error('name') <p class="error-text">{{ $message }}</p> @enderror
                </div>

                <div class="field-group">
                    <label class="field-label">Email Address</label>
                    <input class="field-input" type="email" name="email" value="{{ old('email') }}" placeholder="john@example.com" required />
                    @error('email') <p class="error-text">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="field-group">
                        <label class="field-label">Password</label>
                        <input class="field-input" type="password" name="password" placeholder="********" required />
                        @error('password') <p class="error-text">{{ $message }}</p> @enderror
                    </div>

                    <div class="field-group">
                        <label class="field-label">Confirm Key</label>
                        <input class="field-input" type="password" name="password_confirmation" placeholder="********" required />
                    </div>
                </div>

                <div class="security-note">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Use 8+ characters for a secure access.
                </div>

                <button type="submit" class="submit-btn">
                    Create Account
                </button>

                <div class="footer-link">
                    Already a member? <a href="{{ route('login') }}">Sign In</a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>