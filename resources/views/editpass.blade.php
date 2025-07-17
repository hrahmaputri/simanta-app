@extends('widget/main')
@section('container')
<div class="container">
    <div class="row align-items-center">
        <form action="/changepass" method="POST">
            <div class="card-header">
                <h4>Edit Password Pengguna</h4>
            </div>
            @csrf
            <div class="card-body" style="padding-top:40px;">
                <table width="100%">
                    <tr>
                        <td width="30%" style="padding:5px;"><label for="name" class="form-label">Username</label></td>
                        <td width="40%" style="padding:5px;"><input type="text" class="form-control" id="username" name="username" value="{{$user->username}}" readonly></td>
                        <td width="30%"></td>
                    </tr>
                    <tr>
                        <td width="30%" style="padding:5px;"><label for="pass" class="form-label">Masukkan Password</label></td>
                        <td width="40%" style="padding:5px;"><input type="password" class="form-control" id="password" name="password">
                            <input type="checkbox" onclick="cek1()"><label>Tampilkan Password</label>
                        </td>
                        <td width="30%"></td>
                    </tr>
                    <tr>
                        <td width="30%" style="padding:5px;"><label for="pass2" class="form-label">Masukkan Ulang Password</label></td>
                        <td width="40%" style="padding:5px;"><input type="password" class="form-control" id="password2" name="password2">
                            <input type="checkbox" onclick="cek2()"><label>Tampilkan Password</label>
                        </td>
                        <td width="30%"></td>
                    </tr>
                    <tr>
                        <td width="30%" style="padding-top:20px;"><button type=" submit" class="btn btn-success">Simpan</button></td>
                        <td colspan="2"></td>
                    </tr>
                </table>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        // alert('tes');
    });

    function cek1() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

    function cek2() {
        var y = document.getElementById("password2");
        if (y.type === "password") {
            y.type = "text";
        } else {
            y.type = "password";
        }
    }
</script>
@endsection