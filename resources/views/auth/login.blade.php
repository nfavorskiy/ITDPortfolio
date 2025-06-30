<x-guest-layout>
    <div class="container mt-5" style="max-width: 500px;">
        <h2 class="mb-4 text-center">Sign In</h2>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password">
                @error('password') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                <label class="form-check-label" for="remember_me">Remember Me</label>
            </div>

            <button type="submit" class="btn btn-primary w-100">Log in</button>

            <div class="mt-3 text-center">
                <a href="{{ route('password.request') }}">Forgot your password?</a><br>
                <a href="{{ route('register') }}">Don’t have an account? Sign up</a>
            </div>
        </form>
    </div>
</x-guest-layout>
