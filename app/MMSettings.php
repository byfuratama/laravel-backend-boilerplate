<?php

namespace App;
use App\MM;

class MMSettings extends MM {

    public static $list = [];

    public static function generate()
    {
        $item = new self('item');
        $item->field('id','increments');
        $item->field('nama','string');
        $item->field('kategori_id','unsignedInteger');
        $item->field('status','string');

        $kategori = new self('kategori');
        $kategori->field('id','increments');
        $kategori->field('nama','string');
        $kategori->field('keterangan','string');
    }

}