<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="/bootstrap-5.3.3-dist/css/bootstrap.css" rel="stylesheet">
    <link href="/css/stylelogin.css" rel="stylesheet">
    <script src="/bootstrap-5.3.3-dist/js/bootstrap.js"></script>

</head>

<body>
    <div class="split right">
        <div class="col-md-12" style="width:95%;">
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <td width="20%" rowspan='3' style="padding-left:30px;"><img src="img/Logo.png" width="70%" /></td>
                    <td class="inti" width="80%" style="border-bottom:5px;border-color:white">
                        SISTEM INFORMASI MANAJEMEN TALENTA<br>
                        <div style='font-size:20px'>BADAN KEPEGAWAIAN DAN PSDM KOTA MEDAN</div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-md-6 centered" style="width:60%;">
            @if($errors->any())
            <div class="row">
                @foreach ($errors->all() as $error)
                <div class="alert alert-danger" role="alert">
                    <h6>{{ $error }}</h6>
                </div>
                @endforeach
            </div>
            @endif
            <form class="p-5 p-md-5 inp" width="80%" method="post" action="/login">
                @csrf
                <div class="form-floating mb-3 lg-4">
                    <input name="email" type="text" class="form-control" required id="email" placeholder="id">
                    <label for="user">User</label>
                </div>
                <div class="form-floating mb-3 lg-4">
                    <input name="password" type="password" class="form-control" required id="password" placeholder="password">
                    <label for="password">Password</label>
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit">Sign In</button>
            </form>
        </div>
    </div>
</body>