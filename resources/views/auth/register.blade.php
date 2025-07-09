<x-guest-layout :title="'Sign Up - ' . config('app.name')">
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
                <div id="email-feedback" class="small mt-1" style="display: none;"></div>
                <div id="email-loading" class="small mt-1 text-muted" style="display: none;">Checking availability...</div>
                @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password">
                
                <!-- Password Requirements Checklist -->
                <div id="password-requirements" class="small mt-2" style="display: none;">
                    <div class="mb-1 text-muted">Password must contain:</div>
                    <ul class="list-unstyled mb-0">
                        <li id="req-length" class="text-danger">
                            <span class="req-icon">✗</span> At least 8 characters
                        </li>
                        <li id="req-uppercase" class="text-danger">
                            <span class="req-icon">✗</span> One uppercase letter
                        </li>
                        <li id="req-lowercase" class="text-danger">
                            <span class="req-icon">✗</span> One lowercase letter
                        </li>
                        <li id="req-number" class="text-danger">
                            <span class="req-icon">✗</span> One number
                        </li>
                        <li id="req-special" class="text-danger">
                            <span class="req-icon">✗</span> One special character
                        </li>
                    </ul>
                </div>
                
                @error('password') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required>
                <div id="password-confirmation-feedback" class="small mt-1" style="display: none;"></div>
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
        
        const emailInput = document.getElementById('email');
        const emailFeedback = document.getElementById('email-feedback');
        const emailLoading = document.getElementById('email-loading');
        
        const passwordInput = document.getElementById('password');
        const passwordRequirements = document.getElementById('password-requirements');
        
        const passwordConfirmationInput = document.getElementById('password_confirmation');
        const passwordConfirmationFeedback = document.getElementById('password-confirmation-feedback');
        
        const registerBtn = document.getElementById('register-btn');
        let nameDebounceTimer;
        let emailDebounceTimer;

        // Name validation
        nameInput.addEventListener('input', function() {
            clearTimeout(nameDebounceTimer);
            
            // Reset feedback
            nameFeedback.style.display = 'none';
            if (nameLoading) nameLoading.style.display = 'none';
            nameInput.classList.remove('is-invalid', 'is-valid');
            updateRegisterButton();
            
            const name = String(this.value).trim();
            
            // Check if name is empty
            if (name.length === 0) {
                nameFeedback.textContent = 'Please enter your name.';
                nameFeedback.className = 'small mt-1 text-danger';
                nameFeedback.style.display = 'block';
                nameInput.classList.add('is-invalid');
                updateRegisterButton();
                return;
            }
            
            // Show loading indicator
            if (nameLoading) nameLoading.style.display = 'block';
            
            // Debounce the API call
            nameDebounceTimer = setTimeout(() => {
                checkNameAvailability(name);
            }, 300);
        });

        // Email validation
        emailInput.addEventListener('input', function() {
            clearTimeout(emailDebounceTimer);
            
            // Reset feedback
            emailFeedback.style.display = 'none';
            if (emailLoading) emailLoading.style.display = 'none';
            emailInput.classList.remove('is-invalid', 'is-valid');
            updateRegisterButton();
            
            const email = String(this.value).trim();
            
            // Check if email is empty
            if (email.length === 0) {
                emailFeedback.textContent = 'Please enter your email address.';
                emailFeedback.className = 'small mt-1 text-danger';
                emailFeedback.style.display = 'block';
                emailInput.classList.add('is-invalid');
                updateRegisterButton();
                return;
            }
            
            // Strict email format check - same as backend
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                // Show invalid format error immediately
                emailFeedback.textContent = 'Please enter a valid email address (e.g., user@example.com).';
                emailFeedback.className = 'small mt-1 text-danger';
                emailFeedback.style.display = 'block';
                emailInput.classList.add('is-invalid');
                updateRegisterButton();
                return;
            }
            
            // Show loading indicator for valid format emails
            if (emailLoading) emailLoading.style.display = 'block';
            
            // Debounce the API call
            emailDebounceTimer = setTimeout(() => {
                checkEmailAvailability(email);
            }, 300);
        });

        // Password validation
        passwordInput.addEventListener('focus', function() {
            passwordRequirements.style.display = 'block';
        });

        passwordInput.addEventListener('input', function() {
            validatePassword();
            validatePasswordConfirmation();
        });

        passwordInput.addEventListener('blur', function() {
            // Check if password is empty when user leaves the field
            if (passwordInput.value.length === 0) {
                passwordRequirements.style.display = 'none';
                passwordInput.classList.add('is-invalid');
                updateRegisterButton();
            }
        });

        // Password confirmation validation
        passwordConfirmationInput.addEventListener('input', function() {
            validatePasswordConfirmation();
        });

        function validatePassword() {
            const password = passwordInput.value;
            
            // Show requirements when user starts typing
            if (password.length > 0) {
                passwordRequirements.style.display = 'block';
            }
            
            // Reset password input styling
            passwordInput.classList.remove('is-invalid', 'is-valid');
            
            let allValid = true;
            
            // Check minimum length
            const lengthValid = password.length >= 8;
            updateRequirement('req-length', lengthValid);
            if (!lengthValid) allValid = false;
            
            // Check for uppercase letter
            const uppercaseValid = /[A-Z]/.test(password);
            updateRequirement('req-uppercase', uppercaseValid);
            if (!uppercaseValid) allValid = false;
            
            // Check for lowercase letter
            const lowercaseValid = /[a-z]/.test(password);
            updateRequirement('req-lowercase', lowercaseValid);
            if (!lowercaseValid) allValid = false;
            
            // Check for number
            const numberValid = /\d/.test(password);
            updateRequirement('req-number', numberValid);
            if (!numberValid) allValid = false;
            
            // Check for special character
            const specialValid = /[^a-zA-Z0-9\s]/.test(password);
            updateRequirement('req-special', specialValid);
            if (!specialValid) allValid = false;
            
            // Update password input styling
            if (password.length > 0) {
                if (allValid) {
                    passwordInput.classList.add('is-valid');
                } else {
                    passwordInput.classList.add('is-invalid');
                }
            }
            
            updateRegisterButton();
        }

        function updateRequirement(requirementId, isValid) {
            const element = document.getElementById(requirementId);
            const icon = element.querySelector('.req-icon');
            
            if (isValid) {
                element.className = 'text-success';
                icon.textContent = '✓';
            } else {
                element.className = 'text-danger';
                icon.textContent = '✗';
            }
        }

        function validatePasswordConfirmation() {
            const password = passwordInput.value;
            const confirmation = passwordConfirmationInput.value;
            
            // Reset feedback
            passwordConfirmationFeedback.style.display = 'none';
            passwordConfirmationInput.classList.remove('is-invalid', 'is-valid');
            
            if (confirmation.length === 0) {
                updateRegisterButton();
                return;
            }
            
            if (password !== confirmation) {
                passwordConfirmationFeedback.textContent = 'Passwords do not match.';
                passwordConfirmationFeedback.className = 'small mt-1 text-danger';
                passwordConfirmationFeedback.style.display = 'block';
                passwordConfirmationInput.classList.add('is-invalid');
            } else {
                passwordConfirmationFeedback.textContent = '✓ Passwords match!';
                passwordConfirmationFeedback.className = 'small mt-1 text-success';
                passwordConfirmationFeedback.style.display = 'block';
                passwordConfirmationInput.classList.add('is-valid');
            }
            
            updateRegisterButton();
        }

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
                    nameInput.classList.add('is-invalid');
                } else {
                    nameFeedback.textContent = '✓ Name is available!';
                    nameFeedback.className = 'small mt-1 text-success';
                    nameFeedback.style.display = 'block';
                    nameInput.classList.add('is-valid');
                }
                updateRegisterButton();
            })
            .catch(error => {
                if (nameLoading) nameLoading.style.display = 'none';
                console.error('Error checking name availability:', error);
                nameFeedback.textContent = 'Error checking name availability. Please try again.';
                nameFeedback.className = 'small mt-1 text-warning';
                nameFeedback.style.display = 'block';
                updateRegisterButton();
            });
        }

        function checkEmailAvailability(email) {
            const emailStr = String(email);
            
            fetch('/check-email-availability', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ email: emailStr })
            })
            .then(response => response.json())
            .then(data => {
                // Hide loading
                if (emailLoading) emailLoading.style.display = 'none';
                
                if (data.available === false) {
                    emailFeedback.textContent = 'This email is already registered. Please use a different email.';
                    emailFeedback.className = 'small mt-1 text-danger';
                    emailFeedback.style.display = 'block';
                    emailInput.classList.add('is-invalid');
                } else {
                    emailFeedback.textContent = '✓ Email is available!';
                    emailFeedback.className = 'small mt-1 text-success';
                    emailFeedback.style.display = 'block';
                    emailInput.classList.add('is-valid');
                }
                updateRegisterButton();
            })
            .catch(error => {
                if (emailLoading) emailLoading.style.display = 'none';
                console.error('Error checking email availability:', error);
                emailFeedback.textContent = 'Error checking email availability. Please try again.';
                emailFeedback.className = 'small mt-1 text-warning';
                emailFeedback.style.display = 'block';
                updateRegisterButton();
            });
        }

        function updateRegisterButton() {
            // Disable button if any field has is-invalid class
            const nameInvalid = nameInput.classList.contains('is-invalid');
            const emailInvalid = emailInput.classList.contains('is-invalid');
            const passwordInvalid = passwordInput.classList.contains('is-invalid');
            const confirmationInvalid = passwordConfirmationInput.classList.contains('is-invalid');
            
            registerBtn.disabled = nameInvalid || emailInvalid || passwordInvalid || confirmationInvalid;
        }
    });
    </script>
</x-guest-layout>