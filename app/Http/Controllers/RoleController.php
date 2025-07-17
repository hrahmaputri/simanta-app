<?php

namespace App\Http\Controllers;

use App\Models\Fungsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class RoleController extends Controller
{
    public function home(Request $request)
    {
        if ($request->session()->exists("id_user")) {
            $id_pegawai = Session::get("id_user");
            return view("utama", [
                'title' => 'Home'
            ]);
        } else {
            return redirect('/login');
        }
    }

    public function sekilas()
    {
        return view("overview", [
            'title' => 'Overview'
        ]);
    }

    public function pegawai()
    {
        return view("datapegawai", [
            'title' => 'Data Pegawai'
        ]);
    }
}
