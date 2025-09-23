{{-- resources/views/admin/tickets/show.blade.php --}}
<h2>Ticket: {{ $ticket->code }}</h2>

<p>Status: <strong>{{ $ticket->status }}</strong></p>
<p>NPM: {{ $ticket->npm }}</p>
<p>Invoice: {{ $ticket->invoice_no }}</p>

<div class="mt-3">
  <div>Bukti SIAK:
    @if($ticket->npm_proof_path)
      <a href="{{ asset('storage/'.$ticket->npm_proof_path) }}" target="_blank">Lihat</a>
    @endif
  </div>
  <div>Bukti Pembayaran:
    @if($ticket->payment_proof_path)
      <a href="{{ asset('storage/'.$ticket->payment_proof_path) }}" target="_blank">Lihat</a>
    @endif
  </div>
</div>

@if($ticket->status === 'pending')
  <form action="{{ route('admin.tickets.approve',$ticket) }}" method="post" class="inline-block">
    @csrf
    <button class="bg-green-600 text-white px-4 py-2 rounded">Approve & Generate</button>
  </form>

  <form action="{{ route('admin.tickets.reject',$ticket) }}" method="post" class="inline-block ml-2">
    @csrf
    <input type="text" name="reason" placeholder="Alasan reject" class="border px-2 py-1" required>
    <button class="bg-red-600 text-white px-4 py-2 rounded">Reject</button>
  </form>
@endif

@if($ticket->status === 'issued')
  <div class="mt-3">
    <a class="text-blue-600 underline" href="{{ asset($ticket->barcode_path) }}" download>Download Tiket Final</a>
  </div>
@endif
