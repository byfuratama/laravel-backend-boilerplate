<?php

namespace App;
use App\MM;

class MMSettings extends MM {

    public static function generate()
    {

        $mm = new MM('item');
        $mm->field('id','increments');
        $mm->field('nama','string');
        $mm->field('kategori_id','unsignedInteger');
        $mm->field('status','string');
        $mm->softDeletes();

        $mm = new MM('kategori');
        $mm->field('id','increments');
        $mm->field('nama','string');
        $mm->field('keterangan','string');
        $mm->softDeletes();

        $mm = new MM('satuan');
        $mm->field('id','increments');
        $mm->field('nama','string');
        $mm->field('keterangan','string');
        $mm->softDeletes();

        $mm = new MM('Item Satuan');
        $mm->field('item_id','unsignedInteger');
        $mm->field('satuan_id','unsignedInteger');
        $mm->field('harga_beli','decimal', 12, 3)->default(0.0);
        $mm->field('harga_jual','decimal', 12, 3)->nullable();
        $mm->field('konversi','decimal', 8, 2);
        $mm->primaryKeys('item_id','satuan_id');
        $mm->softDeletes();
    }

}