<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyaratJabatan extends Model
{
    protected $table = 'tbl_syarat_jabatan';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';
    public $incrementing = true;
    public $timestamps = true;
}
