<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AspekNilai extends Model
{
    protected $table = 'tbl_aspek_nilai_pegawai';
    protected $primaryKey = 'id_nilai';
    protected $keyType = 'integer';
    protected $fillable = [
        'id_nilai',
        'id_target',
        'id_pegawai',
        'aspek_1',
        'aspek_2',
        'aspek_3',
        'aspek_4',
        'aspek_5',
        'aspek_6',
        'aspek_7',
        'aspek_8',
        'aspek_9',
        'indikator_2',
        'indikator_3',
        'indikator_4',
        'indikator_5',
        'indikator_6',
        'indikator_7',
        'indikator_8',
        'indikator_9',
        'indikator_10',
        'indikator_11',
        'indikator_12',
        'indikator_13'

    ];
    public $incrementing = true;
    public $timestamps = true;
}
