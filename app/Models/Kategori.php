<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \App\Helpers\ModelHelper;
    protected $table = 'kategori';
    
    protected $fillable = ['id','nama','keterangan'];
    
    protected $hidden = ['deleted_at','created_at','updated_at'];

}
