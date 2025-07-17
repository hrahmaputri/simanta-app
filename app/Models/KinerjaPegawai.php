<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KinerjaPegawai extends Model
{
    protected $table = 'tbl_kinerja_pegawai';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    public $incrementing = true;
    public $timestamps = true;
}
