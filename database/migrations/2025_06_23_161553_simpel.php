<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_simpel', function (Blueprint $table) {
            $table->increments("id");
            $table->integer("id_pegawai")->default(0);
            $table->integer("id_pengguna")->default(0);
            $table->string("nip")->default(0);
            $table->integer("total_nilai")->default(0);
            $table->string("periode")->default(0);
            $table->timestamp("created_at")->nullable(false)->useCurrent();
            $table->timestamp("updated_at")->nullable(false)->useCurrent();
            $table->timestamp("deleted_at")->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
