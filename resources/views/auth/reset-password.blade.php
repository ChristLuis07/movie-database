@extends('layouts.auth')

@section('title', 'Reset Password')
@section('page-titl', 'Set New Password')

@section('content')
  <form action="{{ route('password.update') }}" class="form" method="POST">
    @csrf
    <input type="hidden" name="token" value="{{ $request->route('token') }}">
    <input type="hidden" name="email" value="{{ $request->email }}">

    <div class="mb-3 f-password">
      <input type="password" name="password" class="form-control form-password @error('password') is-invalid @enderror"
        id="InputPassword" required>
      <label for="InputPassword" class="form-label form-label-password">New Password</label>
      <i class="fa fa-eye-slash toggle-password" id="togglePassword"></i>
    </div>
    <div class="mb-3 f-password">
      <input type="password" name="passowrd_confirmation" class="form-control form-password"
        id="InputPasswordConfirmation" required>
      <label for="InputPassowrdConfirmation" class="form-label form-label-password">Confirm New Password</label>
      <i class="fa fa-eye-slash toggle-password" id="togglePassword"></i>
    </div>
    <button type="submit" class="btn btn-primary btn-sign-in">Reset Password</button>
  </form>
@endsection

@section('scripts')
  <script>
    document.querySelectorAll('.toggle-password').forEach(toggle => {
      toggle.addEventListener('click', function() {
        const input = this.previousElementSibling;
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
      });
    });
  </script>
