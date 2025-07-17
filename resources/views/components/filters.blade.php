<div>
    <!-- It is not the man who has too little, but the man who craves more, that is poor. - Seneca -->
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