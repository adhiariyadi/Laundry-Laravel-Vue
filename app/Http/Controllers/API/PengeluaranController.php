<?php

namespace App\Http\Controllers\API;

use App\Models\Kas;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\PengeluaranResource;

class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new PengeluaranResource(Pengeluaran::orderBy('id', 'desc')->paginate(10));
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
            'description' => 'required',
            'jumlah' => 'required',
        ]);

        $huruf = "QWERTYUIOPLKJHGFDSAZXCVBNM";
        $kode  = substr(str_shuffle($huruf), 0, 2) . substr(rand(0, 9), 0, 1) . substr(str_shuffle($huruf), 0, 1);

        Pengeluaran::create([
            'invoice' => "INV-" . date("Y-m-d") . "-" . $kode,
            'description' => $request->description,
            'jumlah' => $request->jumlah,
            'operator' => Auth::user()->id,
        ]);

        $kas = Kas::get()->sum('jumlah');

        Kas::create([
            'invoice' => "INV-" . date("Y-m-d") . "-" . $kode,
            'description' => "Pengeluaran untuk " . $request->description,
            'ket' => "Keluar",
            'jumlah' => $request->jumlah,
            'saldo' => $kas - ($request->jumlah)
        ]);

        return response(['success' => true], 200);
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
