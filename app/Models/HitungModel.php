<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HitungModel extends Model
{
    protected $table = 'tbl_perhitungan';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    protected $fillable = [
        'id',
        'id_pegawai',
        'potensial_x',
        'kinerja_y'
    ];

    public $incrementing = true;
    public $timestamps = true;
}
