@extends('widget/main')
@section('container')
<div class="container">
    <div class="row align-items-center">
        <div class="card-header">
            <form action="/pilihtarget" method="POST">
                @csrf
                <table width="100%" cellpadding='3px'>
                    <tr>
                        <td width="70%">
                            <select id="id_tarjab" name="id_tarjab" class="form-control" />
                            <option value="0">:: Pilih Jabatan Target::</option>
                            @foreach ($jabtarget as $target)
                            <option value="{{$target['id_target']}}">{{$target['tanggal']." | ".$target['jabatan']}}</option>
                            @endforeach
                            </select>
                        </td>
                        <td width="30%"></td>
                    </tr>
                    <tr>
                        <td width="70%">
                            <select id="id_seleksi" name="id_seleksi" class="form-control" />
                            <option value="0">Semua Pegawai</option>
                            <option value="1">Pegawai sedang menjabat setara eselon target atau eselon diatasnya</option>
                            <option value="2">Pegawai tidak sedang menjabat setara eselon target atau eselon diatasnya</option>
                            </select>
                        </td>
                        <td width="30%"></td>
                    </tr>
                    <tr>
                        <td colspan='2'>
                            <input type="submit" class="btn btn-primary" value="Tampilkan Pegawai" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <div class="card-header" style="padding-top:20px;">
            @if($id_target >0)
            <h5>Data Pegawai</h5>
            <table width="100%" cellpadding='3px' style="font-size:15px;">
                <tr>
                    <td width='18%'>Jabatan target</td>
                    <td width='2%'>:</td>
                    <td width='80%'> {{$jabmuncul->jabatan}}</td>
                </tr>
                <tr>
                    <td width='18%'>Tanggal Assesmen</td>
                    <td width='2%'>:</td>
                    <td width='80%'> {{$jabmuncul->tanggal}}</td>
                </tr>
                <tr>
                    <td width='18%'>Pendidikan Terkait</td>
                    <td width='2%'>:</td>
                    <td width='80%'>
                        @foreach($syaratpend as $sp)
                        {{$sp->pendidikan.", "}}
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td colspan='3' style='text-align:right;'>
                        <a type="button" href="{{route('tambahPegawai')}}" class="btn btn-primary">Tambah Pegawai</a>
                    </td>
                </tr>
            </table>

            @endif
        </div>

        <div class="card-body" style="padding-top:20px;">
            <table width="100%" class="table table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <td width="3%">No.</td>
                        <td width="15%">Nama</td>
                        <td width="10%">NIP</td>
                        <td width="7%">Jabatan</td>
                        <td width="20%">SKPD</td>
                        <td width="5%">&nbsp;</td>
                        <td width="5%">&nbsp;</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dapeg as $index => $pegawai)
                    <tr>
                        <td style="padding:5px;">{{$index+1}}</td>
                        <td style="padding:5px;">{{$pegawai->nama}}</td>
                        <td style="padding:5px;">{{$pegawai->nip}}</td>
                        <td style="padding:5px;">{{$pegawai->jabatan}} {{ $pegawai->id_jenjang_jabfung!=0 ? $pegawai->id_jenjang_jabfung:''}}</td>
                        <td>{{$pegawai->skpd}}</td>
                        <td><a href='{{route("nilaiPegawai",[$pegawai->id_nilai])}}' class="btn btn-info">Nilai</a></td>
                        <td><a href='{{route("hapusPegawai",[$pegawai->id_nilai])}}' class="btn btn-warning">Hapus</a></td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        // alert('tes');
    });
</script>
@endsection