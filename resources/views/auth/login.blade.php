<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Restaurant Bites | Login to continue</title>
    <!-- Google Fonts + Tailwind CDN (for quick styling, plus custom overrides) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome 6 (free icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Custom configuration to extend Tailwind -->
    <style>
        /* custom restaurant themed styles */
        @import url('https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&family=Playfair+Display:wght@400;500;600;700&display=swap');

        * {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        .font-serif-alt {
            font-family: 'Playfair Display', serif;
        }

        /* backdrop blur & smooth transitions */
        .glass-card {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            border-radius: 2rem;
            box-shadow: 0 25px 45px -12px rgba(0, 0, 0, 0.25), 0 1px 2px rgba(0,0,0,0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .glass-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 30px 50px -15px rgba(0, 0, 0, 0.3);
        }

        .input-fancy {
            transition: all 0.2s ease;
            background-color: rgba(255, 255, 255, 0.8);
            border: 1px solid #e2e8f0;
        }
        .input-fancy:focus {
            border-color: #e67e22;
            ring: 2px solid #e67e22;
            background-color: white;
            box-shadow: 0 0 0 3px rgba(230, 126, 34, 0.2);
            outline: none;
        }

        .btn-primary-resto {
            background: linear-gradient(105deg, #e67e22 0%, #f39c12 100%);
            transition: all 0.25s;
            box-shadow: 0 8px 18px rgba(230, 126, 34, 0.25);
        }
        .btn-primary-resto:hover {
            background: linear-gradient(105deg, #d35400 0%, #e67e22 100%);
            transform: scale(0.98);
            box-shadow: 0 4px 12px rgba(230, 126, 34, 0.4);
        }

        .bg-food-pattern {
            background-image: radial-gradient(circle at 10% 30%, rgba(255,245,225,0.4) 2%, transparent 2.5%),
                              radial-gradient(circle at 85% 70%, rgba(255,200,140,0.3) 1.5%, transparent 2%);
            background-size: 38px 38px, 28px 28px;
        }

        .hero-bg-login {
            background-image: linear-gradient(115deg, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0.3) 100%), url('https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=1974&auto=format');
            background-size: cover;
            background-position: center 30%;
        }

        @media (max-width: 640px) {
            .hero-bg-login {
                background-position: 40% 20%;
            }
        }

        /* custom checkmark */
        .custom-check:checked {
            background-color: #e67e22;
            border-color: #e67e22;
        }
    </style>
</head>
<body class="antialiased">

    <!-- Restaurant Login Master Container -->
    <div class="relative min-h-screen flex items-center justify-center hero-bg-login bg-no-repeat bg-cover p-4">
        <!-- subtle overlay pattern + freshness -->
        <div class="absolute inset-0 bg-food-pattern opacity-40 pointer-events-none"></div>
        <div class="absolute inset-0 backdrop-brightness-95 pointer-events-none"></div>

        <!-- Main Card -->
        <div class="w-full max-w-md relative z-10 animate-fade-in-up">
            <!-- brand / restaurant logo & tagline -->
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center bg-white/80 backdrop-blur-sm w-20 h-20 rounded-full shadow-lg mb-3">
                    <i class="fas fa-utensils text-4xl text-orange-600"></i>
                </div>
                <h1 class="text-3xl font-serif-alt font-bold text-white drop-shadow-md tracking-tight">Flavor<span class="text-orange-300">Haven</span></h1>
                <p class="text-white/90 text-sm mt-1 font-medium">Online Food Order · Login to your account</p>
            </div>

            <!-- Glassmorphism Form Card (replaces default x-guest-layout) -->
            <div class="glass-card p-6 md:p-8">
                <!-- Session Status notification slot (like x-auth-session-status) -->
                @if(session('status'))
                    <div class="mb-5 p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2">
                        <i class="fas fa-check-circle text-emerald-500"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                <!-- Error bag / validation errors simulation (just for design completeness) -->
                @if($errors->any())
                    <div class="mb-5 p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-sm flex items-start gap-2">
                        <i class="fas fa-exclamation-triangle text-rose-500 mt-0.5"></i>
                        <div>
                            <strong>Oops!</strong> Please fix the following issues.
                            <ul class="list-disc list-inside mt-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <!-- Login Form (same route & method, enhanced design) -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Field with icon -->
                    <div class="mb-5">
                        <label for="email" class="block text-gray-700 font-semibold text-sm mb-1.5 flex items-center gap-2">
                            <i class="fas fa-envelope text-orange-500 text-xs"></i> Email Address
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i class="fas fa-at text-sm"></i>
                            </span>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                   class="input-fancy w-full pl-10 pr-4 py-3 rounded-2xl border border-gray-200 focus:border-orange-400 focus:ring-2 focus:ring-orange-200 transition-all duration-200 bg-white/80"
                                   placeholder="you@example.com">
                        </div>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1 flex items-center gap-1"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field with toggle visibility (extra UX) -->
                    <div class="mb-5">
                        <label for="password" class="block text-gray-700 font-semibold text-sm mb-1.5 flex items-center gap-2">
                            <i class="fas fa-lock text-orange-500 text-xs"></i> Password
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i class="fas fa-key text-sm"></i>
                            </span>
                            <input type="password" id="password" name="password" required autocomplete="current-password"
                                   class="input-fancy w-full pl-10 pr-12 py-3 rounded-2xl border border-gray-200 focus:border-orange-400 transition-all duration-200 bg-white/80"
                                   placeholder="••••••••">
                            <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-orange-600 transition">
                                <i class="fas fa-eye-slash text-sm"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1 flex items-center gap-1"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot password row (flex between) -->
                    <div class="flex flex-wrap items-center justify-between mt-4 mb-6">
                        <label class="inline-flex items-center cursor-pointer group">
                            <input type="checkbox" name="remember" id="remember_me" class="rounded-md border-gray-300 text-orange-600 shadow-sm focus:ring-orange-400 custom-check w-4 h-4 transition checked:bg-orange-500" 
                                   {{ old('remember') ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700 group-hover:text-orange-700 transition flex items-center gap-1">
                                <i class="fas fa-memory text-gray-400 text-xs"></i> Remember me
                            </span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-orange-700 hover:text-orange-900 font-medium transition underline decoration-orange-300 underline-offset-2 flex items-center gap-1">
                                <i class="fas fa-question-circle"></i> Forgot password?
                            </a>
                        @endif
                    </div>

                    <!-- Login Button with delivery vibe -->
                    <button type="submit" class="btn-primary-resto w-full text-white font-bold py-3.5 rounded-2xl transition flex items-center justify-center gap-3 text-lg shadow-md">
                        <i class="fas fa-sign-in-alt"></i> 
                        <span>Login & Order Food</span>
                        <i class="fas fa-chevron-right text-xs opacity-70"></i>
                    </button>

                    <!-- Extra: signup suggestion (restaurant brand) -->
                    <div class="mt-6 text-center text-sm text-gray-600 border-t border-gray-100 pt-5">
                        <p class="flex items-center justify-center gap-2">
                            <i class="fas fa-hamburger text-orange-400"></i>
                            Don't have an account?
                            <a href="#" class="font-semibold text-orange-600 hover:text-orange-800 transition ml-1 underline decoration-orange-300">Sign up now</a>
                        </p>
                        <p class="text-xs text-gray-400 mt-2">Get exclusive deals & faster checkout</p>
                    </div>
                </form>
            </div>

            <!-- extra decorative food badges (just style) -->
            <div class="flex justify-center gap-4 mt-6 text-white/70 text-xs font-medium">
                <span class="bg-black/20 backdrop-blur-sm px-3 py-1 rounded-full"><i class="fas fa-pizza-slice mr-1"></i> Pizza</span>
                <span class="bg-black/20 backdrop-blur-sm px-3 py-1 rounded-full"><i class="fas fa-hamburger mr-1"></i> Burgers</span>
                <span class="bg-black/20 backdrop-blur-sm px-3 py-1 rounded-full"><i class="fas fa-mug-hot mr-1"></i> Desserts</span>
            </div>
        </div>
    </div>

    <!-- small script for toggle password visibility (non-intrusive) -->
    <script>
        (function() {
            const toggleBtn = document.getElementById('togglePassword');
            if(toggleBtn) {
                const passwordInput = document.getElementById('password');
                toggleBtn.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    const icon = toggleBtn.querySelector('i');
                    if(icon.classList.contains('fa-eye-slash')) {
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    } else {
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    }
                });
            }
        })();
    </script>
    <!-- Additional subtle animations (if needed) -->
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out forwards;
        }
        input, button {
            transition: all 0.2s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }
        .glass-card {
            transition: all 0.25s;
        }
    </style>
</body>
</html>