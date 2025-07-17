<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Support\DaftarApi;
use App\Models\AspekModel;
use App\Models\AspekNilai;
use App\Models\HitungModel;
use App\Models\Indikator;
use App\Models\JabTargetModel;
use App\Models\KinerjaPegawai;
use App\Models\NilaiTalenta;
use App\Models\PegawaiData;
use App\Models\RefApi;
use App\Models\RelasiJabPend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class DataController extends Controller
{
    public function index()
    {
        $id_target = 0;
        $id_seleksi = 0;
        if (session()->has('id_target')) {
            $id_target = session('id_target');
        }
        if (session()->has('id_seleksi')) {
            $id_seleksi = session('id_seleksi');
        }

        //untuk tampilan filter menu
        $jabpilih = JabTargetModel::leftJoin('ref_jabatan', 'ref_jabatan.id_jabatan', '=', 'tbl_jab_target.id_jabatan')
            ->selectRaw('ref_jabatan.jabatan as jabatan,tbl_jab_target.id_target as id_target,DATE(tbl_jab_target.created_at) as tanggal');

        $jabtarget = $jabpilih->get();

        //kasus jika ternyata id_target sudah dihapus
        $jabmuncul = $jabpilih->where('tbl_jab_target.id_target', '=', $id_target);
        if ($jabmuncul->count() > 0) {
            $jabmuncul = $jabmuncul->first();
        } else {
            $id_target = 0;
            $id_seleksi = 0;
        }

        //ambil id_eselon jabatan target
        $jabeselon = JabTargetModel::leftJoin('ref_jabatan', 'ref_jabatan.id_jabatan', '=', 'tbl_jab_target.id_jabatan')
            ->selectRaw('ref_jabatan.id_eselon,tbl_jab_target.id_target')
            ->where('tbl_jab_target.id_target', '=', $id_target)
            ->pluck('id_eselon')
            ->first();

        $data = AspekNilai::leftJoin('tbl_pegawai', 'tbl_pegawai.id_pegawai', '=', 'tbl_aspek_nilai_pegawai.id_pegawai')
            ->leftJoin('ref_skpd', 'ref_skpd.id_skpd', '=', 'tbl_pegawai.id_skpd')
            ->leftJoin('ref_jabatan', 'ref_jabatan.id_jabatan', '=', 'tbl_pegawai.id_jabatan')
            ->selectRaw('TIMESTAMPDIFF(YEAR,tbl_pegawai.tanggal_lahir,CURDATE()) as umur,tbl_aspek_nilai_pegawai.id_nilai as id_nilai,tbl_aspek_nilai_pegawai.id_pegawai as id_pegawai,tbl_pegawai.nama_pegawai as nama,tbl_pegawai.nip as nip, ref_skpd.skpd as skpd, ref_jabatan.jabatan as jabatan,tbl_pegawai.id_jenjang_jabfung')
            ->where('tbl_aspek_nilai_pegawai.id_target', '=', $id_target)
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
            ->OrderBy('tbl_pegawai.nama_pegawai', 'asc')
            ->get();



        $syaratpend = JabTargetModel::leftJoin('tbl_relasi_jab_pend', 'tbl_relasi_jab_pend.id_jabatan', '=', 'tbl_jab_target.id_jabatan')
            ->leftJoin('ref_tk_pendidikan', 'ref_tk_pendidikan.id_tk_pendidikan', '=', 'tbl_relasi_jab_pend.id_pendidikan')
            ->selectRaw('ref_tk_pendidikan.namaTkPendidikan as pendidikan')
            ->where('tbl_jab_target.id_target', '=', $id_target)
            ->get();



        return view("datapegawai", [
            'title' => 'Data Pegawai',
            'dapeg' => $data,
            'jabtarget' => $jabtarget,
            'id_target' => $id_target,
            'jabmuncul' => $jabmuncul,
            'syaratpend' => $syaratpend
        ]);
    }

    public function getPoin(Request $request)
    {
        $id_aspek = $request->id_aspek;
        $data = AspekModel::leftJoin('tbl_indikator', 'tbl_indikator.id_indikator', '=', 'tbl_aspek_tingkatan.id_indikator')
            ->selectRaw('tbl_aspek_tingkatan.skj_poin as poin,tbl_indikator.bobot as bobot,tbl_aspek_tingkatan.id_indikator as id_indikator')
            ->find($id_aspek);


        return response()->json(['data' => $data]);
    }

    public function inputNilai(Request $request)
    {
        $id_peg_nilai = $request->input('id_peg_nilai');

        $nupdate = AspekNilai::where('id_nilai', '=', $id_peg_nilai)->first();

        //Indikator_1-aspek1 s.d 9
        $data_asp = AspekModel::where('jenis', '=', 1)->get();
        foreach ($data_asp as $asp) {
            $nupdate->{'aspek_' . $asp->id_aspek} = $request->input('vAspek' . $asp->id_aspek);
        }

        //Indikator_2 s.d 13
        $data_tk = Indikator::where('id_utama', '>=', 2)->get();
        foreach ($data_tk as $tk) {
            if ($tk->id_indikator != 2 && $tk->id_indikator != 7 && $tk->id_indikator != 12) {
                $nupdate->{'indikator_' . $tk->id_indikator} = $request->input('tingkatan_' . $tk->id_indikator);
            } else {
                $nupdate->{'indikator_' . $tk->id_indikator} = $request->input('val_' . $tk->id_indikator);
            }
        }

        $nupdate->save();

        $hitung = new ReportController();
        $hitung->HitungTalenta($id_peg_nilai, $nupdate->id_target);

        return redirect('/datanilai/' . $id_peg_nilai);
    }

    public function inputPegawai()
    {
        $peg = collect([]);
        $id_target = 0;
        if (session()->has('id_target')) {
            $id_target = session('id_target');
        }

        return view("tambahpegawai", [
            'title' => 'Daftar Pegawai Aktif',
            'pegawais' => $peg,
            'id_target' => $id_target
        ]);
    }

    public function filterPegawai(Request $request)
    {
        //1 akses dari sinkron data administrator, 2 akses dari input pegawai tim simeta
        $akses_id = $request->input('akses_id');
        $nampeg = $request->input('nampeg');
        $nip = $request->input('nip');
        $skpd = $request->input('skpd');
        $jabatan = $request->input('jabatan');

        $field = '';
        $value = '';
        if ($nampeg == null && $nip == null && $skpd == null && $jabatan == null) {
            return redirect('/inputpegawai');
        } else {
            if ($nampeg != '') {
                $field = 'nama_pegawai';
                $value = $nampeg;
            } elseif ($nip != '') {
                $field = 'nip';
                $value = $nip;
            } elseif ($skpd != '') {
                $field = 'skpd';
                $value = $skpd;
            } elseif ($jabatan != '') {
                $field = 'jabatan';
                $value = $jabatan;
            }
        }



        if ($akses_id == 1) {
            $api = new DaftarApi();
            $data = $api->apiPegawai($field, $value);

            return view("sinkronsatu", [
                'title' => 'Pilih Pegawai Aktif',
                'pegawais' => $data

            ]);
        } else if ($akses_id == 2) {
            $data2 = PegawaiData::leftJoin('ref_skpd', 'ref_skpd.id_skpd', '=', 'tbl_pegawai.id_skpd')
                ->leftJoin('ref_jabatan', 'ref_jabatan.id_jabatan', '=', 'tbl_pegawai.id_jabatan')
                ->select('tbl_pegawai.id_pegawai', 'tbl_pegawai.nama_pegawai as nama_lengkap', 'tbl_pegawai.nip', 'ref_jabatan.jabatan', 'ref_skpd.skpd')
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

            return view("tambahpegawai", [
                'title' => 'Daftar Pegawai Aktif',
                'pegawais' => $data2
            ]);
        }
    }

    public function hapusPegawai(string $id_nilai)
    {
        //hapus pegawai dari tabel aspek
        $aspek = AspekNilai::find($id_nilai);
        $id_target = $aspek->id_target;
        $id_pegawai = $aspek->id_pegawai;
        if ($aspek->count() > 0) {

            //hapus dari tabel perhitungan
            $hitung = HitungModel::where([
                ['id_pegawai', '=', $id_pegawai],
                ['id_target', '=', $id_target]
            ]);
            if ($hitung->count() > 0) {
                $hitung->delete();
            }

            //hapus dari tabel nilai talenta
            $ntalenta = NilaiTalenta::where([
                ['id_pegawai', '=', $id_pegawai],
                ['id_target', '=', $id_target]
            ]);

            if ($ntalenta->count() > 0) {
                $ntalenta->delete();
            }

            //hapus dari tabel aspek nilai
            $aspek->delete();
        }

        return redirect('/dapeg');
    }

    public function pilihPegawai(string $id_pegawai)
    {
        $id_target = 0;
        if (session()->has('id_target')) {
            $id_target = session('id_target');
        }

        //pakai data dari database
        //ambil data dari Controller SinkronData

        //$sinkron = new SinkronData();
        //$sinkron->apiSatuDapeg($id_pegawai);

        //ambil api data pegawai utama, pendidikan dan hukuman disiplin dan diklat
        /*$pribadi = new DaftarApi();
        $data = $pribadi->apiDatapribadi($id_pegawai);
        $data = $data[0];

        //hukdis
        $dhukdis = $pribadi->apiHukdis($id_pegawai);
        $id_hukuman = $dhukdis[0]['id_hukuman'];

        //diklat
        $diklat = $pribadi->apiDiklat($id_pegawai);
        $jp_diklat = $diklat[0]['lama_jps'] + $diklat[0]['lama_jpl'];

        $pegawai = PegawaiData::where('id_pegawai', '=', $id_pegawai);
        if ($pegawai->count() > 0) {
            $update = $pegawai->first();
            $update->nip = $data['nip'];
            $update->nama_pegawai = $data['nama'];
            $update->id_jabatan = $data['id_jabatan'];
            $update->id_pangkat = $data['id_pangkat'];
            $update->id_skpd = $data['id_skpd'];
            $update->gelar_depan = $data['gelar_depan'];
            $update->gelar_belakang = $data['gelar_belakang'];
            $update->id_pendidikan = $data['kode_pendidikan'];
            $update->id_hukuman = $id_hukuman;
            $update->jam_jp = $jp_diklat;
            $update->save();
        } else {
            $peg = new PegawaiData();
            $peg->id_pegawai = $data['id_pegawai'];
            $peg->nip = $data['nip'];
            $peg->nama_pegawai = $data['nama'];
            $peg->id_jabatan = $data['id_jabatan'];
            $peg->id_pangkat = $data['id_pangkat'];
            $peg->id_skpd = $data['id_skpd'];
            $peg->gelar_depan = $data['gelar_depan'];
            $peg->gelar_belakang = $data['gelar_belakang'];
            $peg->id_pendidikan = $data['kode_pendidikan'];
            $peg->id_hukuman = $id_hukuman;
            $peg->jam_jp = $jp_diklat;
            $peg->save();
        }*/

        //arahkan di metode simpanData di JabatanTargetController
        $action = new JabatanTarget();
        $action->simpanData($id_target, $id_pegawai);

        //tambahkan ke kolom tbl_aspek_nilai_pegawai
        /*$pegawai = AspekNilai::where('id_pegawai', '=', $id_pegawai);;
        if ($pegawai->count() > 0) {
            //
        } else {
            $aspek_peg = new AspekNilai();
            $aspek_peg->id_pegawai = $id_pegawai;
            $aspek_peg->save();
        }

        //masukkan nilai talenta sesuai data yang sudah ada
        //1. Konversi pendidikan formal ke nilai talenta
        /*$kode_pddk = substr($data['kode_pendidikan'], 0, 2);
        if ($kode_pddk == '07') {
            $kode_pddk == '08';
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
            ['nilai_data', '=', $id_hukuman]
        ])->pluck('id_aspek')->first();

        //4. Konversi nilai kinerja ke nilai talenta
        $kinerja = KinerjaPegawai::where('id_pegawai', '=', $id_pegawai)->first();
        $nilai_kinerja = $kinerja->hasil_akhir;
        $nilai_10 = AspekModel::where([
            ['id_indikator', '=', 10],
            ['aspek_tingkatan', '=', $nilai_kinerja]
        ])->pluck('id_aspek')->first();

        $aspek = AspekNilai::where('id_pegawai', '=', $id_pegawai)->first();
        $aspek->indikator_3 = $nilai_3;   //pendidikan formal 
        $aspek->indikator_5 = $nilai_5;   //pengembangan kompetensi (jamJP) 
        $aspek->indikator_9 = $nilai_9;   //hukuman disiplin
        $aspek->indikator_10 = $nilai_10;   //kinerja pegawai
        $aspek->save();*/

        return redirect('/dapeg');
    }

    public function cekPegawai(string $id_nilai, string $id_indikator)
    {
        $peg = AspekNilai::leftJoin('tbl_pegawai', 'tbl_pegawai.id_pegawai', '=', 'tbl_aspek_nilai_pegawai.id_pegawai')
            ->leftJoin('ref_skpd', 'ref_skpd.id_skpd', '=', 'tbl_pegawai.id_skpd')
            ->leftJoin('ref_jabatan', 'ref_jabatan.id_jabatan', '=', 'tbl_pegawai.id_jabatan')
            ->leftJoin('ref_tk_pendidikan', 'ref_tk_pendidikan.kode', '=', 'tbl_pegawai.id_pendidikan')
            ->select('tbl_pegawai.*', 'ref_skpd.skpd', 'ref_jabatan.jabatan', 'ref_tk_pendidikan.namaTkPendidikan as pendidikan')
            ->selectRaw('TIMESTAMPDIFF(YEAR,tbl_pegawai.tanggal_lahir,CURDATE()) as umur')
            ->where('tbl_aspek_nilai_pegawai.id_nilai', '=', $id_nilai)
            ->first();

        $api = new DaftarApi();
        $diklat = $api->apiRiwayat($peg->id_pegawai, 'RIWAYAT_DIKLAT');

        $diklat_str = $diklat[0]['riwayat_diklat_struktural'];
        $diklat_lainnya = $diklat[0]['riwayat_diklat_lainnya'];

        $pendidikan = $api->apiRiwayat($peg->id_pegawai, 'RIWAYAT_PENDIDIKAN');

        $riwhukdis = $api->apiRiwayat($peg->id_pegawai, 'RIWAYAT_HUKDIS');

        return view("profilpegawai", [
            'title' => 'Profil Pegawai',
            'pegawai' => $peg,
            'diklat_str' => $diklat_str,
            'diklat_lainnya' => $diklat_lainnya,
            'pendidikan' => $pendidikan,
            'hukdis' => $riwhukdis,
            'id_indikator' => $id_indikator
        ]);
    }
    public function lihatFile(string $id_type, string $id_pegawai, string $id_riw)
    {
        $tabel = '';
        if ($id_type == 1) {
            $tabel = 'tbl_pendidikan';
        } elseif ($id_type == 2) {
            $tabel = 'tbl_riwayat_diklat_struktural';
        } elseif ($id_type == 3) {
            $tabel = 'tbl_riwayat_diklat_lainnya';
        } elseif ($id_type == 4) {
            $tabel = 'tbl_riwayat_hukuman_disiplin';
        }

        $link = RefApi::find(2);
        return Redirect::to($link->url . 'lihat_upload_sk_all_asli.php?id_pegawai=' . $id_pegawai . '&type=' . $tabel . '&id=' . $id_riw);
    }
}
