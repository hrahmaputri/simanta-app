<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Support\DaftarApi;
use App\Models\PegawaiData;
use App\Models\SimpelModel;
use App\Models\SyaratPegawai;
use Illuminate\Http\Request;

class SinkronData extends Controller
{
    public function index()
    {
        return view("sinkron", [
            'title' => 'Sinkronisasi Data Pegawai'

        ]);
    }

    public function apiAllDapeg()
    {
        $api = new DaftarApi();
        $data = $api->apiAllPegawai();

        //netralkan status update
        PegawaiData::where('cek_update', '=', 1)->update(array('cek_update' => 0));

        foreach ($data as $dapeg) {
            if ($dapeg['kode_pendidikan'] == null) {
                $dapeg['kode_pendidikan'] = 0;
            }

            if ($dapeg['id_pangkat'] == null) {
                $dapeg['id_pangkat'] = 0;
            }

            if ($dapeg['id_hukuman'] == null) {
                $dapeg['id_hukuman'] = 0;
            }

            if ($dapeg['jam_jp'] == null) {
                $dapeg['jam_jp'] = 0;
            }

            //masukkan data pegawai ke tabel pegawai
            $pegawai = PegawaiData::where('id_pegawai', '=', $dapeg['id_pegawai']);
            if ($pegawai->count() > 0) {
                $update = $pegawai->first();
                $update->nip = $dapeg['nip'];
                $update->nip_lama = $dapeg['nip_lama'];
                $update->nama_pegawai = $dapeg['nama'];
                $update->tanggal_lahir = $dapeg['tanggal_lahir'];
                $update->id_status_kepegawaian = $dapeg['id_status_kepegawaian'];
                $update->id_jabatan = $dapeg['id_jabatan'];
                $update->id_pangkat = $dapeg['id_pangkat'];
                $update->id_skpd = $dapeg['id_skpd'];
                $update->gelar_depan = $dapeg['gelar_depan'];
                $update->gelar_belakang = $dapeg['gelar_belakang'];
                $update->id_pendidikan = $dapeg['kode_pendidikan'];
                $update->id_hukuman = $dapeg['id_hukuman'];
                $update->id_jenjang_jabfung = $dapeg['id_jenjang_jabfung'];
                $update->jam_jp = $dapeg['jam_jp'];
                $update->id_pengguna = $dapeg['id_pengguna'];
                $update->cek_update = 1;
                $update->save();
            } else {
                $peg = new PegawaiData();
                $peg->id_pegawai = $dapeg['id_pegawai'];
                $peg->nip = $dapeg['nip'];
                $peg->nip_lama = $dapeg['nip_lama'];
                $peg->nama_pegawai = $dapeg['nama'];
                $peg->tanggal_lahir = $dapeg['tanggal_lahir'];
                $peg->id_status_kepegawaian = $dapeg['id_status_kepegawaian'];
                $peg->id_jabatan = $dapeg['id_jabatan'];
                $peg->id_pangkat = $dapeg['id_pangkat'];
                $peg->id_skpd = $dapeg['id_skpd'];
                $peg->gelar_depan = $dapeg['gelar_depan'];
                $peg->gelar_belakang = $dapeg['gelar_belakang'];
                $peg->id_pendidikan = $dapeg['kode_pendidikan'];
                $peg->id_hukuman = $dapeg['id_hukuman'];
                $peg->id_jenjang_jabfung = $dapeg['id_jenjang_jabfung'];
                $peg->jam_jp = $dapeg['jam_jp'];
                $peg->jid_pengguna = $dapeg['id_pengguna'];
                $peg->cek_update = 1;
                $peg->save();
            }

            $syarat = SyaratPegawai::where('id_pegawai', '=', $dapeg['id_pegawai']);
            if ($syarat->count() > 0) {
                $update = $syarat->first();
                $update->id_pegawai = $dapeg['id_pegawai'];
                $update->peng_e2a = $dapeg['pengalaman_e2a'];
                $update->peng_e2b = $dapeg['pengalaman_e2b'];
                $update->peng_e3a = $dapeg['pengalaman_e3a'];
                $update->peng_e3b = $dapeg['pengalaman_e3b'];
                $update->peng_e4a = $dapeg['pengalaman_e4a'];
                $update->peng_e4b = $dapeg['pengalaman_e4b'];
                $update->peng_pelaksana = $dapeg['pengalaman_pelaksana'];
                $update->peng_ahlimuda = $dapeg['pengalaman_ahlimuda'];
                $update->peng_ahlipertama = $dapeg['pengalaman_ahlipertama'];
                $update->peng_ahlimadya = $dapeg['pengalaman_ahlimadya'];
                $update->hukdis_2_tahun = $dapeg['id_hukdis2'];
                $update->save();
            } else {
                //insert
                $syarat = new SyaratPegawai();
                $syarat->id_pegawai = $dapeg['id_pegawai'];
                $syarat->peng_e2a = $dapeg['pengalaman_e2a'];
                $syarat->peng_e2b = $dapeg['pengalaman_e2b'];
                $syarat->peng_e3a = $dapeg['pengalaman_e3a'];
                $syarat->peng_e3b = $dapeg['pengalaman_e3b'];
                $syarat->peng_e4a = $dapeg['pengalaman_e4a'];
                $syarat->peng_e4b = $dapeg['pengalaman_e4b'];
                $syarat->peng_pelaksana = $dapeg['pengalaman_pelaksana'];
                $syarat->peng_ahlimuda = $dapeg['pengalaman_ahlimuda'];
                $syarat->peng_ahlipertama = $dapeg['pengalaman_ahlipertama'];
                $syarat->peng_ahlimadya = $dapeg['pengalaman_ahlimadya'];
                $syarat->hukdis_2_tahun = $dapeg['id_hukdis2'];
                $syarat->save();
            }
        }

        //nonaktifkan pegawai yang tidak ada di api
        $pegawaitbl = PegawaiData::where('cek_update', '=', 0);
        if ($pegawaitbl->count() > 0) {
            $pegawaitbl->each(function ($item) {
                $item->delete();
            });
        }

        return redirect('/sinkronisasi')->with('message', 'Sinkronisasi data pegawai berhasil dilakukan.');
    }

    public function apiPilihDapeg()
    {
        $peg = collect([]);
        return view("sinkronsatu", [
            'title' => 'Pilih Data Pegawai untuk disinkronisasi',
            'pegawais' => $peg

        ]);
    }

    public function apiSatuDapeg(string $id_pegawai)
    {
        //ambil api data pegawai utama, pendidikan dan hukuman disiplin dan diklat
        $pribadi = new DaftarApi();
        $data = $pribadi->apiDatapribadi($id_pegawai);
        $data = $data[0];
        if ($data['kode_pendidikan'] == null) {
            $data['kode_pendidikan'] = 0;
        }

        if ($data['id_pangkat'] == null) {
            $data['id_pangkat'] = 0;
        }

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
            $update->nip_lama = $data['nip_lama'];
            $update->nama_pegawai = $data['nama'];
            $update->id_status_kepegawaian = $data['id_status_kepegawaian'];
            $update->tanggal_lahir = $data['tanggal_lahir'];
            $update->id_jabatan = $data['id_jabatan'];
            $update->id_pangkat = $data['id_pangkat'];
            $update->id_skpd = $data['id_skpd'];
            $update->gelar_depan = $data['gelar_depan'];
            $update->gelar_belakang = $data['gelar_belakang'];
            $update->id_pendidikan = $data['kode_pendidikan'];
            $update->id_jenjang_jabfung = $data['id_jenjang_jabfung'];
            $update->id_pengguna = $data['id_pengguna'];
            $update->id_hukuman = $id_hukuman;
            $update->jam_jp = $jp_diklat;
            $update->save();
        } else {
            $peg = new PegawaiData();
            $peg->id_pegawai = $data['id_pegawai'];
            $peg->nip = $data['nip'];
            $peg->nip_lama = $data['nip_lama'];
            $peg->nama_pegawai = $data['nama'];
            $peg->tanggal_lahir = $data['tanggal_lahir'];
            $peg->id_status_kepegawaian = $data['id_status_kepegawaian'];
            $peg->id_jabatan = $data['id_jabatan'];
            $peg->id_pangkat = $data['id_pangkat'];
            $peg->id_skpd = $data['id_skpd'];
            $peg->gelar_depan = $data['gelar_depan'];
            $peg->gelar_belakang = $data['gelar_belakang'];
            $peg->id_pendidikan = $data['kode_pendidikan'];
            $peg->id_jenjang_jabfung = $data['id_jenjang_jabfung'];
            $peg->id_pengguna = $data['id_pengguna'];
            $peg->id_hukuman = $id_hukuman;
            $peg->jam_jp = $jp_diklat;
            $peg->save();
        }

        $syarat = SyaratPegawai::where('id_pegawai', '=', $id_pegawai);
        if ($syarat->count() > 0) {
            $update = $syarat->first();
            $update->id_pegawai = $data['id_pegawai'];
            $update->peng_e2a = $data['pengalaman_e2a'];
            $update->peng_e2b = $data['pengalaman_e2b'];
            $update->peng_e3a = $data['pengalaman_e3a'];
            $update->peng_e3b = $data['pengalaman_e3b'];
            $update->peng_e4a = $data['pengalaman_e4a'];
            $update->peng_e4b = $data['pengalaman_e4b'];
            $update->peng_pelaksana = $data['pengalaman_pelaksana'];
            $update->peng_ahlimuda = $data['pengalaman_ahlimuda'];
            $update->peng_ahlipertama = $data['pengalaman_ahlipertama'];
            $update->peng_ahlimadya = $data['pengalaman_ahlimadya'];
            $update->hukdis_2_tahun = $data['id_hukdis2'];
            $update->save();
        } else {
            //insert
            $syarat = new SyaratPegawai();
            $syarat->id_pegawai = $data['id_pegawai'];
            $syarat->peng_e2a = $data['pengalaman_e2a'];
            $syarat->peng_e2b = $data['pengalaman_e2b'];
            $syarat->peng_e3a = $data['pengalaman_e3a'];
            $syarat->peng_e3b = $data['pengalaman_e3b'];
            $syarat->peng_e4a = $data['pengalaman_e4a'];
            $syarat->peng_e4b = $data['pengalaman_e4b'];
            $syarat->peng_pelaksana = $data['pengalaman_pelaksana'];
            $syarat->peng_ahlimuda = $data['pengalaman_ahlimuda'];
            $syarat->peng_ahlipertama = $data['pengalaman_ahlipertama'];
            $syarat->peng_ahlimadya = $data['pengalaman_ahlimadya'];
            $syarat->hukdis_2_tahun = $data['id_hukdis2'];
            $syarat->save();
        }

        //tambah data simpel
        $id_pengguna = $pegawai->pluck('id_pengguna')->first();
        $simpels = $pribadi->apiSimpel($id_pengguna, 'pegawai');
        if ($simpels['result'] == 1) {
            $simpel = $simpels['data'];
            $fsimpel = new SimpelController();
            $fsimpel->addSatuData($simpel);
        }

        //tambah data asesmen
        $ases = $pribadi->apiAsesmen($id_pengguna, 'pegawai');
        if ($ases['result'] == 1) {
            $asesdata = new SimpelController();
            $asesdata->addSatuDataAses($ases['data']);
        }


        return redirect('/sinkronisasi')->with('message', 'Sinkronisasi data pegawai ' . $data['nama'] . ' berhasil dilakukan.');
    }
}
