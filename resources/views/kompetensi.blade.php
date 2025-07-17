@extends('widget/main')
@section('container')
<div class="container">
    <div class="row align-items-center">
        <div class="card-header">
            <h4>Data Kompetensi</h4>
        </div>
        <div class="row align-items-center">
            <div class="card-body">
                <form action="/filterpegkomp" method="POST">
                    @csrf
                    <table width="100%" cellpadding='3px'>
                        <tr>
                            <td width="50%"><input type="text" name="nampeg" id="nampeg" placeholder="Nama Pegawai" class="form-control" /></td>
                            <td width="50%"><input type="text" name="nip" id="nip" placeholder="NIP Pegawai" class="form-control" /></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="jabatan" placeholder="Jabatan" id="jabatan" class="form-control" /></td>
                            <td><input type="text" name="skpd" id="skpd" placeholder="SKPD" class="form-control" /></td>
                        </tr>
                        <tr>
                            <td><button type="submit" class="btn btn-primary">Filter</button></td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="card-body" style="padding-top:25px;">
                <h4>Daftar Pegawai</h4>
                <table width="100%" class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <td>No.</td>
                            <td>Nama</td>
                            <td>NIP</td>
                            <td>Jabatan</td>
                            <td>SKPD</td>
                            <td>&nbsp;</td>
                        </tr>
                    </thead>
                    <tbody>
                        @if($pegawais=='')
                        <tr>
                            <td colspan="6" style="text-align:center;">Data Tidak Ditemukan</td>
                        </tr>
                        @else
                        @php $no=1; @endphp
                        @foreach($pegawais as $pegawai)
                        <tr>
                            <td width="3%" style="padding:5px;">{{$no}}</td>
                            <td width="18%" style="padding:5px;">{{$pegawai['nama_pegawai']}}</td>
                            <td width="17%" style="padding:5px;">{{$pegawai['nip']}}</td>
                            <td width="15%" style="padding:5px;">{{$pegawai['jabatan']}}</td>
                            <td width="20%">{{$pegawai['skpd']}}</td>
                            <td width="5%"><a href='{{route("kompeg",[$pegawai["id_pegawai"]])}}' class="btn btn-info" title="pilih ini"><box-icon name="exit"><box-icon></a></td>
                        </tr>
                        @php $no++; @endphp
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // alert('tes');
    });
</script>
@endsection