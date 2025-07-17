@extends('widget/main')
@section('container')
<div class="container">
    <h5>Pemilihan Jabatan Target</h5><br>
    <div class="panelcontainer">
        <div class="row align-items-center">
            <form action="/addjabtarget" method="POST">
                @csrf
                <div class="bodypanel">
                    <div class="row">
                        <div class="row-md-3">
                            <label for="jabatan">Jabatan</label>
                            <select id="id_jabatan" name="id_jabatan" class="form-control" />
                            <option value="0">:: Pilih Jabatan ::</option>
                            @foreach ($refjab as $jabs)
                            <option value="{{$jabs['id_jabatan']}}">{{$jabs['jabatan']}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row-md-3" style='padding-top:10px;'>
                    <input type="submit" class="btn btn-primary" value="Pilih" />
                </div>
            </form>
        </div>
    </div>
</div>
<div class="container">
    <div class="card-body" style="padding-top:20px;">
        <h5>Daftar Nama Jabatan Target</h5>
        <table class="table table bordered" width="100%" border='1px' cellpadding='0' cellspacing='0'>
            <thead>
                <tr style="text-align:center;">
                    <td width="3%">No.</td>
                    <td width="15%">Tanggal Buat</td>
                    <td width="28%">Nama Jabatan</td>
                    <td width="20%">SKPD</td>
                    <!--<td width="20%">Eselon</td>-->
                    <td width="7%">&nbsp;</td>
                    <td width="7%">&nbsp;</td>
            </thead>
            <tbody>
                @foreach ($data as $key => $value)
                <tr style="text-align:center;">
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $value->tanggal }}</td>
                    <td>{{ $value->jabatan }}</td>
                    <td>{{ $value->skpd }}</td>
                    <!-- <td>{{ $value->eselon }}</td>-->
                    <td><a href="{{route('hapusTarget', [$value->id_target])}}" class="btn btn-primary">Hapus</a></td>
                    <td>
                        @if($value->filter == 1)
                        Pegawai telah tersedia
                        @else
                        <a href="{{route('generate', [$value->id_target])}}" class="btn btn-warning">Filter Pegawai</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>
@endsection