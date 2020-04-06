<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemSatuan extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $table = 'item_satuan';
    
    protected $fillable = ['item_id','satuan_id','harga_beli','harga_jual','konversi'];
    
    protected $hidden = ['deleted_at','created_at','updated_at'];

}
