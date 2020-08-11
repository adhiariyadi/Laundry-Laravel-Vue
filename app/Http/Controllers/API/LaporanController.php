<?php

namespace App\Http\Controllers\API;

use App\Models\Kas;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Resources\KasResource;
use App\Http\Controllers\Controller;

class LaporanController extends Controller
{
    public function kas()
    {
        return new KasResource(['kas' => Kas::orderBy('id', 'desc')->get(), 'saldo' => Setting::where('name', 'saldo')->first()]);
    }
}
