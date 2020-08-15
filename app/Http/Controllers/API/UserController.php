<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return new UserResource(User::where('name', 'LIKE', "%$request->search%")->orderBy('level')->paginate(10));
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
        if ($request->password == true) {
            $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|min:6',
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:8',
                'level' => 'required|in:Admin,Operator',
            ]);
        } else {
            $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|min:6',
                'email' => 'required|string|email|max:255',
                'level' => 'required|in:Admin,Operator',
            ]);
        }

        if ($request->hasFile('image') == true) {
            $image = $request->file('image');
            $namaImage = $image->getClientOriginalName();
            $foto = explode('.', $namaImage);
            $foto = end($foto);
            $newImage = date('siHdmY') . '.' . $foto;
            $image->move('images/item/', $newImage);
            $saveImage = 'images/item/' . $newImage;
        } else {
            $saveImage = $request->image;
        }

        if ($request->id == true) {
            if ($request->password == true) {
                $dataUser = [
                    'name' => $request->name,
                    'password' => Hash::make($request->password),
                    'level' => $request->level,
                    'image' => $saveImage,
                ];
            } else {
                $dataUser = [
                    'name' => $request->name,
                    'level' => $request->level,
                    'image' => $saveImage,
                ];
            }
        } else {
            $username = User::where('username', $request->username)->count();
            $email = User::where('email', $request->email)->count();
            if ($username > 0) {
                return response(['status' => "username sudah terdaftar"], 200);
            } elseif ($email > 0) {
                return response(['status' => "email sudah terdaftar"], 200);
            } else {
                $dataUser = [
                    'name' => $request->name,
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'level' => $request->level,
                    'image' => $saveImage,
                ];
            }
        }

        User::UpdateOrCreate(['id' => $request->id], $dataUser);

        return response(['status' => true], 200);
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
        return User::findOrFail($id);
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
        User::find($id)->delete();
        return response(['success' => true], 200);
    }
}
