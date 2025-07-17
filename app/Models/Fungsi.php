<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\GrupPengguna;
use App\Models\Pengguna;

class Fungsi extends Model
{
    public function getMenu($id_pegawai)
    {
        $data = GrupPengguna::leftJoin('ref_menu_utama', 'tbl_atur_pengguna.id_menu_utama', '=', 'ref_menu_utama.id_utama')
            ->select('ref_menu_utama.menu_utama', 'tbl_atur_pengguna.id_menu_utama')
            ->where('tbl_atur_pengguna.id_pegawai', '=', $id_pegawai)
            ->get();

        return $data;
    }

    public function getMenuName($id_utama)
    {
        $data = Menu::leftJoin('ref_menu_utama', 'ref_menu_utama.id_utama', '=', 'ref_menu.id_utama')
            ->where('ref_menu.id_utama', '=', $id_utama)
            ->where('ref_menu.aktif', '=', 0)
            ->first();

        return $data->menu_utama;
    }
}
