<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefSkpd extends Model
{
    protected $table = 'ref_skpd';
    protected $primaryKey = 'id_skpd';
    protected $keyType = 'integer';
    public $incrementing = true;
    public $timestamps = true;
}
