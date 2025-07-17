<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Support\DaftarApi;
use App\Models\AsesmenModel;
use App\Models\PegawaiData;
use App\Models\SimpelModel;
use Illuminate\Http\Request;

class SimpelController extends Controller
{
    public function addSatuData(array $simpel)
    {
        $cek = SimpelModel::where([
            ['id_pegawai', '=', $simpel['id_pegawai']],
            ['periode', '=', $simpel['periode']]
        ]);

        if ($cek->count() > 0) {
            $update = $cek->first();
            $update->update([
                'id_pegawai' => $simpel['id_pegawai'],
                'id_pengguna' => $simpel['id_pengguna'],
                'nip' => $simpel['nip'],
                'total_nilai' => $simpel['total_nilai'],
                'periode' => $simpel['periode']
            ]);
        } else {
            SimpelModel::create(
                [
                    'id_pegawai' => $simpel['id_pegawai'],
                    'id_pengguna' => $simpel['id_pengguna'],
                    'nip' => $simpel['nip'],
                    'total_nilai' => $simpel['total_nilai'],
                    'periode' => $simpel['periode']
                ]
            );
        }
    }
    public function addData() //datasimpel360
    {
        $pegawai = PegawaiData::get();
        foreach ($pegawai as $data) {
            $api = new DaftarApi();
            $datasimpel = $api->apiSimpel($data->id_pengguna, 'pegawai');
            if ($datasimpel['result'] == 1) {
                $this->addSatuData($datasimpel['data']);
            }
        }

        return redirect('/sinkronisasi')->with('message', 'Pengambilan Data Penilaian 360 berhasil dilakukan.');
    }

    public function addSatuDataAses(array $ases)
    {
        $cekases = AsesmenModel::where([
            ['id_pegawai', '=', $ases['id_pegawai']],
            ['periode', '=', $ases['periode']]
        ]);

        if ($cekases->count() > 0) {
            $asesupdate = $cekases->first();
            $asesupdate->update([
                'id_pegawai' => $ases['id_pegawai'],
                'id_pengguna' => $ases['id_pengguna'],
                'nip' => $ases['nip'],
                'total_nilai' => $ases['total_nilai'],
                'periode' => $ases['periode']
            ]);
        } else {
            AsesmenModel::create(
                [
                    'id_pegawai' => $ases['id_pegawai'],
                    'id_pengguna' => $ases['id_pengguna'],
                    'nip' => $ases['nip'],
                    'total_nilai' => $ases['total_nilai'],
                    'periode' => $ases['periode']
                ]
            );
        }
    }

    public function addDataAses()
    {
        //$data = PegawaiData::where('id_pegawai', '=', 22867)->first();
        //
        $api = new DaftarApi();
        $ases = $api->apiAsesmen(10, 'semua');
        if ($ases['result'] == 1) {
            foreach ($ases['data'] as $asdata) {
                $this->addSatuDataAses($asdata['data']);
            }
            return redirect('/sinkronisasi')->with('message', 'Pengambilan Data Asesmen berhasil dilakukan.');
        } else {
        }
        // }


    }
}
