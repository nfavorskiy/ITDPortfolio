<x-guest-layout>
    <div class="container mt-5" style="max-width: 500px;">
        <h2 class="mb-4 text-center">Sign Up</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required autofocus>
                <div id="name-feedback" class="small mt-1" style="display: none;"></div>
                <div id="name-loading" class="small mt-1 text-muted" style="display: none;">Checking availability...</div>
                @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required>
                @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password">
                @error('password') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-success w-100" id="register-btn">Register</button>

            <div class="mt-3 text-center">
                <a href="{{ route('login') }}">Already have an account? Log in</a>
            </div>
        </form>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.getElementById('name');
        const nameFeedback = document.getElementById('name-feedback');
        const nameLoading = document.getElementById('name-loading');
        const registerBtn = document.getElementById('register-btn');
        let debounceTimer;

        nameInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            
            // Reset feedback
            nameFeedback.style.display = 'none';
            if (nameLoading) nameLoading.style.display = 'none';
            registerBtn.disabled = false;
            nameInput.classList.remove('is-invalid', 'is-valid');
            
            const name = String(this.value).trim();
            
            if (name.length < 1) {
                return;
            }
            
            // Show loading indicator
            if (nameLoading) nameLoading.style.display = 'block';
            
            // Debounce the API call
            debounceTimer = setTimeout(() => {
                checkNameAvailability(name);
            }, 300);
        });

        function checkNameAvailability(name) {
            const nameStr = String(name);
            
            fetch('/check-name-availability', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ name: nameStr })
            })
            .then(response => response.json())
            .then(data => {
                // Hide loading
                if (nameLoading) nameLoading.style.display = 'none';
                
                if (data.available === false) {
                    nameFeedback.textContent = 'This name is already taken. Please choose a different name.';
                    nameFeedback.className = 'small mt-1 text-danger';
                    nameFeedback.style.display = 'block';
                    registerBtn.disabled = true;
                    nameInput.classList.add('is-invalid');
                } else {
                    nameFeedback.textContent = '✓ Name is available!';
                    nameFeedback.className = 'small mt-1 text-success';
                    nameFeedback.style.display = 'block';
                    registerBtn.disabled = false;
                    nameInput.classList.add('is-valid');
                }
            })
            .catch(error => {
                if (nameLoading) nameLoading.style.display = 'none';
                console.error('Error checking name availability:', error);
                nameFeedback.textContent = 'Error checking name availability. Please try again.';
                nameFeedback.className = 'small mt-1 text-warning';
                nameFeedback.style.display = 'block';
            });
        }
    });
    </script>
</x-guest-layout>