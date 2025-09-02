@extends('layouts.app')

@section('content')
<style>
/* --- Mini UI kit agar rapi tanpa framework --- */
.form-wrap{max-width:640px;margin:24px auto;padding:24px;background:#fff;border:1px solid #eaeaea;border-radius:12px;box-shadow:0 2px 10px rgba(0,0,0,.04)}
.page-head{max-width:640px;margin:0 auto 16px;display:flex;justify-content:space-between;align-items:center}
.page-head h2{font-weight:700;margin:0}
.btnx{display:inline-flex;gap:8px;align-items:center;padding:10px 16px;border-radius:10px;border:1px solid #d9d9d9;background:#f9fafb;cursor:pointer;text-decoration:none;color:#111}
.btnx:hover{background:#f1f5f9}
.btnx.primary{background:#2563eb;border-color:#2563eb;color:#fff}
.btnx.primary:hover{background:#1e4fdc}
.btnx.ghost{background:#fff}
.label{display:block;font-weight:600;margin-bottom:6px}
.input{width:100%;padding:12px 14px;border:1px solid #dcdcdc;border-radius:10px;background:#fff;outline:none}
.input:focus{border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.15)}
.row{display:flex;gap:10px}
.alert{max-width:640px;margin:0 auto 16px;padding:12px 14px;border-radius:10px;background:#ecfdf5;color:#065f46;border:1px solid #a7f3d0}
</style>

<div class="page-head">
    <h2>Tambah Scan Manual</h2>
    <a href="{{ route('admin.scans.manual') }}" class="btnx">Refresh</a>
</div>

@if(session('success'))
    <div class="alert">{{ session('success') }}</div>
@endif

<div class="form-wrap">
    <form method="POST" action="{{ route('admin.scans.manual.store') }}">
        @csrf
        <label for="code" class="label">Kode Tiket</label>
        <input type="text" name="code" id="code" class="input"
            value="{{ old('code') }}" placeholder="Masukkan kode tiket" required>

        @error('code')
            <div style="color:#b91c1c;margin-top:6px">{{ $message }}</div>
        @enderror

        <div class="row" style="margin-top:16px">
            <button type="submit" class="btnx primary">Simpan</button>
            <a href="{{ url()->previous() }}" class="btnx ghost">Batal</a>
        </div>
    </form>
</div>
@endsection
