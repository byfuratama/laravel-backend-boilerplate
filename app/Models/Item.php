<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $table = 'item';
    
    protected $fillable = ['id','nama','kategori_id','status'];
    
    protected $hidden = ['deleted_at','created_at','updated_at'];

}
