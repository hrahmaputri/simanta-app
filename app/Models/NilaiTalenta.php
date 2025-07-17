<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiTalenta extends Model
{
    protected $table = 'tbl_nilai_talenta';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    protected $fillable = [
        'id',
        'id_pegawai',
        'ind_1',
        'ind_2',
        'ind_3',
        'ind_4',
        'ind_5',
        'ind_6',
        'ind_7',
        'ind_8',
        'ind_9',
        'ind_10',
        'ind_11',
        'ind_12',
        'ind_13'
    ];

    public $incrementing = true;
    public $timestamps = true;
}
