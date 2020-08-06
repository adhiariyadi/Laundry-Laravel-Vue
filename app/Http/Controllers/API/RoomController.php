<?php

namespace App\Http\Controllers\API;

use App\Models\Room;
use App\Models\Cucian;
use App\Models\Antrian;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoomResource;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new RoomResource(Room::with(['antrian.member', 'operator'])->orderBy('id', 'desc')->where('status', '!=', 'selesai')->paginate(10));
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
            'qty' => 'required',
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
        $room = Room::findorfail($request->antrian);
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
        return response(['room' => Room::with(['antrian.member', 'operator'])->findOrFail($id), 'category' => Category::all(), 'cucian' => Cucian::with(['category'])->where('antrian_id', $id)->get()]);
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
