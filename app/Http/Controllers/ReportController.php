<?php

namespace App\Http\Controllers;

use App\Models\AspekModel;
use App\Models\AspekNilai;
use App\Models\HitungModel;
use App\Models\Indikator;
use App\Models\JabTargetModel;
use App\Models\NilaiTalenta;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $target = JabTargetModel::leftJoin('ref_jabatan', 'ref_jabatan.id_jabatan', '=', 'tbl_jab_target.id_jabatan')
            ->selectRaw('ref_jabatan.jabatan as jabatan,tbl_jab_target.id_target as id_target,DATE(tbl_jab_target.created_at) as tanggal')
            ->get();

        return view('report.ninebox', [
            'title' => 'NineBox',
            'target' => $target

        ]);
    }

    public function HitungTalenta(string $id_peg_nilai, string $id_target)
    {
        //cek eselon jabatan target
        $esel_target = JabTargetModel::leftJoin('ref_jabatan', 'ref_jabatan.id_jabatan', '=', 'tbl_jab_target.id_jabatan')
            ->select('ref_jabatan.id_eselon')
            ->where('tbl_jab_target.id_target', '=', $id_target)
            ->pluck('id_eselon')->first();

        if ($id_peg_nilai > 0) {
            $nilai = AspekNilai::where('id_nilai', '=', $id_peg_nilai)->get();
        } elseif ($id_peg_nilai == 0) {
            $nilai = AspekNilai::where('id_target', '=', $id_target)->get();
        }

        $bobot = Indikator::get();
        foreach ($bobot as $bb) {
            ${'bobot_' . $bb->id_indikator} = $bb->bobot;
        }

        foreach ($nilai as $nilaipeg) {
            //hitung aspek indikator_1
            //untuk level 2
            if ($esel_target == 3 || $esel_target == 4) {
                $skj_poin = AspekModel::where('id_indikator', '=', 1)
                    ->sum('leveselon_2');
            } elseif ($esel_target == 5 || $esel_target == 6) {
                $skj_poin = AspekModel::where('id_indikator', '=', 1)
                    ->sum('leveselon_3');
            } elseif ($esel_target == 7 || $esel_target == 8) {
                $skj_poin = AspekModel::where('id_indikator', '=', 1)
                    ->sum('skj_poin');
            }

            $total_aspek = 0;
            for ($i = 1; $i <= 9; $i++) {
                $total_aspek += $nilaipeg->{'aspek_' . $i};
            }
            $ntotal = 0;
            $ntotal = $total_aspek * 100 / $skj_poin;
            $ntalenta1 = $ntotal * $bobot_1;

            //Indikator_2 s.d 13
            $ind3 = Indikator::where('id_utama', '>=', 2)->get();
            //$m = 2;
            foreach ($ind3 as $nilaind3) {
                $m = $nilaind3->id_indikator;
                ${'bobots_' . $nilaind3->id_indikator} = $nilaind3->bobot;
                if ($m != 2 && $m != 7 && $m != 12 && $m <= 13) {
                    $tingkat = AspekModel::find($nilaipeg->{'indikator_' . $m});
                    $nakhir = 0;
                    $nakhir = ($tingkat->skj_poin) * ${'bobots_' . $m};
                    ${'ntalenta' . $m} = $nakhir;
                } else {
                    //Indikator_2 & 7 & 12
                    ${'ntalenta' . $m} = number_format(${'bobot_' . $m} * $nilaipeg->{'indikator_' . $m}, 2);
                }
                //$m++;
            }

            //Masukkan ke database penilaian
            $ceknilai = NilaiTalenta::where([
                ['id_pegawai', '=', $nilaipeg->id_pegawai],
                ['id_target', '=', $nilaipeg->id_target]
            ]);

            if ($ceknilai->count() >= 1) {
                $ids = $ceknilai->first();

                $update = NilaiTalenta::find($ids->id);
                $update->id_pegawai = $nilaipeg->id_pegawai;
                $update->ind_1 = $ntalenta1;
                $update->ind_2 = $ntalenta2;
                $update->ind_3 = $ntalenta3;
                $update->ind_4 = $ntalenta4;
                $update->ind_5 = $ntalenta5;
                $update->ind_6 = $ntalenta6;
                $update->ind_7 = $ntalenta7;
                $update->ind_8 = $ntalenta8;
                $update->ind_9 = $ntalenta9;
                $update->ind_10 = $ntalenta10;
                $update->ind_11 = $ntalenta11;
                $update->ind_12 = $ntalenta12;
                $update->ind_13 = $ntalenta13;

                $update->save();
            } else {

                $ins = new NilaiTalenta();
                $ins->id_target = $nilaipeg->id_target;
                $ins->id_pegawai = $nilaipeg->id_pegawai;
                $ins->ind_1 = $ntalenta1;
                $ins->ind_2 = $ntalenta2;
                $ins->ind_3 = $ntalenta3;
                $ins->ind_4 = $ntalenta4;
                $ins->ind_5 = $ntalenta5;
                $ins->ind_6 = $ntalenta6;
                $ins->ind_7 = $ntalenta7;
                $ins->ind_8 = $ntalenta8;
                $ins->ind_9 = $ntalenta9;
                $ins->ind_10 = $ntalenta10;
                $ins->ind_11 = $ntalenta11;
                $ins->ind_12 = $ntalenta12;
                $ins->ind_13 = $ntalenta13;

                $ins->save();
            }

            $indx = Indikator::leftJoin('tbl_nilai_utama', 'tbl_nilai_utama.id', '=', 'tbl_indikator.id_utama')
                ->selectRaw('tbl_indikator.id_indikator as id_indikator')
                ->where('tbl_nilai_utama.sumbu', '=', 1)
                ->get();

            $nilai_x = 0;
            foreach ($indx as $inx) {
                $nilai_x += ${'ntalenta' . $inx->id_indikator};
            }


            $indy = Indikator::leftJoin('tbl_nilai_utama', 'tbl_nilai_utama.id', '=', 'tbl_indikator.id_utama')
                ->selectRaw('tbl_indikator.id_indikator as id_indikator')
                ->where('tbl_nilai_utama.sumbu', '=', 2)
                ->get();

            $nilai_y = 0;
            foreach ($indy as $iny) {
                $nilai_y += ${'ntalenta' . $iny->id_indikator};
            }

            //Masukkan ke tbl_perhitungan
            $final = HitungModel::where([
                ['id_pegawai', '=', $nilaipeg->id_pegawai],
                ['id_target', '=', $nilaipeg->id_target]
            ]);
            if ($final->count() == 1) {
                $idy = $final->first();
                //update
                $finup = HitungModel::find($idy->id);
                $finup->id_pegawai = $nilaipeg->id_pegawai;
                $finup->potensial_x = $nilai_x;
                $finup->kinerja_y = $nilai_y;
                $finup->save();
            } else {
                //insert
                $fin = new HitungModel();
                $fin->id_pegawai = $nilaipeg->id_pegawai;
                $fin->id_target = $nilaipeg->id_target;
                $fin->potensial_x = $nilai_x;
                $fin->kinerja_y = $nilai_y;
                $fin->save();
            }
        }
    }

    public function getData(Request $request) //laporan keseluruhan
    {
        $id_target = $request->id_target;
        $id_seleksi = $request->id_seleksi;

        //ambil id_eselon jabatan target
        $jabeselon = JabTargetModel::leftJoin('ref_jabatan', 'ref_jabatan.id_jabatan', '=', 'tbl_jab_target.id_jabatan')
            ->selectRaw('ref_jabatan.id_eselon,tbl_jab_target.id_target')
            ->where('tbl_jab_target.id_target', '=', $id_target)
            ->pluck('id_eselon')->first();

        $this->HitungTalenta(0, $id_target);
        $cek = HitungModel::leftJoin('tbl_pegawai', 'tbl_pegawai.id_pegawai', '=', 'tbl_perhitungan.id_pegawai')
            ->leftJoin('ref_jabatan', 'ref_jabatan.id_jabatan', '=', 'tbl_pegawai.id_jabatan')
            ->where('tbl_perhitungan.id_target', '=', $id_target)
            ->where(function ($query) use ($jabeselon, $id_seleksi) {
                if ($id_seleksi == 0) {
                    //no filter
                }
                if ($id_seleksi == 1) {
                    $query->where('ref_jabatan.id_eselon', '<=', $jabeselon)
                        ->where('ref_jabatan.id_eselon', '!=', 0);
                }
                if ($id_seleksi == 2) {
                    $query->where('ref_jabatan.id_eselon', '>', $jabeselon)
                        ->orwhere('ref_jabatan.id_eselon', '=', 0);
                }
            })
            ->get();

        if ($cek->count() >= 1) {
            return response()->json([
                'xValue' => $cek->pluck('potensial_x'),
                'yValue' => $cek->pluck('kinerja_y'),
                'labels' => $cek->pluck('nama_pegawai'),
                'total' => $cek->count()
            ]);
        }
    }
}
