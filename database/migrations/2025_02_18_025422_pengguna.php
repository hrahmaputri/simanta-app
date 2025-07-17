<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_pengguna', function (Blueprint $table) {
            $table->increments("id");
            // $table->integer("id_pegawai");
            $table->string("nama");
            $table->string("username");
            $table->string("password");
            $table->timestamp("created_at")->nullable(false)->useCurrent();
            $table->timestamp("updated_at")->nullable(false)->useCurrent();
        });
    }

    public function down(): void
    {
        //
    }
};
