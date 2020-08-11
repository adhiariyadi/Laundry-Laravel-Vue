<?php

namespace App\Http\Controllers\API;

use App\Models\Room;
use App\Models\Cucian;
use App\Models\Antrian;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoomResource;
use App\Models\Member;
use App\Models\Promo;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new RoomResource(Room::with(['antrian.member', 'antrian.cucian', 'operator'])->orderBy('id', 'desc')->where('status', '!=', 'selesai')->paginate(10));
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
            'category' => 'required',
            'qty' => 'required'
        ]);

        $category = Category::find($request->category);

        Cucian::create([
            'antrian_id' => $request->antrian,
            'category_id' => $category->id,
            'harga' => $category->harga,
            'quantity' => $request->qty,
            'total' => $category->harga * $request->qty,
        ]);

        Antrian::find($request->antrian)->update(['status' => "cuci"]);
        $room = Room::where('antrian_id', $request->antrian)->first();
        $room->update([
            'status' => "cuci",
            'total' => $room->total + ($category->harga * $request->qty)
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
        return response(['room' => Room::with(['antrian.member', 'antrian.cucian.category', 'operator'])->where('antrian_id', $id)->first(), 'category' => Category::all()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $huruf = "QWERTYUIOPLKJHGFDSAZXCVBNM";
        $angka = "1234567890";
        $kode  = substr(str_shuffle($huruf), 0, 2) . substr(str_shuffle($angka), 0, 2);
        return response(['room' => Room::with(['antrian.member.level', 'antrian.cucian.category', 'operator'])->where('antrian_id', $id)->first(), 'kode' => $kode]);
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

    public function selesai(Request $request)
    {
        $request->validate([
            'antrian' => 'required',
        ]);

        Antrian::find($request->antrian)->update(['selesai' => date('Y-m-d H:i:s'), 'status' => "selesai"]);
        $room = Room::where('antrian_id', $request->antrian)->first();
        $room->update(['status' => "selesai"]);

        return response(['success' => true], 200);
    }

    public function ambil(Request $request)
    {
        $request->validate([
            'antrian' => 'required',
        ]);

        $antrian = Antrian::with(['member.level'])->find($request->antrian);
        Member::find($antrian->member_id)->update(['point' => $antrian->member->point + $antrian->member->level->point]);
        $antrian->update(['ambil' => date('Y-m-d H:i:s')]);

        return response(['success' => true], 200);
    }

    public function promo(Request $request)
    {
        $promo = Promo::where('kode', strtoupper($request->kode))->first();

        if ($promo == true) {
            return response(['status' => "success", 'promo' => $promo]);
        } else {
            return response(['status' => "error"]);
        }
    }

    public function kembali(Request $request)
    {
        if ($request->bayar >= $request->total) {
            $kembalian = $request->bayar - $request->total;
            return response(['status' => "success", 'kembali' => $kembalian]);
        } else {
            return response(['status' => "error"]);
        }
    }
}
