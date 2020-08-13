<?php

namespace App\Http\Controllers\API;

use App\Models\Kas;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Resources\KasResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\LaporanResource;

class LaporanController extends Controller
{
    public function kas()
    {
        return new KasResource(['kas' => Kas::orderBy('id', 'desc')->get(), 'saldo' => Setting::where('name', 'saldo')->first()]);
    }

    public function tahun()
    {
        $tahun = Kas::orderBy('id', 'desc')
            ->paginate(10)
            ->groupBy(function ($val) {
                return Carbon::parse($val->created_at)->format('Y');
            });
        foreach ($tahun as $val) {
            $data[] = array(
                'value' => date('Y', strtotime($val[0]->created_at)),
                'masuk' => $val->where('ket', 'Masuk')->count(),
                'keluar' => $val->where('ket', 'Keluar')->count(),
                'pendapatan' => $val->where('ket', 'Masuk')->sum('jumlah'),
                'pengeluaran' => $val->where('ket', 'Keluar')->sum('jumlah')
            );
        }
        return new LaporanResource($data);
    }

    public function bulan(Request $request)
    {
        $bulan = Kas::whereYear('created_at', $request->tahun)
            ->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->created_at)->format('m');
            });
        foreach ($bulan as $val) {
            $data[] = array(
                'key' => date('m', strtotime($val[0]->created_at)),
                'value' => date('F', strtotime($val[0]->created_at)),
                'masuk' => $val->where('ket', 'Masuk')->count(),
                'keluar' => $val->where('ket', 'Keluar')->count(),
                'pendapatan' => $val->where('ket', 'Masuk')->sum('jumlah'),
                'pengeluaran' => $val->where('ket', 'Keluar')->sum('jumlah')
            );
        }
        return new LaporanResource($data);
    }

    public function tanggal(Request $request)
    {
        $bulan = Kas::whereYear('created_at', $request->tahun)
            ->whereMonth('created_at', $request->bulan)
            ->paginate(11)
            ->groupBy(function ($val) {
                return Carbon::parse($val->created_at)->format('d');
            });
        foreach ($bulan as $val) {
            $data[] = array(
                'value' => date('d', strtotime($val[0]->created_at)),
                'bulan' => date('F', strtotime($val[0]->created_at)),
                'masuk' => $val->where('ket', 'Masuk')->count(),
                'keluar' => $val->where('ket', 'Keluar')->count(),
                'pendapatan' => $val->where('ket', 'Masuk')->sum('jumlah'),
                'pengeluaran' => $val->where('ket', 'Keluar')->sum('jumlah')
            );
        }
        return new LaporanResource($data);
    }

    public function detail(Request $request)
    {
        $kas = Kas::whereYear('created_at', $request->tahun)
            ->whereMonth('created_at', $request->bulan)
            ->whereDay('created_at', $request->tanggal)
            ->paginate(10);
        foreach ($kas as $val) {
            $data[] = array(
                'bulan' => date('F', strtotime($val->created_at)),
                'waktu' => date('Y-m-d H:i:s', strtotime($val->created_at)),
                'invoice' => $val->invoice,
                'ket' => $val->ket,
                'nominal' => $val->jumlah,
            );
        }
        return new LaporanResource($data);
    }
}
