@extends('widget/main')
@section('container')
<div class="container">
    <div class="row align-items-center">
        <form action="/inputnilai" method="POST">
            @csrf
            <div class="card-body" style="padding-top:40px;">
                <table class="table table bordered" width="100%" border='1px' cellpadding='0' cellspacing='0'>
                    @foreach($peg as $pegawai)
                    <tr>
                        <td width='20%'>Jabatan Target</td>
                        <td width='5%'>:</td>
                        <td width='75%'>{{$pegawai->jabatan_target}}</td>
                    </tr>
                    <tr>
                        <td width='20%'>Nama </td>
                        <td width='5%'>:</td>
                        <td width='75%'>{{$pegawai->nama}}</td>
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
                    <tr>
                        <td>Nilai Potensial</td>
                        <td>:</td>
                        <td>{{$pegawai->potensial}}</td>
                    </tr>
                    <tr>
                        <td>Nilai Kinerja</td>
                        <td>:</td>
                        <td>{{$pegawai->kinerja}}</td>
                    </tr>
                    @endforeach
                </table>
            </div>

            <!--nilai x potensial-->
            @foreach($hasil as $hasilpeg)
            <div class="card-body" style="padding-top:20px;">
                <h5>Data Potensial Pegawai</h5>
                <input type="hidden" name="id_peg_nilai" id="id_peg_nilai" value="{{$pegawai->id_nilai}}" />
                @php
                $i=1;
                @endphp

                @foreach($data as $nilai)

                <table id="potensial" width="100%" border='1px' cellpadding='0' cellspacing='0'>
                    <tr>
                        <td width="3%" style="padding:5px">{{$i}}.</td>
                        <td width="97%" style="padding:5px;">{{$nilai->nama}} ({{$nilai->bobot*100}}%)</td>
                    </tr>
                    <tr>
                        <table class="table table-bordered" width='100%'>
                            <thead>
                                <tr style="text-align:center;">
                                    <td width="3%">No.</td>
                                    <td width="28%">INDIKATOR</td>
                                    <td width="7%">BOBOT</td>
                                    @php if($nilai->nama=='Kompetensi'){ @endphp
                                    <td width="20%">ASPEK</td>
                                    <td width="7%">SKJ</td>
                                    <td width="6%">NILAI</td>
                                    <td width="4%">TOTAL</td>
                                    @php }else{ @endphp
                                    <td width="27%">TINGKATAN</td>
                                    <td width="10%">POIN/NILAI</td>
                                    @php } @endphp
                                    <td width="14%" colspan='2'>NILAI TALENTA</td>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $indikator = DB::table('tbl_indikator')->where('id_utama',$nilai->id)->get();
                                $j=1;
                                @endphp

                                @foreach($indikator as $ind)
                                @php
                                $aspek = DB::table('tbl_aspek_tingkatan')
                                ->where('id_indikator','=',$ind->id_indikator);

                                $rows=1;
                                if($aspek->where('jenis','=',1)->count()>1){
                                $rows = $aspek->where('jenis','=',1)->count();
                                }

                                $jenis = $aspek->pluck("jenis");
                                @endphp
                                <tr valign="top">
                                    <td rowspan={{$rows}} style="text-align:center;">{{$j}}.</td>
                                    <td rowspan={{$rows}}>{{$ind->indikator}}</td>
                                    <td rowspan={{$rows}} style="text-align:center;">
                                        {{$ind->bobot*100}}%
                                        <input type="hidden" id="bobot_{{$ind->id_indikator}}" name="bobot_{{$ind->id_indikator}}" value="{{$ind->bobot}}" />
                                    </td>

                                    @php
                                    $data_asp = $aspek->where('jenis','=',1)->get();
                                    @endphp

                                    @if($rows>1)
                                    <td colspan='3'>
                                        <table width='100%'>
                                            @foreach($data_asp as $idx=>$asp)
                                            @php
                                            $naspek = 0;
                                            $naspek = $hasilpeg->{'aspek_'.$asp->id_aspek};
                                            if($pegawai->eselon_target==3 || $pegawai->eselon_target==4){
                                            $asp->skj_poin = $asp->leveselon_2;
                                            }elseif($pegawai->eselon_target==5 || $pegawai->eselon_target==6){
                                            $asp->skj_poin = $asp->leveselon_3;
                                            }
                                            @endphp
                                            <tr>
                                                <td width="60%" style="padding-left:5px;">
                                                    {{$asp->aspek_tingkatan}}
                                                </td>
                                                <td width="20%">
                                                    <input type="number" readonly class="form-control" value="{{$asp->skj_poin}}" width="500px" id="poin{{$asp->id_aspek}}" name="poin" />
                                                </td>
                                                <td width="20%">
                                                    <input type="number" onblur="sumTotal()" class="aspect form-control" value="{{$naspek}}" width="500px" min="0" max="2" id="vAspek{{$asp->id_aspek}}" name="vAspek{{$asp->id_aspek}}" />
                                                </td>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </td>
                                    <td rowspan={{$rows}} style="text-align:center;">
                                        <input type="text" class="form-control" width="500px" readonly id="total_1" name="total_1" />
                                    </td>
                                    <td rowspan={{$rows}} style="text-align:center;">
                                        <input type="text" class="form-control" readonly id="nilai_{{$ind->id_indikator}}" width="50px" name="nilai_{{$ind->id_indikator}}" />
                                    </td>
                                    <td rowspan={{$rows}} style="text-align:center;">&nbsp;</td>

                                    @elseif($ind->id_indikator=='2' || $ind->id_indikator=='7' )
                                    @php

                                    $aspek2 = DB::table('tbl_aspek_tingkatan')
                                    ->where('id_indikator','=',$ind->id_indikator)->get();
                                    @endphp

                                    @foreach($aspek2 as $asp2)
                                    @php
                                    $npotensi = 0;
                                    $npotensi = $hasilpeg->{'indikator_'.$ind->id_indikator};
                                    @endphp
                                    <td rowspan={{$rows}} style="text-align:center;">{{$asp2->aspek_tingkatan}}</td>
                                    <td rowspan={{$rows}} style="text-align:center;">
                                        <input type="number" class="form-control" onblur="hitung_pp('{{$ind->id_indikator}}')" width="500px" value="{{$npotensi}}" min="0" max="1000" name="val_{{$ind->id_indikator}}" id="val_{{$ind->id_indikator}}" />
                                    </td>
                                    <td rowspan={{$rows}} style="text-align:center;">
                                        <input type="text" class="form-control" readonly id="nilai_{{$ind->id_indikator}}" width="50px" name="nilai_{{$ind->id_indikator}}" />
                                    </td>
                                    <td rowspan={{$rows}} style="text-align:center;">&nbsp;</td>
                                    @endforeach

                                    @else
                                    @php
                                    $ntingkatan = 0;
                                    $ntingkatan = $hasilpeg->{'indikator_'.$ind->id_indikator};
                                    @endphp
                                    <td rowspan={{$rows}} style="text-align:center;">
                                        <select onchange='hitpoin(this)' name="tingkatan_{{$ind->id_indikator}}" id="tingkatan_{{$ind->id_indikator}}" class="form-control">
                                            <option value="">:: Pilih ::</option>
                                            @foreach (${'tk_'.$ind->id_indikator} as $tks)
                                            <option value="{{$tks->id_aspek}}"
                                                {{ old('tingkatan_'.$ind->id_indikator, $ntingkatan) == $tks->id_aspek ? 'selected' : '' }}>{{$tks->aspek_tingkatan}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td rowspan={{$rows}} style="text-align:center;">
                                        <input type="text" class="form-control" readonly id="poin_{{$ind->id_indikator}}" width="50px" name="poin_{{$ind->id_indikator}}" />
                                    </td>
                                    <td rowspan={{$rows}} style="text-align:center;">
                                        <input type="text" class="form-control" readonly id="nilai_{{$ind->id_indikator}}" width="50px" name="nilai_{{$ind->id_indikator}}" />
                                    </td>
                                    <td rowspan={{$rows}} style="text-align:center;"><a href="/profil/{{$pegawai->id_nilai}}/ind/{{$ind->id_indikator}}" title="Cek Pegawai" class="btn btn-warning"><box-icon name="memory-card"></box-icon></a></td>
                                    @endif

                                </tr>
                                @php $j++; @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </tr>
                </table>
                @php $i++; @endphp
                @endforeach

            </div>

            <!--nilai y kinerja-->
            <div class="card-body" style="padding-top:20px;">
                <h5>Data Kinerja</h5>

                @foreach($datay as $idx=>$nilaiy)

                <table id="potensial" width="100%" border='1px' cellpadding='0' cellspacing='0'>
                    <tr>
                        <td width="3%" style="padding:5px">{{$idx+1}}.</td>
                        <td width="97%" style="padding:5px;">{{$nilaiy->nama}} ({{$nilaiy->bobot*100}}%)</td>
                    </tr>
                    <tr>
                        <table class="table table-bordered" width='100%'>
                            <thead>
                                <tr style="text-align:center;">
                                    <td width="3%">No.</td>
                                    <td width="28%">INDIKATOR</td>
                                    <td width="7%">BOBOT</td>
                                    <td width="27%">TINGKATAN</td>
                                    <td width="10%">POIN</td>
                                    <td width="14%">NILAI TALENTA</td>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $indikatory = DB::table('tbl_indikator')->where('id_utama',$nilaiy->id)->get();
                                $rows = 1;
                                @endphp
                                @foreach($indikatory as $jy=>$indy)

                                @php
                                $ntingkatany = 0;
                                $ntingkatany = $hasilpeg->{'indikator_'.$indy->id_indikator};
                                @endphp

                                <tr valign="top">
                                    <td rowspan={{$rows}} style="text-align:center;">{{$jy+1}}.</td>
                                    <td rowspan={{$rows}}>{{$indy->indikator}}</td>
                                    <td rowspan={{$rows}} style="text-align:center;">
                                        {{$indy->bobot*100}}%
                                        <input type="hidden" id="bobot_{{$indy->id_indikator}}" name="bobot_{{$indy->id_indikator}}" value="{{$indy->bobot}}" />
                                    </td>

                                    @if($indy->id_indikator!=12)
                                    <td rowspan={{$rows}} style="text-align:center;">
                                        <select onchange='hitpoin(this)' name="tingkatan_{{$indy->id_indikator}}" id="tingkatan_{{$indy->id_indikator}}" class="form-control">
                                            <option value="">:: Pilih ::</option>
                                            @foreach (${'tk_'.$indy->id_indikator} as $tky)
                                            <option value="{{$tky->id_aspek}}"
                                                {{ old('tingkatan_'.$indy->id_indikator, $ntingkatany) == $tky->id_aspek ? 'selected' : '' }}>{{$tky->aspek_tingkatan}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td rowspan={{$rows}} style="text-align:center;">
                                        <input type="text" class="form-control" readonly id="poin_{{$indy->id_indikator}}" width="50px" name="poin_{{$indy->id_indikator}}" />
                                    </td>

                                    @else
                                    <td rowspan={{$rows}} style="text-align:center;">
                                        @foreach(${'tk_'.$indy->id_indikator} as $tky)
                                        {{$tky->aspek_tingkatan}}
                                        @endforeach
                                    </td>

                                    @php
                                    $np360 = 0;
                                    $np360 = $hasilpeg->{'indikator_'.$indy->id_indikator};
                                    @endphp
                                    <td rowspan={{$rows}} style="text-align:center;">
                                        <input type="text" class="form-control" value="{{$np360}}" onblur="hitung_pp(12)" id="val_{{$indy->id_indikator}}" width="50px" name="val_{{$indy->id_indikator}}" />
                                    </td>

                                    @endif

                                    <td rowspan={{$rows}} style="text-align:center;">
                                        <input type="text" class="form-control" readonly id="nilai_{{$indy->id_indikator}}" width="50px" name="nilai_{{$indy->id_indikator}}" />
                                    </td>
                                    @endforeach
                            </tbody>
                        </table>
                    </tr>
                </table>
                @endforeach
            </div>
            @endforeach
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        sumTotal();
        hitung_pp(2);
        hitung_pp(7);
        hitung_pp(12);
        isioption();
    });

    function isioption() {
        n = 13;
        for (var i = 3; i <= n; i++) {
            if (i != 12 && i != 7) {
                var id_option = document.getElementById('tingkatan_' + i);
                hitpoin(id_option);
            }
        }

    }

    function sumTotal() {
        var arr = document.getElementsByClassName('aspect');
        var poin = document.getElementsByName('poin');
        var ntotal = 0;
        var bobot = parseFloat(document.getElementById('bobot_1').value);
        var sum_poin = 0;
        for (var j = 0; j < poin.length; j++) {
            if (parseInt(poin[j].value))
                sum_poin += parseInt(poin[j].value);
        }

        var sum_val = 0;
        for (var i = 0; i < arr.length; i++) {
            if (parseInt(arr[i].value))
                sum_val += parseInt(arr[i].value);
        }
        ntotal = (sum_val / sum_poin) * 100;
        ntalenta = ntotal * bobot;
        document.getElementById('total_1').value = ntotal;
        document.getElementById('nilai_1').value = ntalenta.toFixed(2);;
    }

    function hitung_pp(id) {
        var npotensi = parseInt(document.getElementById('val_' + id).value);
        var bobot = parseFloat(document.getElementById('bobot_' + id).value);
        ntalenta2 = npotensi * bobot;
        document.getElementById('nilai_' + id).value = ntalenta2.toFixed(2);
    }

    function hitpoin(selectedValue) {
        var id_aspek = selectedValue.value;
        $.ajax({
            url: '/datapoin',
            method: 'GET',
            dataType: 'json',
            data: 'id_aspek=' + id_aspek,
            success: function(r) {
                const poin = r.data.poin;
                const id = r.data.id_indikator;
                const bobot = r.data.bobot;
                var ntalenta = poin * bobot;
                //alert(r.data.skj_poin);
                document.getElementById('poin_' + id).value = poin;
                document.getElementById('nilai_' + id).value = ntalenta.toFixed(2);
            },
            error: function(error) {
                console.log(error);
            }
        });
    }
</script>
@endsection