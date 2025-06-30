<x-guest-layout>
    <div class="container mt-5" style="max-width: 600px;">
        <h2 class="mb-4 text-center">Verify Your Email</h2>

        @if (session('status') === 'verification-link-sent')
            <div class="alert alert-success text-center">
                A new verification link has been sent to your email address.
            </div>
        @endif

        <p class="text-center mb-4">
            Thanks for signing up! Before getting started, please verify your email address by clicking the link we just emailed to you.
        </p>

        <form method="POST" action="{{ route('verification.send') }}" class="text-center">
            @csrf
            <button type="submit" class="btn btn-primary">Resend Verification Email</button>
        </form>

        <div class="text-center mt-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-link">Logout</button>
            </form>
        </div>
    </div>
</x-guest-layout>
