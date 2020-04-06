<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    
    protected $fillable = ['id','nama','keterangan'];
    
    protected $hidden = ['created_at','updated_at'];

}
