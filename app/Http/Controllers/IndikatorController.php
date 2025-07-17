<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Indikator;
use App\Models\NilaiUtama;
use Illuminate\Http\Request;

class IndikatorController extends Controller
{
    public function index()
    {
        return view('indikator', [
            'title' => 'Indikator',
            'penilaian' => NilaiUtama::all(),
            'indikator_1' => Indikator::where('id_utama', 1)->get(),
            'indikator_2' => Indikator::where('id_utama', 2)->get(),
            'indikator_3' => Indikator::where('id_utama', 3)->get(),
            'indikator_4' => Indikator::where('id_utama', 4)->get(),
            'indikator_5' => Indikator::where('id_utama', 5)->get(),
            'indikator_6' => Indikator::where('id_utama', 6)->get()

        ]);
    }

    public function editIndikator(Request $request)
    {
        $nutama = NilaiUtama::all();
        foreach ($nutama as $utama) {
            $validate_array['bobot_' . $utama->id] = 'required|numeric';
        }
        $request->validate($validate_array);


        //hitung total nilai pada sumbu
        $total_sumbux = 0;
        $total_sumbuy = 0;
        foreach ($nutama as $ceknilai) {
            $sumbu = $request->input('sumbu_' . $ceknilai->id);
            if ($sumbu == 1) {
                $total_sumbux += $request->input('bobot_' . $ceknilai->id);
            } elseif ($sumbu == 2) {
                $total_sumbuy += $request->input('bobot_' . $ceknilai->id);
            }
        }

        //simpan di database
        foreach ($nutama as $uupdate) {
            $utama = NilaiUtama::find($uupdate->id);
            if (!$utama) {
                return redirect()->back()->with('error', 'Nilai Utama tidak ditemukan');
            } else {
                $utama->update([
                    'bobot' => $request->input('bobot_' . $utama->id),
                    'sumbu' => $request->input('sumbu_' . $utama->id)
                ]);
            }
        }

        return redirect()->back()->with('success', 'Indikator berhasil diperbarui.');
    }
}
