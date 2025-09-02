<?php

namespace App\Http\Controllers;

use App\Models\Acara;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AcaraController extends Controller
{
    public function index()
    {
        $list = Acara::orderBy("tanggal")->paginate(15);
        return view("acara.index", compact("list"));
    }

    public function create()
    {
        return view("acara.create");
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            "nama"    => "required|string|max:150",
            "tanggal" => "required|date", // dari input datetime-local
            "lokasi"  => "nullable|string|max:150",
            "kuota"   => "nullable|integer|min:0",
        ]);
        $data["tanggal"] = Carbon::parse($data["tanggal"]);
        $data["kuota"]   = $data["kuota"] ?? 0;

        Acara::create($data);
        return redirect()->route("acara.index")->with("ok","Acara dibuat");
    }

    public function edit(Acara $acara)
    {
        return view("acara.edit", compact("acara"));
    }

    public function update(Request $r, Acara $acara)
    {
        $data = $r->validate([
            "nama"    => "required|string|max:150",
            "tanggal" => "required|date",
            "lokasi"  => "nullable|string|max:150",
            "kuota"   => "nullable|integer|min:0",
        ]);
        $data["tanggal"] = Carbon::parse($data["tanggal"]);
        $data["kuota"]   = $data["kuota"] ?? 0;

        $acara->update($data);
        return redirect()->route("acara.index")->with("ok","Acara diperbarui");
    }

    public function destroy(Acara $acara)
    {
        $acara->delete();
        return back()->with("ok","Acara dihapus");
    }
}
