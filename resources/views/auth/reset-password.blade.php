<x-guest-layout>
    <div class="container mt-5" style="max-width: 500px;">
        <h2 class="mb-4 text-center">Reset Password</h2>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input id="email" class="form-control" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus>
                @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password">
                @error('password') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Reset Password</button>
        </form>
    </div>
</x-guest-layout>
