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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rate_id')->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('weight')->nullable();
            $table->string('purity')->nullable();
            $table->text('content')->nullable();
            $table->string('category')->nullable();
            $table->boolean('status')->default(true);
            $table->string('image')->nullable();
            $table->string('price')->nullable();
            $table->foreign('rate_id')->references('id')->on('rates')->onDelete('cascade');
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
        Schema::dropIfExists('products');
    }
};
