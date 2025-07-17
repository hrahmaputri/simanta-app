<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KompetensiModel extends Model
{
    protected $table = 'tbl_kompetensi';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    protected $fillable = [
        'id',
        'id_pegawai',
        'level_eselon',
        'aspek_1',
        'aspek_2',
        'aspek_3',
        'aspek_4',
        'aspek_5',
        'aspek_6',
        'aspek_7',
        'aspek_8',
        'aspek_9'

    ];

    public $incrementing = true;
    public $timestamps = true;
}
