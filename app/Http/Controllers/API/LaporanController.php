<?php

namespace App\Http\Controllers\API;

use App\Models\Kas;
use App\Models\Member;
use App\Models\Antrian;
use App\Models\Setting;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Resources\KasResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\LaporanResource;

class LaporanController extends Controller
{
    public function index()
    {
        $data['cucian'] = Antrian::with(['cucian'])->where('status', 'cuci')->count();
        $data['pelanggan'] = Member::count();
        $data['harian'] = Pembayaran::whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->whereDay('created_at', date('d'))
            ->get()
            ->sum('total');
        $data['bulanan'] = Pembayaran::whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->get()
            ->sum('total');
        for ($i = 0; $i < 7; $i++) {
            $data['mingguan'][$i] = array(
                'tanggal' => date('Y-m-d', strtotime("-$i day", strtotime(date("Y-m-d")))),
                'transaksi' => Pembayaran::whereYear('created_at', date('Y'))
                    ->whereMonth('created_at', date('m'))
                    ->whereDay('created_at', date('d') - $i)
                    ->count(),
                'nominal' => Pembayaran::whereYear('created_at', date('Y'))
                    ->whereMonth('created_at', date('m'))
                    ->whereDay('created_at', date('d') - $i)
                    ->get()
                    ->sum('total')
            );
        }
        $data['member'] = Member::with(['level', 'antrian'])->orderBy('point')->limit(5)->get();
        return new LaporanResource($data);
    }

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
