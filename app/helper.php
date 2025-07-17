<?php


use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Session;


function getPengguna($id_user)
{
    if (session('id_user') == null) {
        //no action
    } else {
        $data = User::where('id', '=', $id_user)
            ->first();

        return $data->name;
    }
}

function getNamaLengkap($nama, $gelar_depan = null, $gelar_belakang = null)
{
    if ($gelar_depan != null && $gelar_belakang != null) {
        $nama_lengkap = $gelar_depan . '. ' . $nama . ' ' . $gelar_belakang . ',';
    } elseif ($gelar_depan == null && $gelar_belakang != null) {
        $nama_lengkap = $nama . ' ' . $gelar_belakang . ',';
    } elseif ($gelar_depan != null) {
        $nama_lengkap = $gelar_depan . '. ' . $nama;
    } else {
        $nama_lengkap = $nama;
    }
    return $nama_lengkap;
}
