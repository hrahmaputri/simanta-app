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
        /*Schema::create('tbl_sumbu_x', function (Blueprint $table) {
            $table->increments("id");
            $table->integer("id_pegawai");
            $table->integer("predikat_kinerja");
            $table->integer("penghargaan");
            $table->integer("penugasan_tim");
            $table->integer("penilaian360");
            $table->integer("kompetensi");
            $table->integer("potensi");
            $table->integer("pendformal");
            $table->integer("pengkomp");
            $table->integer("pengalaman_jab");
            $table->integer("pref_karir");
            $table->integer("organisasi");
            $table->integer("int_moralitas");
            $table->timestamp("created_at")->nullable(false)->useCurrent();
            $table->timestamp("updated_at")->nullable(false)->useCurrent();
        });*/
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
