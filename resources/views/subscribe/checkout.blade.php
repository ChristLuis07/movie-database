@extends('layouts.subscribe')

@section('title', 'Payment Detail')
@section('page-title', 'Payment Detail')

@section('content')
  <div class="mt-4 text-white card bg-dark border-green">
    <div class="card-body">
      <div class="mb-3 row align-items-center">
        <div class="col-8">
          <h5 class="mb-0">{{ $plan->title }} - {{ $plan->duration }} Hari</h5>
        </div>
        <div class="col-4 text-end">
          <span class="fs-5">Rp.{{ number_format($plan->price, 0, ',', '.') }}</span>
        </div>
      </div>
      <hr class="border-green">

      <div class="mb-2 row">
        <div class="col-8">SubTotal</div>
        <div class="col-4 text-end">Rp.{{ number_format($plan->price, 0, ',', '.') }}</div>
      </div>
      <div class="mb-2 row">
        <div class="col-8">Ppn 12%</div>
        <div class="col-4 text-end">Rp.{{ number_format($plan->price * 0.12, 0, ',', '.') }}</div>
      </div>
      <hr class="border-green">
      <div class="mb-4 row">
        <div class="col-8">Total Payment</div>
        <div class="col-4 text-end fw-bold">Rp.{{ number_format($plan->price * 1.1, 0, ',', '.') }}</div>
      </div>
      <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="terms" required>
        <label for="terms" class="form-check-label">
          By continuing the payment, you agree to our
          <a href="#" class="text-info">Terms and Conditions</a> and
          <a href="#" class="text-info">Privacy Policy</a>
        </label>
      </div>
      <form action="#" method="POST">
        @csrf
        <button type="submit" class="w-100 btn btn-green" id="pay-button">Continue</button>
      </form>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
  <script>
    const payButton = document.querySelector('#pay-button');
    payButton.addEventListener('click', function(e) {
      e.preventDefault();

      fetch('/checkout', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringfify({
          plan_id: '{{ $plan->id }}',
          amount: '{{ $plan->price * 1.1 }}'
        })
      })
      .then(response => response.json())
      .then(data => {
        if(data.status === 'success') {
          window.snap.pay(data.snap_token, {
            onSuccess: function(result) {
              window.location.href = 'subscribe/success';
            },
            onPending: function(result) {
              window.location.href = 'payment/pending';
            },
            onError: function(result) {
              window.location.href = 'payment/error';
            },
            onClose: function() {
              alert('You closed the payment window without completing the payment');
            }
          });
        } else {
          alet('Payment failed to initialize');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('something went wrong');
      });
    });
  </script>
@endsection
