<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Join FlavorHaven | Create your account</title>
    <!-- Tailwind + Font Awesome + Google Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&family=Playfair+Display:wght@400;500;600;700&display=swap');
        
        * {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        .font-serif-alt {
            font-family: 'Playfair Display', serif;
        }

        /* Glass card effect */
        .glass-card {
            background: rgba(255, 255, 255, 0.94);
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
            background-color: rgba(255, 255, 255, 0.9);
            border: 1px solid #e2e8f0;
        }

        .input-fancy:focus {
            border-color: #e67e22;
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

        .hero-bg-register {
            background-image: linear-gradient(115deg, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0.3) 100%), url('https://images.unsplash.com/photo-1555939594-58d7cb561ad1?q=80&w=1887&auto=format');
            background-size: cover;
            background-position: center 35%;
        }

        @media (max-width: 640px) {
            .hero-bg-register {
                background-position: 45% 20%;
            }
        }

        /* custom checkbox/radio */
        .custom-check:checked {
            background-color: #e67e22;
            border-color: #e67e22;
        }

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
    </style>
</head>
<body class="antialiased">
    <div class="relative min-h-screen flex items-center justify-center hero-bg-register bg-no-repeat bg-cover p-4">
        <!-- overlay pattern -->
        <div class="absolute inset-0 bg-food-pattern opacity-40 pointer-events-none"></div>
        <div class="absolute inset-0 backdrop-brightness-95 pointer-events-none"></div>

        <div class="w-full max-w-md relative z-10 animate-fade-in-up">
            <!-- restaurant branding -->
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center bg-white/80 backdrop-blur-sm w-20 h-20 rounded-full shadow-lg mb-3">
                    <i class="fas fa-utensils text-4xl text-orange-600"></i>
                </div>
                <h1 class="text-3xl font-serif-alt font-bold text-white drop-shadow-md tracking-tight">Flavor<span class="text-orange-300">Haven</span></h1>
                <p class="text-white/90 text-sm mt-1 font-medium">Join & get delicious offers</p>
            </div>

            <!-- Registration Glass Card -->
            <div class="glass-card p-6 md:p-8">
                <!-- Session Status or success messages (if any) -->
                @if(session('status'))
                    <div class="mb-5 p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2">
                        <i class="fas fa-check-circle text-emerald-500"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                <!-- Display validation errors gracefully -->
                @if($errors->any())
                    <div class="mb-5 p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-sm flex items-start gap-2">
                        <i class="fas fa-exclamation-triangle text-rose-500 mt-0.5"></i>
                        <div>
                            <strong>Please fix the following</strong>
                            <ul class="list-disc list-inside mt-1 text-xs">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <!-- Registration Form – same structure as original but with enhanced design -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name Field with icon -->
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-semibold text-sm mb-1.5 flex items-center gap-2">
                            <i class="fas fa-user text-orange-500 text-xs"></i> Full Name
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i class="fas fa-user-circle text-sm"></i>
                            </span>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                                   class="input-fancy w-full pl-10 pr-4 py-3 rounded-2xl border border-gray-200 focus:border-orange-400 transition-all duration-200"
                                   placeholder="John Doe">
                        </div>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1 flex items-center gap-1"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-semibold text-sm mb-1.5 flex items-center gap-2">
                            <i class="fas fa-envelope text-orange-500 text-xs"></i> Email Address
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i class="fas fa-at text-sm"></i>
                            </span>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                                   class="input-fancy w-full pl-10 pr-4 py-3 rounded-2xl border border-gray-200 focus:border-orange-400 transition-all duration-200"
                                   placeholder="delicious@example.com">
                        </div>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1 flex items-center gap-1"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field with toggle -->
                    <div class="mb-4">
                        <label for="password" class="block text-gray-700 font-semibold text-sm mb-1.5 flex items-center gap-2">
                            <i class="fas fa-lock text-orange-500 text-xs"></i> Password
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i class="fas fa-key text-sm"></i>
                            </span>
                            <input type="password" id="password" name="password" required autocomplete="new-password"
                                   class="input-fancy w-full pl-10 pr-12 py-3 rounded-2xl border border-gray-200 focus:border-orange-400 transition-all duration-200"
                                   placeholder="Create a strong password">
                            <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-orange-600 transition">
                                <i class="fas fa-eye-slash text-sm"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1 flex items-center gap-1"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-400 mt-1 flex items-center gap-1"><i class="fas fa-info-circle"></i> Min. 8 characters</p>
                    </div>

                    <!-- Confirm Password Field with separate toggle (optional) -->
                    <div class="mb-5">
                        <label for="password_confirmation" class="block text-gray-700 font-semibold text-sm mb-1.5 flex items-center gap-2">
                            <i class="fas fa-check-circle text-orange-500 text-xs"></i> Confirm Password
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i class="fas fa-shield-alt text-sm"></i>
                            </span>
                            <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"
                                   class="input-fancy w-full pl-10 pr-12 py-3 rounded-2xl border border-gray-200 focus:border-orange-400 transition-all duration-200"
                                   placeholder="Repeat your password">
                            <button type="button" id="toggleConfirmPassword" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-orange-600 transition">
                                <i class="fas fa-eye-slash text-sm"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <p class="text-red-500 text-xs mt-1 flex items-center gap-1"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bonus: Accept terms (inline with design, not in original but adds restaurant trust) -->
                    <div class="flex items-start gap-2 mb-6">
                        <input type="checkbox" id="terms" name="terms" required class="rounded border-gray-300 text-orange-600 shadow-sm focus:ring-orange-400 custom-check w-4 h-4 mt-0.5">
                        <label for="terms" class="text-xs text-gray-600 leading-tight">I agree to the <a href="#" class="text-orange-600 hover:underline">Terms of Service</a> and <a href="#" class="text-orange-600 hover:underline">Privacy Policy</a> (including food order updates).</label>
                    </div>

                    <!-- Register Button with food vibe -->
                    <button type="submit" class="btn-primary-resto w-full text-white font-bold py-3.5 rounded-2xl transition flex items-center justify-center gap-3 text-lg shadow-md">
                        <i class="fas fa-user-plus"></i>
                        <span>Create Account & Order</span>
                        <i class="fas fa-arrow-right text-xs opacity-70"></i>
                    </button>

                    <!-- Already registered link -->
                    <div class="mt-6 text-center text-sm text-gray-600 border-t border-gray-100 pt-5">
                        <p class="flex items-center justify-center gap-2">
                            <i class="fas fa-utensil-spoon text-orange-400"></i>
                            Already have an account?
                            <a href="{{ route('login') }}" class="font-semibold text-orange-600 hover:text-orange-800 transition ml-1 underline decoration-orange-300">
                                Sign in here
                            </a>
                        </p>
                        <p class="text-xs text-gray-400 mt-2">Join now & get 20% off your first order!</p>
                    </div>
                </form>
            </div>

            <!-- extra food badges (consistency) -->
            <div class="flex justify-center gap-4 mt-6 text-white/70 text-xs font-medium">
                <span class="bg-black/20 backdrop-blur-sm px-3 py-1 rounded-full"><i class="fas fa-fish mr-1"></i> Seafood</span>
                <span class="bg-black/20 backdrop-blur-sm px-3 py-1 rounded-full"><i class="fas fa-cheese mr-1"></i> Cheese Lovers</span>
                <span class="bg-black/20 backdrop-blur-sm px-3 py-1 rounded-full"><i class="fas fa-cocktail mr-1"></i> Mocktails</span>
            </div>
        </div>
    </div>

    <!-- Password visibility toggles (for both password and confirm) -->
    <script>
        (function() {
            // Toggle for main password field
            const toggleBtn = document.getElementById('togglePassword');
            if (toggleBtn) {
                const passwordInput = document.getElementById('password');
                toggleBtn.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    const icon = toggleBtn.querySelector('i');
                    if (icon.classList.contains('fa-eye-slash')) {
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    } else {
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    }
                });
            }

            // Toggle for confirm password field
            const toggleConfirm = document.getElementById('toggleConfirmPassword');
            if (toggleConfirm) {
                const confirmInput = document.getElementById('password_confirmation');
                toggleConfirm.addEventListener('click', function() {
                    const type = confirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    confirmInput.setAttribute('type', type);
                    const icon = toggleConfirm.querySelector('i');
                    if (icon.classList.contains('fa-eye-slash')) {
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    } else {
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    }
                });
            }

            // optional: enforce terms checkbox before submit (just visual helper, native required works)
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const termsCheck = document.getElementById('terms');
                    if (termsCheck && !termsCheck.checked) {
                        e.preventDefault();
                        alert('Please accept the Terms of Service and Privacy Policy to continue.');
                        termsCheck.focus();
                    }
                });
            }
        })();
    </script>
</body>
</html>