@extends('widget/main')
@section('container')
<div class="container">
    <div class="row align-items-center">
        <div class="card-body">
            <!--<button width="50px" type="button" class="btn btn-warning">Kembali</button>-->
            <h4>Sinkronisasi Data</h4>
            <form action="/#" method="POST">
                @csrf
                <table width="100%" cellpadding='3px'>
                    <tr>
                        <td width="5%">1.</td>
                        <td width="40%">Sinkronisasi Data Seluruh Pegawai</td>
                        <td width="55%"><a href='{{route("semuaDapeg")}}' class="btn btn-warning">Sinkron Semua Pegawai</a></td>
                    </tr>
                    <tr>
                        <td>2.</td>
                        <td>Sinkron Data Pegawai Tertentu</td>
                        <td><a href='{{route("viewSatuPegawai")}}' class="btn btn-warning">Sinkron Satu Pegawai</a></td>
                    </tr>
                    <tr>
                        <td>3.</td>
                        <td>Pengambilan Data Penilaian 360</td>
                        <td><a href='{{route("simpelData")}}' class="btn btn-warning">Semua Pegawai</a></td>
                    </tr>
                    <tr>
                        <td>4.</td>
                        <td>Pengambilan Data Asesmen</td>
                        <td><a href='{{route("asesData")}}' class="btn btn-warning">Semua Pegawai</a></td>
                    </tr>
                </table>
            </form>
        </div>


    </div>
</div>
<script>
    $(document).ready(function() {
        // alert('tes');
    });
</script>
@endsection