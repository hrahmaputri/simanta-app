<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;


class UserController extends Controller
{
    public function index()
    {
        return response()->view('login', [
            "title" => "Login"
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $id = Auth::user()->id;
            $id_akses = Auth::user()->id_akses;
            Session::put("id_user", $id);
            Session::put("id_akses", $id_akses);

            return redirect('/');
        }

        return back()->withErrors('Username atau Password anda salah.')->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Session::flush();
        return redirect('/');
    }

    public function editpass()
    {
        //helper::permission();
        $id_user = Session::get("id_user");
        $user = Pengguna::where('id', $id_user)->first();
        return response()->view('editpass', [
            "title" => "Edit Password",
            "user" =>   $user
        ]);
    }

    public function changepass(Request $request)
    {
        $password   = $request->input('password');
        $id_user = Session::get("id_user");
        // $user = Pengguna::update('id', $id_user)->first();
        return response()->view('editpass', [
            "title" => "Edit Password",
            "user" =>   "data"
        ]);
    }

    /*public function getSubmenu(string $id_menu)
    {
        $data = SubMenu::where('id_menu', '=', $id_menu)
            ->where('aktif', '=', 0)
            ->get();

        return
            $html = ("<ul class='feat-show'>");
        foreach ($data as $subbar) {
            $html .=
                ('<li><a href=');
            $subbar['url'];
            echo ('>');
            $subbar['sub_menu'];
            echo ('</a></li>');
        }
        echo ('</ul>');
    }*/
}
