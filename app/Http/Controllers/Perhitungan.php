<?php

namespace App\Http\Controllers;

use App\Models\AspekModel;
use App\Models\AspekNilai;
use App\Models\HitungModel;
use App\Models\NilaiUtama;
use Illuminate\Http\Request;

class Perhitungan extends Controller
{
    public function index(string $id_nilai)
    {
        $peg = AspekNilai::leftJoin('tbl_pegawai', 'tbl_pegawai.id_pegawai', '=', 'tbl_aspek_nilai_pegawai.id_pegawai')
            ->leftJoin('ref_skpd', 'ref_skpd.id_skpd', '=', 'tbl_pegawai.id_skpd')
            ->leftJoin('ref_jabatan', 'ref_jabatan.id_jabatan', '=', 'tbl_pegawai.id_jabatan')
            ->leftJoin('tbl_perhitungan', function ($join) {
                $join->on('tbl_perhitungan.id_pegawai', '=', 'tbl_aspek_nilai_pegawai.id_pegawai')
                    ->on('tbl_perhitungan.id_target', '=', 'tbl_aspek_nilai_pegawai.id_target');
            })
            ->leftJoin('tbl_jab_target', 'tbl_aspek_nilai_pegawai.id_target', '=', 'tbl_jab_target.id_target')
            ->leftJoin('ref_jabatan as jab', 'jab.id_jabatan', '=', 'tbl_jab_target.id_jabatan')
            ->selectRaw('jab.id_eselon as eselon_target,jab.jabatan as jabatan_target,tbl_aspek_nilai_pegawai.id_nilai as id_nilai,tbl_pegawai.id_pegawai as id_pegawai,tbl_pegawai.nama_pegawai as nama, ref_skpd.skpd as skpd, ref_jabatan.jabatan as jabatan,tbl_perhitungan.potensial_x as potensial,tbl_perhitungan.kinerja_y as kinerja')
            ->where('tbl_aspek_nilai_pegawai.id_nilai', '=', $id_nilai)
            ->get();


        $hasil = AspekNilai::where('tbl_aspek_nilai_pegawai.id_nilai', '=', $id_nilai)
            ->get();

        //Nilai x Potensial
        $data = NilaiUtama::where('sumbu', '=', 1)
            ->orderBy('id', 'ASC')->get();

        $tk_3 = AspekModel::where('id_indikator', '=', 3)
            ->orderBy('id_aspek', 'ASC')->get();

        $tk_4 = AspekModel::where('id_indikator', '=', 4)
            ->orderBy('id_aspek', 'ASC')->get();

        $tk_5 = AspekModel::where('id_indikator', '=', 5)
            ->orderBy('id_aspek', 'ASC')->get();

        $tk_6 = AspekModel::where('id_indikator', '=', 6)
            ->orderBy('id_aspek', 'ASC')->get();

        $tk_7 = AspekModel::where('id_indikator', '=', 7)
            ->orderBy('id_aspek', 'ASC')->get();

        $tk_8 = AspekModel::where('id_indikator', '=', 8)
            ->orderBy('id_aspek', 'ASC')->get();

        $tk_9 = AspekModel::where('id_indikator', '=', 9)
            ->orderBy('id_aspek', 'ASC')->get();

        //Nilai y Kinerja
        $datay = NilaiUtama::where('sumbu', '=', 2)
            ->orderBy('id', 'ASC')->get();

        $tk_10 = AspekModel::where('id_indikator', '=', 10)
            ->orderBy('id_aspek', 'ASC')->get();

        $tk_11 = AspekModel::where('id_indikator', '=', 11)
            ->orderBy('id_aspek', 'ASC')->get();

        $tk_12 = AspekModel::where('id_indikator', '=', 12)
            ->orderBy('id_aspek', 'ASC')->get();

        $tk_13 = AspekModel::where('id_indikator', '=', 13)
            ->orderBy('id_aspek', 'ASC')->get();


        $title = 'Data Penilaian';

        return view(view: 'datainput', data: compact('title', 'peg', 'data', 'hasil', 'tk_3', 'tk_4', 'tk_5', 'tk_6', 'tk_7', 'tk_8', 'tk_9', 'tk_10', 'tk_11', 'tk_12', 'tk_13', 'datay'));
    }

    public function index2() {}
}
