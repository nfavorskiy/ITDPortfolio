<x-guest-layout>
    <div class="container mt-5" style="max-width: 500px;">
        <h2 class="mb-4 text-center">Sign In</h2>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            @if(request('redirect_to_posts'))
                <input type="hidden" name="redirect_to_posts" value="true">
            @endif

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus>
                <div id="email-feedback" class="small mt-1" style="display: none;"></div>
                @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password">
                <div id="password-feedback" class="small mt-1" style="display: none;"></div>
                @error('password') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                <label class="form-check-label" for="remember_me">Remember Me</label>
            </div>

            <button type="submit" class="btn btn-primary w-100" id="login-btn">Log in</button>

            <div class="mt-3 text-center">
                <a href="{{ route('password.request') }}">Forgot your password?</a><br>
                <a href="{{ route('register') }}">Don't have an account? Sign up</a>
            </div>
        </form>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const emailInput = document.getElementById('email');
        const emailFeedback = document.getElementById('email-feedback');
        const passwordInput = document.getElementById('password');
        const passwordFeedback = document.getElementById('password-feedback');
        const loginBtn = document.getElementById('login-btn');

        // Email validation
        emailInput.addEventListener('input', function() {
            const email = this.value.trim();
            
            // Reset feedback
            emailFeedback.style.display = 'none';
            emailInput.classList.remove('is-invalid', 'is-valid');
            updateLoginButton();
            
            if (email.length === 0) {
                emailFeedback.textContent = 'Please enter your email address.';
                emailFeedback.className = 'small mt-1 text-danger';
                emailFeedback.style.display = 'block';
                emailInput.classList.add('is-invalid');
                updateLoginButton();
                return;
            }
            
            // Email format validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                emailFeedback.textContent = 'Please enter a valid email address.';
                emailFeedback.className = 'small mt-1 text-danger';
                emailFeedback.style.display = 'block';
                emailInput.classList.add('is-invalid');
                updateLoginButton();
                return;
            }
            
            // Valid email
            emailFeedback.textContent = '✓ Valid email format';
            emailFeedback.className = 'small mt-1 text-success';
            emailFeedback.style.display = 'block';
            emailInput.classList.add('is-valid');
            updateLoginButton();
        });

        // Password validation
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            
            // Reset feedback
            passwordFeedback.style.display = 'none';
            passwordInput.classList.remove('is-invalid', 'is-valid');
            updateLoginButton();
            
            if (password.length === 0) {
                passwordFeedback.textContent = 'Please enter your password.';
                passwordFeedback.className = 'small mt-1 text-danger';
                passwordFeedback.style.display = 'block';
                passwordInput.classList.add('is-invalid');
                updateLoginButton();
                return;
            }
            
            // Valid password (just check it's not empty for login)
            passwordFeedback.textContent = '✓ Password entered';
            passwordFeedback.className = 'small mt-1 text-success';
            passwordFeedback.style.display = 'block';
            passwordInput.classList.add('is-valid');
            updateLoginButton();
        });

        function updateLoginButton() {
            const emailInvalid = emailInput.classList.contains('is-invalid');
            const passwordInvalid = passwordInput.classList.contains('is-invalid');
            
            loginBtn.disabled = emailInvalid || passwordInvalid;
        }
    });
    </script>
</x-guest-layout>