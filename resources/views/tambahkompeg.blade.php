@extends('widget/main')
@section('container')
<div class="container">
    <div class="row align-items-center">
        <div class="row align-items-center">
            <div class="card-body">
                <table class="table table bordered" width="50%" border='1px' cellpadding='0' cellspacing='0'>
                    <tr>
                        @if($id_kompeg==0)
                        <td style="background-color:rgb(90, 139, 208);">Tambah Kompetensi Pegawai {{$pegawai->nama_pegawai}} ({{$pegawai->nip}})</td>
                        @else
                        <td style="background-color:rgb(90, 139, 208);">Edit Kompetensi Pegawai {{$pegawai->nama_pegawai}} ({{$pegawai->nip}})</td>
                        @endif
                    </tr>
                </table>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form action="/inputkompeg" method="POST">
                    @csrf
                    <table width="80%" style='margin-bottom:15px;'>
                        <tr>
                            <td width='25%' style='text-align:center;'><label for="id_pegawai">Jabatan Target Eselon</label></td>
                            <td width='10%' style='text-align:center;'>:</td>
                            <td width='40%'>
                                <select class="form-control" id="level_eselon" name="level_eselon" aria-label="Default select example">
                                    <option value="">Pilih Level Eselon</option>
                                    @if($id_kompeg==0)
                                    <option value="2">Eselon II</option>
                                    <option value="3">Eselon III</option>
                                    <option value="4">Eselon IV</option>
                                    @else
                                    <option value="2" {{$data->level_eselon==2 ? 'selected':''}}>Eselon II</option>
                                    <option value="3" {{$data->level_eselon==3 ? 'selected':''}}>Eselon III</option>
                                    <option value="4" {{$data->level_eselon==4 ? 'selected':''}}>Eselon IV</option>
                                    @endif
                                </select>
                            </td>
                        </tr>
                    </table>
                    <table width="80%" style="border: 0px solid rgba(49, 37, 37, 0.65);" cellpadding='0' cellspacing='0'>
                        <input type="hidden" id="id_pegawai" width="50px" name="id_pegawai" value="{{$id_pegawai}}" />
                        <input type="hidden" id="id_kompeg" width="50px" name="id_kompeg" value="{{$id_kompeg}}" />
                        <thead>
                            <tr>
                                <td width='5%' style='text-align: center;'>No</td>
                                <td width='25%'>Aspek Penilaian</td>
                                <td width='25%' style='text-align: center;'>Nilai</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($aspek as $idx=>$asp)
                            <tr>
                                <td width='5%' style='text-align: center;'>{{$idx+1}}</td>
                                <td width='20%'>{{$asp->aspek_tingkatan}}</td>
                                @if($id_kompeg==0)
                                <td width='25%'><input type="number" max="4" min="0" class="form-control" id="nilai_{{$asp->id_aspek}}" width="50px" name="nilai_{{$asp->id_aspek}}" /></td>
                                @else
                                @php $naspek = $data->{'aspek_'.$asp->id_aspek} @endphp
                                <td width='25%'><input type="number" max="4" min="0" class="form-control" id="nilai_{{$asp->id_aspek}}" width="50px" name="nilai_{{$asp->id_aspek}}" value="{{$naspek}}" /></td>
                                @endif
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="3" style="text-align:center;padding-top:10px;padding-bottom:10px;">
                                    <button type="submit" class="btn btn-primary" id="simpanKompetensi">Simpan Nilai</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection