<?php

namespace App;
use App\MM;

class MMSettings extends MM {

    public static function generate()
    {

        $item = new MM('item');
        $item->field('id','increments');
        $item->field('nama','string');
        $item->field('kategori_id','unsignedInteger');
        $item->field('status','string');
        $item->softDeletes();

        $kategori = new MM('kategori');
        $kategori->field('id','increments');
        $kategori->field('nama','string');
        $kategori->field('keterangan','string');
        $kategori->softDeletes();

        $satuan = new MM('satuan');
        $satuan->field('id','increments');
        $satuan->field('nama','string');
        $satuan->field('keterangan','string');
        $satuan->softDeletes();

        $satuan = new MM('Item Satuan');
        $satuan->field('item_id','unsignedInteger');
        $satuan->field('satuan_id','unsignedInteger');
        $satuan->field('harga_beli','decimal', 12, 3)->default(0.0);
        $satuan->field('harga_jual','decimal', 12, 3)->nullable();
        $satuan->field('konversi','decimal', 8, 2);
        $satuan->primaryKeys('item_id','satuan_id');
        $satuan->softDeletes();
    }

}