<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Support\DaftarApi;
use App\Models\AsesmenModel;
use App\Models\AspekModel;
use App\Models\AspekNilai;
use App\Models\HitungModel;
use App\Models\JabTargetModel;
use App\Models\KinerjaPegawai;
use App\Models\KompetensiModel;
use App\Models\NilaiTalenta;
use App\Models\PegawaiData;
use App\Models\RelasiJabPend;
use App\Models\SimpelModel;
use App\Models\SyaratJabatan;
use App\Models\SyaratPegawai;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class JabatanTarget extends Controller
{
    public function index()
    {
        $jabatan = new DaftarApi();
        $refjab = $jabatan->apiJabatan();

        $data = JabTargetModel::leftJoin('ref_jabatan', 'ref_jabatan.id_jabatan', '=', 'tbl_jab_target.id_jabatan')
            ->leftJoin('ref_skpd', 'ref_skpd.id_skpd', '=', 'ref_jabatan.id_skpd')
            ->selectRaw('ref_jabatan.id_jabatan as id_jabatan,ref_jabatan.jabatan as jabatan, ref_skpd.skpd as skpd,DATE(tbl_jab_target.created_at) as tanggal')
            ->selectRaw('tbl_jab_target.filter_pegawai as filter,tbl_jab_target.id_target as id_target')
            ->get();

        $title = 'Jabatan Target';
        return view(view: 'target', data: compact('title', 'data', 'refjab'));
    }

    public function addTarget(Request $request)
    {
        $id_jabatan = $request->input('id_jabatan');

        $jabtarget = new JabTargetModel();
        $jabtarget->id_jabatan = $id_jabatan;
        $jabtarget->filter_pegawai = 0;
        $jabtarget->save();

        return redirect('/target');
    }

    public function hapusTarget(string $id_target)
    {
        $jabtarget = JabTargetModel::where('id_target', $id_target)->first();
        if ($jabtarget) {
            $jabtarget->delete();
        }

        //hapus dari kolom aspek nilai
        $aspekpeg = AspekNilai::where('id_target', $id_target)->get();
        foreach ($aspekpeg as $value) {
            $value->delete();
        }

        //hapus dari kolom nilai talenta
        $ntalent = NilaiTalenta::where('id_target', $id_target)->get();
        foreach ($ntalent as $vals) {
            $vals->delete();
        }

        //hapus dari tabel perhitungan
        $nhitung = HitungModel::where('id_target', $id_target)->get();
        foreach ($nhitung as $val) {
            $val->delete();
        }

        return redirect('/target');
    }

    public function filterPengalaman(string $id_eselon, string $id_pegawai)
    {
        $syarpeg = SyaratPegawai::where('id_pegawai', $id_pegawai);

        if ($syarpeg->count() > 0) {
            $dapeg = $syarpeg->first();
            //masukkan data ke tabel syarat pegawai
            //1. cek pengalaman 4b
            $peng_4b = floor(($dapeg['peng_pelaksana'] + $dapeg['peng_ahlipertama']) / 12);
            if ($peng_4b >= 4) {
                $lulus_4b = 1;
            } else {
                $lulus_4b = 0;
            }

            //2. cek pengalaman 4a
            $peng_4a = floor($dapeg['peng_e4b'] / 12);
            $peng_4a_jtr = floor($dapeg['peng_ahlipertama'] / 12);
            if ($peng_4a >= 2) {
                $lulus_4a = 1;
            } elseif ($peng_4a_jtr >= 4) {
                $lulus_4a = 1;
            } else {
                $lulus_4a = 0;
            }

            //3. cek pengalaman 3b
            $peng_3b = floor(($dapeg['peng_e4a'] + $dapeg['peng_ahlimuda']) / 12);
            if ($peng_3b >= 3) {
                $lulus_3b = 1;
            } else {
                $lulus_3b = 0;
            }

            //4. cek pengalaman 3a
            $peng_3a = floor($dapeg['peng_e3b'] / 12);
            $peng_3a_jf = floor($dapeg['peng_ahlimuda'] / 12);
            if ($peng_3a >= 2) {
                $lulus_3a = 1;
            } elseif ($peng_3a_jf >= 3) {
                $lulus_3a = 1;
            } else {
                $lulus_3a = 0;
            }

            //5. cek pengalaman 2ab
            $peng_2ab = floor(($dapeg['peng_e3b'] + $dapeg['peng_e3a'] + $dapeg['peng_ahlimadya']) / 12);
            if ($peng_2ab >= 2) {
                $lulus_2ab = 1;
            } else {
                $lulus_2ab = 0;
            }

            //finalisasi
            if ($id_eselon == 3) {
                $pengalaman = $lulus_2ab;
            } elseif ($id_eselon == 4) {
                $pengalaman = $lulus_2ab;
            } elseif ($id_eselon == 5) {
                $pengalaman = $lulus_3a;
            } elseif ($id_eselon == 6) {
                $pengalaman = $lulus_3b;
            } elseif ($id_eselon == 7) {
                $pengalaman = $lulus_4a;
            } elseif ($id_eselon == 8) {
                $pengalaman = $lulus_4b;
            }
        } else {
            $pengalaman = 0;
        }


        return $pengalaman;
    }

    public function simpanData(string $id_target, string $id_pegawai)
    {
        $tahun_kinerja = date('Y') - 1;
        //ambil data id_jabatan
        $jabs = JabTargetModel::leftJoin('ref_jabatan', 'ref_jabatan.id_jabatan', '=', 'tbl_jab_target.id_jabatan')
            ->where('tbl_jab_target.id_target', '=', $id_target)->first();

        //ambil data pegawai
        $data = PegawaiData::leftJoin('tbl_kinerja_pegawai', 'tbl_kinerja_pegawai.id_pegawai', '=', 'tbl_pegawai.id_pegawai')
            ->where('tbl_pegawai.id_pegawai', '=', $id_pegawai)
            ->whereYear('tbl_kinerja_pegawai.periode_awal', '=', $tahun_kinerja)
            ->select('tbl_pegawai.*', 'tbl_kinerja_pegawai.hasil_akhir')
            ->first();

        //kinerja tidak ada error//nanti cek yoel punya    

        //masukkan nilai talenta sesuai data yang sudah ada
        //1. Konversi pendidikan formal ke nilai talenta
        $kode_pddk = substr($data['id_pendidikan'], 0, 2);
        if ($kode_pddk == '07') {
            $kode_pddk = '08';
        }
        $nilai_3 = AspekModel::where([
            ['id_indikator', '=', 3],
            ['nilai_data', '=', $kode_pddk]
        ])->pluck('id_aspek')->first();

        //2. Konversi diklat ke nilai talenta
        $nilais = AspekModel::where('id_indikator', '=', 5)
            ->OrderBy('id_aspek', 'asc')
            ->get();

        foreach ($nilais as $key => $value) {
            ${'aspek_' . $key + 1} = $value->id_aspek;
            ${'range_' . $key + 1} = $value->nilai_data;
        }

        $jp_diklat = $data['jam_jp'];
        if ($jp_diklat >= $range_1) {
            $nilai_5 = $aspek_1;
        } elseif ($jp_diklat >= $range_2) {
            $nilai_5 = $aspek_2;
        } elseif ($jp_diklat >= $range_3) {
            $nilai_5 = $aspek_3;
        } elseif ($jp_diklat >= $range_4) {
            $nilai_5 = $aspek_4;
        } elseif ($jp_diklat >= $range_5) {
            $nilai_5 = $aspek_5;
        } else {
            $nilai_5 = $aspek_6;
        }

        //3. Konversi hukuman disiplin ke nilai talenta
        $nilai_9 = AspekModel::where([
            ['id_indikator', '=', 9],
            ['nilai_data', '=', $data['id_hukuman']]
        ])->pluck('id_aspek')->first();

        //4. Konversi nilai kinerja ke nilai talenta

        $nilai_10 = AspekModel::where([
            ['id_indikator', '=', 10],
            ['aspek_tingkatan', '=', $data['hasil_akhir']]
        ])->pluck('id_aspek')->first();

        //5. Konversi Jabatan target dengan ilmu pendidikan terkait
        $api = new DaftarApi();
        $cek_pend = 0;
        $riwpend = $api->apiRiwayat($id_pegawai, 'RIWAYAT_PENDIDIKAN');

        if (count($riwpend) > 0) {
            //ambil relasi jabatan pendidikan
            $cek_pend = RelasiJabPend::query()
                ->where(function ($query) use ($riwpend) {
                    foreach ($riwpend as $pend) {
                        $query->orWhere('id_pendidikan', '=', $pend['detail_pendidikan_id']);
                    }
                })
                ->where('id_jabatan', '=', $jabs->id_jabatan)
                ->count();
        }

        if ($cek_pend > 0) {
            $nilai_4 = 16;
        } else {
            //jika tidak ada relasi jabatan pendidikan, maka nilai 2 diisi dengan poin terendah
            $nilai_4 = 17;
        }

        //6. Konversi penilaian 360 ke nilai talenta//cek order
        $nilai_12 = SimpelModel::where('id_pegawai', '=', $id_pegawai)->orderBy('periode', 'desc')
            ->latest()->pluck('total_nilai')->first();

        if ($nilai_12 == null) {
            $nilai_12 = 0; // jika tidak ada nilai, set ke 
        }

        //7.ambil Nilai Kompetensi dari database
        $leveselon = 0;
        $aspek_1 = 0;
        $aspek_2 = 0;
        $aspek_3 = 0;
        $aspek_4 = 0;
        $aspek_5 = 0;
        $aspek_6 = 0;
        $aspek_7 = 0;
        $aspek_8 = 0;
        $aspek_9 = 0;
        $id_estarget = $jabs->id_eselon;
        if ($id_estarget == 3 || $id_estarget == 4) {
            $leveselon = 2;
        } elseif ($id_estarget == 5 || $id_estarget == 6) {
            $leveselon = 3;
        } elseif ($id_estarget == 7 || $id_estarget == 8) {
            $leveselon = 4;
        }
        $nkomp = KompetensiModel::where([
            ['id_pegawai', '=', $id_pegawai],
            ['level_eselon', '=', $leveselon]
        ])->first();
        if ($nkomp) {
            $aspek_1 = $nkomp->aspek_1;
            $aspek_2 = $nkomp->aspek_2;
            $aspek_3 = $nkomp->aspek_3;
            $aspek_4 = $nkomp->aspek_4;
            $aspek_5 = $nkomp->aspek_5;
            $aspek_6 = $nkomp->aspek_6;
            $aspek_7 = $nkomp->aspek_7;
            $aspek_8 = $nkomp->aspek_8;
            $aspek_9 = $nkomp->aspek_9;
        }

        //8. ambil Nilai Asesmen
        $nilai_7 = AsesmenModel::where('id_pegawai', '=', $id_pegawai)->latest()->pluck('total_nilai')->first();
        if ($nilai_7 == null) {
            $nilai_7 = 0;
        }

        //00.Isikan default dataminimal untuk data yang belum tersedia
        $nilai_6 = 26;
        $nilai_8 = 33;
        $nilai_11 = 49;
        $nilai_13 = 54;

        $cekpegawai = AspekNilai::where([
            ['id_pegawai', '=', $id_pegawai],
            ['id_target', '=', $id_target]
        ]);
        if ($cekpegawai->count() > 0) {
            $cekpegawai->first()->update([
                'id_pegawai' => $id_pegawai,
                'id_target' => $id_target,
                'aspek_1' => $aspek_1,
                'aspek_2' => $aspek_2,
                'aspek_3' => $aspek_3,
                'aspek_4' => $aspek_4,
                'aspek_5' => $aspek_5,
                'aspek_6' => $aspek_6,
                'aspek_7' => $aspek_7,
                'aspek_8' => $aspek_8,
                'aspek_9' => $aspek_9,
                'indikator_3' => $nilai_3,  //pendidikan formal 
                'indikator_4' => $nilai_4, // kesesuaian bidang ilmu dengan jabatan target
                'indikator_5' => $nilai_5,   //pengembangan kompetensi (jamJP) 
                'indikator_6' => $nilai_6,
                'indikator_7' => $nilai_7, //preferensi karier
                'indikator_8' => $nilai_8,
                'indikator_9' => $nilai_9,   //hukuman disiplin
                'indikator_10' => $nilai_10,   //kinerja pegawai
                'indikator_11' => $nilai_11,
                'indikator_12' => $nilai_12, //nilai penilaian 360
                'indikator_13' => $nilai_13

            ]);
        } else {
            //tambahkan ke tbl_aspek_nilai_pegawai
            $newdata = new AspekNilai();
            $newdata->id_pegawai = $id_pegawai;
            $newdata->id_target = $id_target;
            $newdata->aspek_1 = $aspek_1;
            $newdata->aspek_2 = $aspek_2;
            $newdata->aspek_3 = $aspek_3;
            $newdata->aspek_4 = $aspek_4;
            $newdata->aspek_5 = $aspek_5;
            $newdata->aspek_6 = $aspek_6;
            $newdata->aspek_7 = $aspek_7;
            $newdata->aspek_8 = $aspek_8;
            $newdata->aspek_9 = $aspek_9;
            $newdata->indikator_3 = $nilai_3;   //pendidikan formal 
            $newdata->indikator_4 = $nilai_4; // kesesuaian bidang ilmu dengan jabatan target
            $newdata->indikator_5 = $nilai_5;   //pengembangan kompetensi (jamJP) 
            $newdata->indikator_6 = $nilai_6;
            $newdata->indikator_7 = $nilai_7; //preferensi karier
            $newdata->indikator_8 = $nilai_8;
            $newdata->indikator_9 = $nilai_9;   //hukuman disiplin
            $newdata->indikator_10 = $nilai_10;   //kinerja pegawai
            $newdata->indikator_11 = $nilai_11;
            $newdata->indikator_12 = $nilai_12; //nilai penilaian 360
            $newdata->indikator_13 = $nilai_13;
            $newdata->save();
        }
    }

    public function generate(string $id_target)
    {
        ini_set('max_execution_time', 0);
        //ambil id_eselon untuk melihat persyaratan
        $jabs = JabTargetModel::leftJoin('ref_jabatan', 'ref_jabatan.id_jabatan', '=', 'tbl_jab_target.id_jabatan')
            ->where('tbl_jab_target.id_target', '=', $id_target)->first();

        //echo $jabs->id_eselon . "<br>";
        $tahun_kinerja = $jabs->created_at->format('Y') - 1;

        //cek data E-kinerja pegawai
        $pegawai = PegawaiData::leftJoin('tbl_syarat_pegawai', 'tbl_syarat_pegawai.id_pegawai', '=', 'tbl_pegawai.id_pegawai')
            ->selectRaw('tbl_pegawai.id_pegawai,tbl_pegawai.tanggal_lahir,tbl_pegawai.id_status_kepegawaian,tbl_pegawai.id_pendidikan,tbl_syarat_pegawai.hukdis_2_tahun,TIMESTAMPDIFF(YEAR,tbl_pegawai.tanggal_lahir,CURDATE()) as umur')
            ->where('tbl_pegawai.id_skpd', '>', 0)
            ->get();

        $syarat = SyaratJabatan::where('id_eselon', $jabs->id_eselon)->first();
        foreach ($pegawai as $peg) {
            $kinerja = KinerjaPegawai::where('id_pegawai', $peg->id_pegawai)
                ->where(function ($query) use ($tahun_kinerja) {
                    $query->whereYear('periode_awal', $tahun_kinerja)
                        ->orwhereYear('periode_awal', $tahun_kinerja - 1);
                })
                ->whereLike('hasil_akhir', '%baik%')
                ->count();

            //1. Status Kepegawaian PNS
            if ($peg->id_status_kepegawaian == $syarat->id_status_kepegawaian) {
                //2. Pendidikan Pegawai DIII atau dIV/S1 - sesuai jabatan eselon
                $id_pend_peg = substr($peg->id_pendidikan, 0, 2);
                if (intval($id_pend_peg) >= intval($syarat->id_pendidikan)) {
                    //3. Hukuman Disiplin Pegawai tidak dijatuhi sedang dan berat
                    if ($peg->hukdis_2_tahun < $syarat->id_hukuman_min) {
                        // 4. Predikat Kinerja 2 tahun terakhir minimal baik
                        //if ($peg->hasil_akhir == $syarat->predikat_kinerja || $peg->hasil_akhir == 'sangat baik') {
                        //echo $peg->kinerja_total . "<br>";
                        if ($kinerja >= 2) {
                            //5. Pengalaman dalam jabatan memenuhi syarat
                            $pengalaman = $this->filterPengalaman($jabs->id_eselon, $peg->id_pegawai);
                            if ($pengalaman == 1) {
                                //6. khusus eselon 2ab umur max 56 tahun
                                // $umur  = Carbon::parse($peg->tanggal_lahir)->age;
                                //echo $peg->umur;
                                if (($jabs->id_eselon == 3 || $jabs->id_eselon == 4) && $peg->umur < $syarat->usia_max) {
                                    $this->simpanData($id_target, $peg->id_pegawai);
                                } elseif ($jabs->id_eselon >= 5) {
                                    $this->simpanData($id_target, $peg->id_pegawai);
                                }
                            } else {
                                //echo $peg->id_pegawai . "tidak lulus pengalaman<br>";
                            }
                        } else {
                            // echo $peg->id_pegawai . "tidak lulus kinerja<br>";
                        }
                    } else {
                        //echo $peg->id_pegawai . "tidak lulus hukuman disiplin<br>";
                    }
                } else {
                    //echo $peg->id_pegawai . "tidak lulus pendidikan<br>";
                }
            } else {
                //echo $peg->id_pegawai . "tidak lulus status kepegawaian<br>";
            }
        }

        //ubah filter pegawai
        $jabtarget = JabTargetModel::where('id_target', $id_target)->first();
        if ($jabtarget) {
            $jabtarget->filter_pegawai = 1;
            $jabtarget->save();
        }

        return redirect('/target')->with('message', 'Filter Pegawai berhasil dilakukan.');
    }

    public function pilihTarget(Request $request)
    {
        $id_target = $request->input('id_tarjab');
        $id_seleksi = $request->input('id_seleksi');
        Session::put('id_target', $id_target);
        Session::put('id_seleksi', $id_seleksi);

        return redirect('/dapeg');
    }
}
