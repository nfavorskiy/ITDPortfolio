@extends('layouts.app')

@section('title', '500 - Server Error - ' . config('app.name'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="error-template">
                <h1 class="display-1 text-danger">500</h1>
                <h2 class="mb-4">Internal Server Error</h2>
                <p class="lead mb-4">
                    Something went wrong on our end. We're working to fix it!
                </p>
                <div class="error-actions">
                    <a href="{{ url('/') }}" class="btn btn-primary btn-lg me-2">
                        <i class="bi bi-house me-2"></i>Go to Home page
                    </a>
                </div>
                
                <div class="mt-5">
                    <h5>What happened?</h5>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-exclamation-triangle text-warning"></i> A server error occurred while processing your request</li>
                        <li><i class="bi bi-tools text-primary"></i> Our team has been notified and is working on a fix</li>
                        <li><i class="bi bi-arrow-clockwise text-primary"></i> Try refreshing the page in a few moments</li>
                        <li><i class="bi bi-arrow-right text-primary"></i> If the problem persists, go back to the <a href="{{ url('/') }}">homepage</a></li>
                    </ul>
                </div>
                
                <div class="mt-4">
                    <p class="text-muted small">
                    <!--    Error Code: 500 | {{ now()->format('Y-m-d H:i:s') }} -->
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.error-template {
    padding: 40px 15px;
    text-align: center;
}

.error-template h1 {
    font-size: 8rem;
    font-weight: 700;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
}

.error-template h2 {
    color: #333;
    font-weight: 600;
}

.error-template .lead {
    color: #666;
    font-size: 1.1rem;
}

.error-actions {
    margin-top: 30px;
}

.error-template ul li {
    margin: 10px 0;
    color: #666;
}

.error-template ul li a {
    color: #0d6efd;
    text-decoration: none;
}

.error-template ul li a:hover {
    text-decoration: underline;
}

@media (max-width: 768px) {
    .error-template h1 {
        font-size: 4rem;
    }
    
    .error-actions .btn {
        display: block;
        width: 100%;
        margin: 10px 0;
    }
}
</style>
@endsection