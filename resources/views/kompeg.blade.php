@extends('widget/main')
@section('container')
<div class="container">
    <div class="row align-items-center">

        <div class="row align-items-center">
            <div class="card-body">
                <table class="table table bordered" width="100%" border='1px' cellpadding='0' cellspacing='0'>
                    <tr>
                        <td width='20%'>Nama </td>
                        <td width='5%'>:</td>
                        <td width='75%'>{{$pegawai->nama_pegawai}}</td>
                    </tr>
                    <tr>
                        <td>NIP</td>
                        <td>:</td>
                        <td>{{$pegawai->nip}}</td>
                    </tr>
                    <tr>
                        <td>Jabatan</td>
                        <td>:</td>
                        <td>{{$pegawai->jabatan}}</td>
                    </tr>
                    <tr>
                        <td>SKPD</td>
                        <td>:</td>
                        <td>{{$pegawai->skpd}}</td>
                    </tr>
                </table>

            </div>
            <div class="card-body" style="padding-top:15px;">
                <div class="card-header">
                    <h4>Data Kompetensi Pegawai</h4>
                    <a href='{{route("tambahKompetensi",[$pegawai->id_pegawai,0])}}' class="btn btn-info">
                        <box-icon name="plus-medical" size="xs"></box-icon>&nbsp;Tambah Kompetensi
                    </a>
                </div>

                <table width="100%" class="table table-bordered" id="dataTable" style="margin-top:15px;">
                    <thead>
                        <tr>
                            <td>No.</td>
                            <td>Tanggal Input Data</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $idx=>$komp)
                        <tr>
                            <td width="3%" style="padding:5px;">{{$idx+1}}</td>
                            <td width="18%" style="padding:5px;">{{$komp['created_at']}}</td>

                            <td width="5%"><a href='{{route("tambahKompetensi",[$pegawai->id_pegawai,$komp["id"]])}}' class="btn btn-success" width='50%'><box-icon name="edit" size="sm"></box-icon>&nbsp;Edit</a></td>
                            <td width="5%"><a href='{{route("hapusKompeg",[$pegawai->id_pegawai,$komp["id"]])}}' class="btn btn-warning" width='50%'><box-icon name="trash" size="sm"></box-icon>&nbsp;Hapus</a></td>
                        </tr>

                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection