<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AspekModel;
use App\Models\KompetensiModel;
use App\Models\PegawaiData;
use Illuminate\Http\Request;

class KompetensiController extends Controller
{
    public function index()
    {
        $pegawais = collect([]);

        $title = 'Kompetensi';
        return view(view: 'kompetensi', data: compact('title', 'pegawais'));
    }

    public function filterPegKomp(Request $request)
    {
        $nampeg = $request->input('nampeg');
        $nip = $request->input('nip');
        $skpd = $request->input('skpd');
        $jabatan = $request->input('jabatan');

        if ($nampeg == null && $nip == null && $skpd == null && $jabatan == null) {
            return redirect('/kompetensi')->with('error', 'Silakan isi minimal satu filter untuk mencari pegawai.');
        } else {

            $pegawais = PegawaiData::leftJoin('ref_skpd', 'ref_skpd.id_skpd', '=', 'tbl_pegawai.id_skpd')
                ->leftJoin('ref_jabatan', 'ref_jabatan.id_jabatan', '=', 'tbl_pegawai.id_jabatan')
                ->where(function ($query) use ($nampeg, $nip, $skpd, $jabatan) {
                    if ($nampeg != null) {
                        $query->where('tbl_pegawai.nama_pegawai', 'like', '%' . $nampeg . '%');
                    }
                    if ($nip != null) {
                        $query->where('tbl_pegawai.nip', 'like', '%' . $nip . '%');
                    }
                    if ($skpd != null) {
                        $query->where('ref_skpd.skpd', 'like', '%' . $skpd . '%');
                    }
                    if ($jabatan != null) {
                        $query->where('jabatan', 'like', '%' . $jabatan . '%');
                    }
                })->get();


            $title = 'Kompetensi';
            return view(view: 'kompetensi', data: compact('title', 'pegawais'));
        }
    }

    public function KompetensiPegawai(string $id_pegawai)
    {
        $kompetensi = KompetensiModel::where('id_pegawai', $id_pegawai)->get();
        $pegawai = PegawaiData::leftJoin('ref_skpd', 'ref_skpd.id_skpd', '=', 'tbl_pegawai.id_skpd')
            ->leftJoin('ref_jabatan', 'ref_jabatan.id_jabatan', '=', 'tbl_pegawai.id_jabatan')
            ->find($id_pegawai);

        return view('kompeg', [
            'title' => 'Kompetensi Pegawai',
            'data' => $kompetensi,
            'pegawai' => $pegawai
        ]);
    }

    public function tambahKompetensi(string $id_pegawai, string $id_kompeg)
    {
        $aspek = AspekModel::where('id_indikator', 1)->get();
        $pegawai = PegawaiData::leftJoin('ref_skpd', 'ref_skpd.id_skpd', '=', 'tbl_pegawai.id_skpd')
            ->leftJoin('ref_jabatan', 'ref_jabatan.id_jabatan', '=', 'tbl_pegawai.id_jabatan')
            ->find($id_pegawai);

        $datakompeg = KompetensiModel::find($id_kompeg);


        return view('tambahkompeg', [
            'title' => 'Tambah Kompetensi Pegawai',
            'id_pegawai' => $id_pegawai,
            'aspek' => $aspek,
            'pegawai' => $pegawai,
            'data' => $datakompeg,
            'id_kompeg' => $id_kompeg

        ]);
    }

    public function inputKompeg(Request $request)
    {
        $nilai_max = 2;
        $level_eselon = $request->input('level_eselon');
        if ($level_eselon == 2) {
            $nilai_max = 4;
        } elseif ($level_eselon == 3) {
            $nilai_max = 3;
        } elseif ($level_eselon == 4) {
            $nilai_max = 2;
        }
        echo $nilai_max;

        $aspek = AspekModel::where('id_indikator', 1)->get();

        $validate_array = [
            'id_pegawai' => 'required|numeric',
            'level_eselon' => 'required|numeric'
        ];

        foreach ($aspek as $asp) {
            $validate_array['nilai_' . $asp->id_aspek] = 'required|numeric|min:0|max:' . $nilai_max;
        }

        $request->validate($validate_array);

        if ($request->input('id_kompeg') > 0) {
            $komp = KompetensiModel::find($request->input('id_kompeg'));
            if ($komp) {
                $komp->update([
                    'level_eselon' => $level_eselon,
                    'aspek_1' => $request->input('nilai_1'),
                    'aspek_2' => $request->input('nilai_2'),
                    'aspek_3' => $request->input('nilai_3'),
                    'aspek_4' => $request->input('nilai_4'),
                    'aspek_5' => $request->input('nilai_5'),
                    'aspek_6' => $request->input('nilai_6'),
                    'aspek_7' => $request->input('nilai_7'),
                    'aspek_8' => $request->input('nilai_8'),
                    'aspek_9' => $request->input('nilai_9')
                ]);

                $message = 'Kompetensi pegawai berhasil diperbarui.';
            }
        } else {
            KompetensiModel::create([
                'id_pegawai' => $request->input('id_pegawai'),
                'level_eselon' => $level_eselon,
                'aspek_1' => $request->input('nilai_1'),
                'aspek_2' => $request->input('nilai_2'),
                'aspek_3' => $request->input('nilai_3'),
                'aspek_4' => $request->input('nilai_4'),
                'aspek_5' => $request->input('nilai_5'),
                'aspek_6' => $request->input('nilai_6'),
                'aspek_7' => $request->input('nilai_7'),
                'aspek_8' => $request->input('nilai_8'),
                'aspek_9' => $request->input('nilai_9')
            ]);

            $message = 'Kompetensi pegawai berhasil ditambahkan.';
        }

        return redirect()->route('kompeg', ['id' => $request->input('id_pegawai')])
            ->with('message', $message);
    }

    public function hapusKompeg(string $id_pegawai, string $id_komp)
    {
        $komp = KompetensiModel::find($id_komp);
        if ($komp) {
            $komp->delete();
            return redirect()->route('kompeg', ['id' => $id_pegawai])
                ->with('message', 'Kompetensi pegawai berhasil dihapus.');
        } else {
            return redirect()->route('kompeg', ['id' => $id_pegawai])
                ->with('error', 'Kompetensi pegawai tidak ditemukan.');
        }
    }
}
