<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Indikator extends Model
{
    protected $table = 'tbl_indikator';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    public $incrementing = true;
    public $timestamps = true;
}
