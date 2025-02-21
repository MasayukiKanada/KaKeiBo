<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('primary_category_id')->onUpdate('cascade');
            $table->date('date');
            $table->foreignId('partner_id')->onUpdate('cascade');
            $table->foreignId('secondary_category_id')->onUpdate('cascade');
            $table->foreignId('thirdry_category_id')->onUpdate('cascade')->nullable();
            $table->foreignId('subject_id')->onUpdate('cascade')->nullable();
            $table->integer('price');
            $table->text('memo')->nullable();
            $table->integer('sort_order')->nullable();
            $table->foreignId('user_id')->onUpdate('cascade');
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
        Schema::dropIfExists('items');
    }
};
