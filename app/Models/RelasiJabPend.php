<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RelasiJabPend extends Model
{
    protected $table = 'tbl_relasi_jab_pend';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';
    public $incrementing = true;
    public $timestamps = true;
}
