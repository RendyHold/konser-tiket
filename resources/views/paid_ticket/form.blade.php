{{-- resources/views/paid_ticket/form.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-6">
  <h2 class="text-xl font-semibold mb-4">Klaim Tiket Berbayar</h2>

  @if(session('ok'))<div class="p-3 bg-green-50 border text-green-700 mb-4">{{ session('ok') }}</div>@endif
  @if($errors->any())
    <div class="p-3 bg-red-50 border text-red-700 mb-4">
      <ul class="list-disc pl-5">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('paid.claim.submit') }}" enctype="multipart/form-data" class="space-y-4">
    @csrf
    <div>
      <label class="block text-sm font-medium mb-1">NPM</label>
      <input name="npm" value="{{ old('npm') }}" required class="w-full border rounded px-3 py-2">
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Nominal Pembayaran (Rp)</label>
      <input type="number" name="amount" value="{{ old('amount') }}" min="1" required class="w-full border rounded px-3 py-2">
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Bukti SIAK</label>
      <input type="file" name="bukti_npm" accept=".jpg,.jpeg,.png,.webp,.pdf" required class="w-full border rounded px-3 py-2">
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Bukti Pembayaran</label>
      <input type="file" name="bukti_bayar" accept=".jpg,.jpeg,.png,.webp,.pdf" required class="w-full border rounded px-3 py-2">
    </div>

    <div class="pt-2 flex gap-3">
      <button class="bg-indigo-600 text-white px-4 py-2 rounded">Kirim Klaim</button>
      <a class="text-gray-600 hover:underline" href="{{ route('paid.claim.mine') }}">Klaim Saya</a>
    </div>
  </form>
</div>
@endsection
