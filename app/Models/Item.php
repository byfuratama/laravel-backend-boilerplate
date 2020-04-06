<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'item';
    
    protected $fillable = ['id','nama','kategori_id','status'];
    
    protected $hidden = ['created_at','updated_at'];

}
