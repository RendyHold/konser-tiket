@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-xl px-4 py-6">
  <h1 class="text-2xl font-bold tracking-tight mb-6">Claim Tiket</h1>

  {{-- Error summary --}}
  @if ($errors->any())
    <div class="mb-6 rounded-md border border-red-200 bg-red-50 p-4 text-red-700">
      <div class="font-semibold mb-2">Terdapat kesalahan pada form:</div>
      <ul class="list-disc pl-5 space-y-1">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('ticket.claim') }}" method="POST" class="space-y-5" enctype="multipart/form-data">
    @csrf

    {{-- NPM --}}
    <div>
      <label for="npm" class="block text-sm font-medium mb-1">
        Nomor Pokok Mahasiswa (NPM)
      </label>
      <input
        type="text"
        name="npm"
        id="npm"
        value="{{ old('npm') }}"
        required
        class="w-full rounded border px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('npm') border-red-500 @enderror"
      >
      <p class="mt-1 text-xs text-gray-500">Satu NPM hanya dapat generate 1 tiket.</p>
      @error('npm')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
      @enderror
    </div>

    {{-- SS SIAK (wajib) --}}
<div class="mt-4">
  <label for="bukti_npm" class="block text-sm font-medium mb-1">Bukti SIAK</label>
  <p class="text-xs text-gray-500 mb-2">FOTO/SS SIAK yang kamu unggah saat klaim tiket</p>

  <input
    type="file"
    id="bukti_npm"
    name="bukti_npm"
    accept=".jpg,.jpeg,.png,.webp,.pdf"
    required
    class="w-full rounded border px-3 py-2"
  >

  @error('bukti_npm')
    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
  @enderror
</div>
</div>
<form action="{{ route('ticket.claim') }}" method="POST">
  @csrf  <!-- Token CSRF untuk keamanan -->
  {{-- Input lainnya jika diperlukan --}}
  <div class="pt-2">
    <button
      type="submit"
      class="inline-flex items-center rounded bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
    >
    Claim Tiket
    </button>

  {{-- Actions --}}


    <a href="{{ route('ticket.show') }}" class="ml-3 text-sm text-gray-600 hover:underline">
      Lihat tiket saya
    </a>
  </div>
</form>
</div>
@endsection
