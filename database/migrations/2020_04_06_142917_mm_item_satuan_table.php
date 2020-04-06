<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MmItemSatuanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_satuan', function (Blueprint $table) {
            $table->unsignedInteger('item_id');
            $table->unsignedInteger('satuan_id');
            $table->decimal('harga_beli','12','3')->default(0);
            $table->decimal('harga_jual','12','3')->nullable(1);
            $table->decimal('konversi','8','2');
            $table->primary(['item_id','satuan_id']);
            $table->timestamps();
            $table->softDeletes();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_satuan');
    }
}
