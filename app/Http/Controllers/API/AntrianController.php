<?php

namespace App\Http\Controllers\API;

use App\Models\Member;
use App\Models\Antrian;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AntrianResource;
use Illuminate\Support\Facades\Auth;

class AntrianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new AntrianResource(['antrian' => Antrian::with(['member', 'operator'])->orderBy('id', 'desc')->where('date', date('Y-m-d'))->paginate(10), 'member' => Member::all()]);
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
            'member' => 'required',
        ]);

        Antrian::Create([
            'member_id' => $request->member,
            'date' => date('Y-m-d'),
            'pembayaran' => "pending",
            'operator' => Auth::user()->id,
            'status' => "hold",
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
        return Antrian::with(['member', 'operator'])->findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Antrian::with(['member', 'operator'])->findOrFail($id);
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
        Antrian::find($id)->delete();
        return response(['success' => true], 200);
    }
}
