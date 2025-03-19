@extends('layouts.auth')

@section('title', 'Login')
@section('page-title', 'Sign In')

@section('content')
  <form action="{{ route('login') }}" class="form" method="POST">
    @csrf
    <div class="mb-3 f-email">
      <input type="email" name="email" class="form-control form-email @error('email') is-invalid @enderror"
        id="InputEmail" value="{{ old('email') }}" required autofocus>
      <label for="InputEmail" class="form-label form-label-email">Email</label>
    </div>
    <div class="mb-3 f-password">
      <input type="password" name="password" class="form-control form-password @error('password') is-invalid @enderror"
        id="InputPassword" required>
      <label for="InputPassword" class="form-label form-label-password">Password</label>
      <i class="fa fa-eye-slash toggle-password" id="togglePassword"></i>
    </div>
    <div class="mb-3 form-chech d-flex justify-content-between">
      <div class="">
        <input type="checkbox" name="remember" class="form-check-input" id="remember">
        <label for="remember" class="form-check-label">Remember Me</label>
      </div>
      <a href="{{ route('password.request') }}" class="forgot-password">Forgot Password?</a>
    </div>
    <button type="submit" class="btn btn-primary btn-sign-in">Sign In</button>
    <div class="mt-3 text-center">
      <span class="register">Don't have an account? <a href="{{ route('register') }}">Register</a></span>
    </div>
  </form>
@endsection

@section('scripts')
  <script>
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('InputPassword');
    togglePassword.addEventListener('click', function() {
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      this.classList.toggle('fa-eye');
      this.classList.toggle('fa-eye-slash');
    });
  </script>
