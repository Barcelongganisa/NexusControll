<title>Login Form</title>
<x-guest-layout>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

    <!-- Button to Open Login Modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">
        Login
    </button>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="loginModalLabel">Login</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Session Status -->
                    <x-auth-session-status class="alert alert-info" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-3">
                            <x-input-label for="email" :value="__('Email')" class="form-label" />
                            <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="text-danger small" />
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <x-input-label for="password" :value="__('Password')" class="form-label" />
                            <x-text-input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" />
                            <x-input-error :messages="$errors->get('password')" class="text-danger small" />
                        </div>

                        <!-- Google reCAPTCHA -->
                        <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                        @error('g-recaptcha-response')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        <!-- Remember Me -->
                        <div class="mb-3 form-check">
                            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                            <label for="remember_me" class="form-check-label">{{ __('Remember me') }}</label>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <!-- Forgot Password Link (Triggers Another Modal) -->
                            <a href="#" class="text-decoration-none small" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">
                                {{ __('Forgot your password?') }}
                            </a>

                            <x-primary-button class="btn btn-primary">
                                {{ __('Log in') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="forgotPasswordModalLabel">Forgot Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-center text-muted">
                        {{ __('Forgot your password? No problem. Just enter your email, and we will send you a reset link.') }}
                    </p>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-4">
                            <x-input-label for="forgot_email" :value="__('Email')" />
                            <x-text-input id="forgot_email" class="block w-full form-control mt-1" type="email" name="email" :value="old('email')" required autofocus />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="d-flex justify-content-center">
                            <x-primary-button class="btn btn-primary">
                                {{ __('Email Password Reset Link') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</x-guest-layout>
