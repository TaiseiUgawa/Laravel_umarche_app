<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            // 外部キー設定
            $table->foreignId('owner_id')
            ->constrained()
            // CRUD時、親が変更されたら外部キー側も追記
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->string('name');
            $table->text('information');
            $table->string('filename');
            $table->boolean('is_selling');
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
        Schema::dropIfExists('shops');
    }
}
