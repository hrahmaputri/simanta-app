@extends('widget/main')
@section('container')
<div class="container">
    <div class="row align-items-center">
        <div class="card-header">
            <h4>Data Indikator Manajemen Talenta</h4>
        </div>
        <div class="row align-items-center">
            <div class="card-body">
                <form action="/ubahindikator" method="POST">
                    @csrf
                    <table width="100%" class="table table-bordered" id="dataTable">
                        <thead>
                            <tr>
                                <td width='5%'>No.</td>
                                <td width='55%'>Nama Indikator</td>
                                <td width='30%'>Bobot</td>
                                <td width='10%'>Sumbu</td>
                            </tr>

                        </thead>
                        <tbody>
                            @foreach ($penilaian as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->nama }}</td>
                                <td width='30%'><input type="number" onblur="sumBobot()" class='bobot' width='20px' id="bobot_{{$item->id}}" name="bobot_{{$item->id}}" value="{{$item->bobot*100}}">%</td>
                                <td>
                                    <input type="radio" class="sumbu" onblur="sumBobot()" id="sumbu_{{$item->id}}" name="sumbu_{{$item->id}}" value="1" {{ $item->sumbu == 1 ? 'checked':'' }}>X
                                    &nbsp;&nbsp;
                                    <input type="radio" class="sumbu" onblur="sumBobot()" id="sumbu_{{$item->id}}" name="sumbu_{{$item->id}}" value="2" {{ $item->sumbu == 2 ? 'checked':''}}>Y
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <ul>
                                        @foreach (${'indikator_'.$item->id} as $ind)
                                        <li>{{$ind->indikator}}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td width='30%'>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        sumBobot();
    });

    function sumBobot() {
        var bobot = document.getElementsByClassName('bobot');
        var sum_bobotx = 0;
        var sum_boboty = 0;
        var nilai_sumbu = 0;
        for (var j = 0; j < bobot.length; j++) {
            param = 'sumbu_' + (j + 1);
            const sumbus = document.querySelectorAll('input[name=param]');
            if (parseInt(bobot[j].value)) {
                for (const sumbu of sumbus) {
                    if (sumbu.checked) {
                        nilai_sumbu = sumbu.value;
                        if (nilai_sumbu = 1) {
                            sum_bobotx += parseInt(bobot[j].value);
                        } else {
                            sum_boboty += parseInt(bobot[j].value);
                        }
                    }
                }
            }
        }

        // alert('Total bobot sumbu X ' + sum_bobotx + 'dan Y ' + sum_boboty + nilai_sumbu + 'harus tepat 100%');

    }
</script>
@endsection