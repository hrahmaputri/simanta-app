<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AspekModel extends Model
{
    protected $table = 'tbl_aspek_tingkatan';
    protected $primaryKey = 'id_aspek';
    protected $keyType = 'integer';

    public $incrementing = true;
    public $timestamps = true;
}
