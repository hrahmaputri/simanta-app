<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Models\RefApi;
use Illuminate\Support\Facades\Http;

class DaftarApi extends Controller
{
    public function apiAllPegawai()
    {
        ini_set('max_execution_time', 0);
        $koneksi = RefApi::where('id', 1)->first();
        $url = $koneksi->url;

        $response = Http::timeout(120)->withOptions([
            'verify' => false,
        ])->asForm()->post($url, [
            'username' => $koneksi->username,
            'password' => $koneksi->password,
            'category' => 'DATA_SEMUA_PEGAWAI'

        ]);

        $dataall = $response->json()['data'];

        return $dataall;
    }

    public function apiPegawai(string $field, string $value)
    {
        $koneksi = RefApi::where('id', 1)->first();
        $url = $koneksi->url;

        $response = Http::withOptions([
            'verify' => false,
        ])->asForm()->post($url, [
            'username' => $koneksi->username,
            'password' => $koneksi->password,
            'category' => 'DATA_PEGAWAI',
            'filter_field' => $field,
            'filter_value' => $value
        ]);

        $datapeg = $response->json()['data'];

        return $datapeg;
    }

    public function apiJabatan() //jabatan lowong
    {
        $koneksi = RefApi::where('id', 1)->first();
        $url = $koneksi->url;

        $response = Http::withOptions([
            'verify' => false,
        ])->asForm()->post($url, [
            'username' => $koneksi->username,
            'password' => $koneksi->password,
            'category' => 'JABATAN_LOWONG'
        ]);

        $data = '';
        if ($response->successful()) {
            $data = $response->json()['data'];
        } else {
            // $error = $response->json()['data'];
            abort(500, 'API request failed');
        }

        return $data;
    }

    public function apiDatapribadi(string $id_pegawai)
    {
        $koneksi = RefApi::where('id', 1)->first();
        $url = $koneksi->url;

        $response = Http::withOptions([
            'verify' => false,
        ])->asForm()->post($url, [
            'username' => $koneksi->username,
            'password' => $koneksi->password,
            'category' => 'DATA_UTAMA',
            'id_pegawai' => $id_pegawai
        ]);

        $pribadi = $response->json()['data'];
        return $pribadi;
    }

    public function apiDiklat(string $id_pegawai) //cek jam jp
    {
        $koneksi = RefApi::where('id', 1)->first();
        $url = $koneksi->url;

        $response = Http::withOptions([
            'verify' => false,
        ])->asForm()->post($url, [
            'username' => $koneksi->username,
            'password' => $koneksi->password,
            'category' => 'DATA_DIKLAT',
            'id_pegawai' => $id_pegawai
        ]);

        $diklat = $response->json()['data'];
        return $diklat;
    }

    public function apiHukdis(string $id_pegawai) // cek hukdis filter
    {
        $koneksi = RefApi::where('id', 1)->first();
        $url = $koneksi->url;

        $response = Http::withOptions([
            'verify' => false,
        ])->asForm()->post($url, [
            'username' => $koneksi->username,
            'password' => $koneksi->password,
            'category' => 'DATA_HUKDIS',
            'id_pegawai' => $id_pegawai
        ]);

        $hukdis = $response->json()['data'];
        return $hukdis;
    }

    public function apiRiwayat(string $id_pegawai, string $category)
    {
        //RIWAYAT_DIKLAT, RIWAYAT_PENDIDIKAN,RIWAYAT_HUKDIS
        $koneksi = RefApi::find(1);
        $url = $koneksi->url;

        $response = Http::withOptions([
            'verify' => false,
        ])->asForm()->post($url, [
            'username' => $koneksi->username,
            'password' => $koneksi->password,
            'category' => $category,
            'id_pegawai' => $id_pegawai
        ]);

        $riwayat = $response->json()['data'];
        return $riwayat;
    }

    public function apiSimpel(string $id, string $segmen)
    {
        ini_set('max_execution_time', 0);
        $koneksi = RefApi::find(3);
        $urls = $koneksi->url;

        if ($segmen == 'pegawai') {
            $url = $urls . '/pegawai/' . $koneksi->password . '/' . $id; //id_pengguna
        } elseif ($segmen == 'skpd') {
            $url = $urls . '/skpd/' . $koneksi->password . '/' . $id; //id_skpd
        }

        $response = Http::withOptions([
            'verify' => false,
        ])->get($url);

        return $response->json();
    }

    public function apiAsesmen(string $id, string $segmen)
    {
        //{{BASE_URL}}/api/data-periode-asesmen/{{KEY}} ambil periode
        //{{BASE_URL}}/api/asesmen/pegawai/{{KEY}}/{{ID_PENGGUNA}} pegawai dgn periode terbaru
        //{{BASE_URL}}/api/asesmen/pegawai/{{KEY}}/{{ID_PENGGUNA}}/{{ID_PERIODE}} pegawai dgn periode ttt
        //{{BASE_URL}}/api/asesmen/skpd/{{KEY}}/{{ID_SKPD}} per skpd periode terbaru
        //{{BASE_URL}}/api/asesmen/skpd/{{KEY}}/{{ID_SKPD}}/{{ID_PERIODE}} per skpd periode ttt
        //{{BASE_URL}}/api/asesmen/semua/{{KEY}}/{{ID_PERIODE}} semua pegawai dgn periode ttt

        ini_set('max_execution_time', 0);
        $koneksi = RefApi::find(4);
        $urls = $koneksi->url;

        if ($segmen == 'pegawai') {
            $url = $urls . '/pegawai/' . $koneksi->password . '/' . $id; //id_pengguna
        } elseif ($segmen == 'skpd') {
            $url = $urls . '/skpd/' . $koneksi->password . '/' . $id; //id_skpd
        } elseif ($segmen == 'semua') {
            $id = 10;
            $url = $urls . '/semua/' . $koneksi->password . '/' . $id; //id_skpd
        }

        $response = Http::withOptions([
            'verify' => false,
        ])->get($url);

        return $response->json();
    }
}
