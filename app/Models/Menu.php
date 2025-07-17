<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'ref_menu';
    protected $primaryKey = 'id_menu';
    protected $keyType = 'integer';
    public $incrementing = true;
    public $timestamps = true;
}
