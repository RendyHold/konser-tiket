@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container mx-auto max-w-xl p-4">
    <h1 class="text-2xl font-bold mb-4">Scanner Tiket (Petugas/Admin)</h1>

    <div id="reader" style="width:100%; max-width: 520px; margin-bottom: 16px;"></div>

    <div class="flex gap-2 mb-4">
        <select id="cameraSelect" class="border rounded px-2 py-1"></select>
        <button id="startBtn" class="bg-blue-600 text-white px-3 py-1 rounded">Mulai Scan</button>
        <button id="stopBtn" class="bg-gray-600 text-white px-3 py-1 rounded" disabled>Stop</button>
    </div>

    <div id="result" class="p-3 border rounded bg-gray-50 hidden"></div>
</div>

<script src="https://unpkg.com/html5-qrcode" defer></script>
<script>
document.addEventListener('DOMContentLoaded', async () => {
    const startBtn=document.getElementById('startBtn');
    const stopBtn=document.getElementById('stopBtn');
    const cameraSel=document.getElementById('cameraSelect');
    const resultBox=document.getElementById('result');
    let qr, cameraId=null;
    const csrf=document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function msg(t, ok=true){
        resultBox.classList.remove('hidden');
        resultBox.style.borderColor = ok ? '#16a34a' : '#dc2626';
        resultBox.style.background  = ok ? '#ecfdf5' : '#fef2f2';
        resultBox.textContent = t;
    }

    async function loadCams(){
        try{
            const devices = await Html5Qrcode.getCameras();
            cameraSel.innerHTML='';
            if(!devices?.length){ cameraSel.innerHTML='<option>Tidak ada kamera</option>'; startBtn.disabled=true; return; }
            devices.forEach((d,i)=>{
                const o=document.createElement('option'); o.value=d.id; o.textContent=d.label||`Kamera ${i+1}`; cameraSel.appendChild(o);
            });
            cameraId=devices[0].id;
        }catch(e){ msg('Gagal mendeteksi kamera: '+e.message,false); startBtn.disabled=true; }
    }
    await loadCams();

    cameraSel.addEventListener('change', e=>cameraId=e.target.value);

    async function start(){
        try{
            if(!cameraId) return msg('Kamera tidak tersedia.', false);
            qr = new Html5Qrcode('reader');
            await qr.start({deviceId:{exact:cameraId}}, {fps:10, qrbox:{width:260, height:260}},
                onSuccess, ()=>{});
            startBtn.disabled=true; stopBtn.disabled=false;
            msg('Scanner aktif. Arahkan kamera ke barcode/QR...');
        }catch(e){ msg('Tidak bisa memulai kamera: '+e.message,false); }
    }

    async function stop(){
        try{
            if(qr){ await qr.stop(); await qr.clear(); qr=null; }
            startBtn.disabled=false; stopBtn.disabled=true;
            msg('Scanner dihentikan.');
        }catch(e){ msg('Gagal menghentikan scanner: '+e.message,false); }
    }

    async function onSuccess(text){
        await stop();
        msg('Kode terbaca: '+text+' — memverifikasi...');
        try{
            const res = await fetch("{{ route('ticket.verifyScan') }}",{
                method:'POST',
                headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrf,'Accept':'application/json'},
                body: JSON.stringify({ code: text })
            });
            const json = await res.json();
            if(res.ok && json.ok){
                msg('✅ '+json.message + (json.ticket?.owner ? (' — Pemilik: '+json.ticket.owner) : ''));
            }else{
                msg('❌ '+(json.message||'Kode tidak valid'), false);
            }
        }catch(e){ msg('Terjadi kesalahan jaringan: '+e.message,false); }
    }

    startBtn.addEventListener('click', start);
    stopBtn.addEventListener('click', stop);
});
</script>
@endsection
