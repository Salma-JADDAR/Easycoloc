<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,500;1,300&family=DM+Sans:wght@300;400;500&display=swap');

        :root {
            
            --primary-green: #064e3b; 
            --accent-green: #10b981;  
            --bg-light: #f9fafb;
            --glow-green: rgba(16, 185, 129, 0.15);
        }

        .login-wrapper {
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

        .login-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(6, 78, 59, 0.1);
            border-radius: 24px;
            padding: 60px 50px;
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 1;
            box-shadow: 0 20px 40px rgba(6, 78, 59, 0.05);
            animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.8rem;
            font-weight: 300;
            color: var(--primary-green);
            margin-bottom: 8px;
            line-height: 1;
        }

        .login-title i { color: var(--accent-green); }

        .login-subtitle {
            color: #6b7280;
            font-size: 0.9rem;
            margin-bottom: 45px;
            font-weight: 400;
        }

        .field-group { margin-bottom: 24px; }

        .field-label {
            display: block;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--primary-green);
            opacity: 0.7;
            margin-bottom: 10px;
        }

        .field-input {
            width: 100%;
            background: #ffffff;
            border: 1px solid rgba(6, 78, 59, 0.15);
            border-radius: 12px;
            padding: 15px 18px;
            color: var(--primary-green);
            font-size: 0.95rem;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .field-input:focus {
            outline: none;
            border-color: var(--accent-green);
            background: #ffffff;
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.1);
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
            margin-top: 30px;
            box-shadow: 0 10px 20px rgba(6, 78, 59, 0.15);
        }

        .submit-btn:hover {
            background: #08634c;
            transform: translateY(-2px);
            box-shadow: 0 15px 25px rgba(6, 78, 59, 0.2);
        }

        .submit-btn:active { transform: translateY(0); }

        .divider-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 15px;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.85rem;
            color: #4b5563;
            cursor: pointer;
        }

        .forgot-link {
            font-size: 0.85rem;
            color: var(--accent-green);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .forgot-link:hover { color: var(--primary-green); text-decoration: underline; }

        .error-text {
            color: #dc2626;
            font-size: 0.75rem;
            margin-top: 8px;
        }
    </style>

    <div class="login-wrapper">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>

        <div class="login-card">
            <h1 class="login-title">Welcome<br><i>back.</i></h1>
          

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="field-group">
                    <label class="field-label" for="email">Email Address</label>
                    <input id="email" class="field-input" type="email" name="email" value="{{ old('email') }}" placeholder="name@company.com" required autofocus />
                    @foreach ($errors->get('email') as $error)
                        <p class="error-text">{{ $error }}</p>
                    @endforeach
                </div>

                <div class="field-group">
                    <label class="field-label" for="password">Security Key</label>
                    <input id="password" class="field-input" type="password" name="password" placeholder="••••••••" required />
                    @foreach ($errors->get('password') as $error)
                        <p class="error-text">{{ $error }}</p>
                    @endforeach
                </div>

                <div class="divider-row">
                    <label class="remember-label">
                        <input type="checkbox" name="remember" style="accent-color: var(--primary-green)">
                        <span>Stay signed in</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="forgot-link" href="{{ route('password.request') }}">Reset Key</a>
                    @endif
                </div>

                <button type="submit" class="submit-btn">
                    Authenticate
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>