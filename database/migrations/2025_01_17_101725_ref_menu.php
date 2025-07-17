<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RefMenu extends Migration
{
    public function up()
    {
        Schema::create('ref_menu', function (Blueprint $table) {
            $table->increments("id_menu");
            $table->string("menu");
            $table->string("url");
            $table->integer("aktif");
            $table->timestamp("created_at")->nullable(false)->useCurrent();
            $table->timestamp("updated_at")->nullable(false)->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ref_menu');
    }
}
