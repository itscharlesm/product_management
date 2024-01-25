<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_product', function (Blueprint $table) {
            $table->id('ProductID');
            $table->string('ProductName');
            $table->string('ProductUCP');
            $table->string('type');
            $table->integer('qty');
            $table->decimal('price');
            $table->boolean('IsActive')->default(true);
            $table->unsignedBigInteger('CategoryID')->nullable();
            $table->foreign('CategoryID')->references('CategoryID')->on('tbl_productcategory')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_product');
    }
}