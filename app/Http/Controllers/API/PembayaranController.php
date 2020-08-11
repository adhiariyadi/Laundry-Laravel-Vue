<?php

namespace App\Http\Controllers\API;

use App\Models\Kas;
use App\Models\Promo;
use App\Models\Antrian;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'antrian' => 'required',
            'kode' => 'required',
        ]);

        $antrian = Antrian::with(['room', 'member.level', 'cucian.category'])->find($request->antrian);
        $promo = Promo::where('kode', strtoupper($request->promo))->first();

        if ($promo) {
            $discount = ($antrian->room->total * $antrian->member->level->discount / 100) + (($antrian->room->total - ($antrian->room->total * $antrian->member->level->discount / 100)) * $promo->discount / 100);
        } else {
            $discount = ($antrian->room->total * $antrian->member->level->discount / 100);
        }

        Pembayaran::create([
            'invoice' => "INV-$antrian->date-$request->kode",
            'antrian_id' => $antrian->id,
            'waktu' => date('Y-m-d H:i:s'),
            'jumlah_cuci' => $antrian->cucian->count(),
            'harga' => $antrian->room->total,
            'discount' => $discount,
            'total' => $antrian->room->total - $discount,
            'bayar' => $request->bayar,
            'kembali' => $request->bayar - ($antrian->room->total - $discount),
            'payment_method' => "Uang Cash",
            'operator' => Auth::user()->id,
        ]);

        $antrian->update(['pembayaran' => "selesai"]);

        $kas = Kas::get()->sum('jumlah');

        Kas::create([
            'invoice' => "INV-$antrian->date-$request->kode",
            'description' => "Pembayaran Cucian",
            'ket' => "Masuk",
            'jumlah' => $antrian->room->total - $discount,
            'saldo' => $kas + ($antrian->room->total - $discount)
        ]);

        return response(['success' => true, 'antrian' => $antrian], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
