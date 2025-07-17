<div>
    <!-- It is not the man who has too little, but the man who craves more, that is poor. - Seneca -->
    <div class="row">
        <div class="row-md-3">
            <label for="kode_skpd">Perangkat Daerah / Unit Kerja</label>
            <select id="kode_skpd" name="kode_skpd" class="form-control" />
            <option value="">:: Pilih Unit Kerja ::</option>
            @foreach ($dskpd as $instansi)
            <option value="{{$instansi->kode_skpd}}">{{$instansi->skpd}}</option>
            @endforeach
            </select>
        </div>
        <br>
        <!--<div class="row-md-3">
            <label for="jabatan">Jabatan</label>
            <select id="id_jabatan" name="id_jabatan" class="form-control" />
            <option value="0">:: Pilih Jabatan ::</option>
            @foreach ($refjab as $jabs)
            <option value="{{$jabs->id_jabatan}}">{{$jabs->jabatan}}</option>
            @endforeach
            </select>
        </div>-->
        <div class="row-md-3" style='padding-top:10px;'>
            <input type="button" class="btn btn-success" value="Filter" onclick="getData()" />
        </div>
    </div>
</div>