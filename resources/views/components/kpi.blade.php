@props([
  'title' => '',
  'value' => 0,
  'icon'  => 'qr',      // qr | users | ticket | clock
  'note'  => '',
  'color' => 'indigo',  // indigo | emerald | sky | amber
])

@php
  $map = [
    'indigo'  => 'bg-indigo-50 text-indigo-600',
    'emerald' => 'bg-emerald-50 text-emerald-600',
    'sky'     => 'bg-sky-50 text-sky-600',
    'amber'   => 'bg-amber-50 text-amber-600',
  ];
  $colorClass = $map[$color] ?? $map['indigo'];
@endphp

<div {{ $attributes->merge(['class' => 'rounded-xl border bg-white p-4 shadow-sm']) }}>
  <div class="flex items-center justify-between">
    <p class="text-sm text-gray-500">{{ $title }}</p>
    <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg {{ $colorClass }}">
      @if($icon === 'users')
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
          <path d="M16 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4Zm-8 0a3 3 0 1 0-3-3 3 3 0 0 0 3 3Zm0 2a5 5 0 0 0-5 5v1h6v-1a5 5 0 0 1 2-4 6.95 6.95 0 0 0-3-1Zm8 0a7 7 0 0 0-7 7v1h14v-1a7 7 0 0 0-7-7Z"/>
        </svg>
      @elseif($icon === 'ticket')
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
          <path d="M3 7a2 2 0 0 1 2-2h6v3a2 2 0 1 0 0 4v3H5a2 2 0 0 1-2-2V7Zm16-2a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2h-6v-3a2 2 0 1 0 0-4V5h6Z"/>
        </svg>
      @elseif($icon === 'clock')
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
          <path d="M12 1a11 11 0 1 0 11 11A11.013 11.013 0 0 0 12 1Zm1 11h5v2h-7V6h2v6Z"/>
        </svg>
      @else {{-- qr (default) --}}
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
          <path d="M3 3h8v8H3V3Zm2 2v4h4V5H5Zm10 0h6v2h-6V5Zm0 4h6v2h-6V9ZM3 13h6v2H3v-2Zm0 4h6v4H3v-4Zm2 2h2v0H5Zm10-2h6v6h-2v-2h-2v2h-2v-6Zm2 2v2h2v-2h-2Zm-4-6h4v2h-4v-2Z"/>
        </svg>
      @endif
    </span>
  </div>

  <div class="mt-3 text-3xl font-semibold">{{ $value }}</div>
  @if($note)
    <div class="mt-1 text-xs text-gray-500">{{ $note }}</div>
  @endif
</div>
