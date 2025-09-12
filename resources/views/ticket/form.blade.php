@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-2xl px-6 py-8 bg-white shadow-xl rounded-xl">

  <!-- Title Section -->
  <h1 class="text-3xl font-semibold text-center text-gray-900 mb-6">Claim Tiket</h1>

  <!-- Instructional Text -->
  <div class="mb-6 text-gray-700 text-sm">
    <p>Untuk klaim tiket, pastikan kamu mengisi informasi berikut dengan benar:</p>
    <ul class="list-disc pl-6 mt-2">
      <li class="mt-1">Isi NPM yang valid, karena satu NPM hanya dapat digunakan untuk klaim 1 tiket.</li>
      <li class="mt-1">Unggah foto atau SS SIKA yang sah sesuai dengan instruksi.</li>
    </ul>
  </div>

  <!-- Error Summary -->
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

  <!-- Claim Ticket Form -->
  <form action="{{ route('ticket.claim') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
    @csrf

    <!-- NPM Field -->
    <div>
      <label for="npm" class="block text-sm font-medium text-gray-800 mb-2">Nomor Pokok Mahasiswa (NPM)</label>
      <input
        type="text"
        name="npm"
        id="npm"
        value="{{ old('npm') }}"
        required
        class="w-full rounded-md border-gray-300 shadow-sm px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('npm') border-red-500 @enderror"
        placeholder="Masukkan NPM Anda"
      >
      <p class="mt-2 text-xs text-gray-500">Satu NPM hanya dapat generate 1 tiket.</p>
      @error('npm')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
      @enderror
    </div>

    <!-- Bukti SIKA (File Upload) -->
    <div class="mt-4">
      <label for="bukti_npm" class="block text-sm font-medium text-gray-800 mb-2">Bukti SIKA</label>
      <p class="text-xs text-gray-500 mb-2">Unggah foto/SS SIKA yang sesuai untuk klaim tiket</p>
      <input
        type="file"
        id="bukti_npm"
        name="bukti_npm"
        accept=".jpg,.jpeg,.png,.webp,.pdf"
        required
        class="w-full rounded-md border-gray-300 shadow-sm px-4 py-3"
      >
      @error('bukti_npm')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
      @enderror
    </div>

    <!-- Actions Section -->
    <div class="mt-6 flex justify-between items-center">
      <button
        type="submit"
        class="inline-flex items-center rounded-md bg-blue-600 px-8 py-3 font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
      >
        Claim Tiket
      </button>
      <a href="{{ route('ticket.show') }}" class="text-sm text-blue-600 hover:underline">
        Lihat tiket saya
      </a>
    </div>
  </form>
</div>
@endsection
