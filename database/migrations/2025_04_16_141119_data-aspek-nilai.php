<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_aspek_nilai_pegawai', function (Blueprint $table) {
            $table->increments("id_nilai");
            $table->integer("id_pegawai");
            $table->integer("aspek_1");
            $table->integer("aspek_2");
            $table->integer("aspek_3");
            $table->integer("aspek_4");
            $table->integer("aspek_5");
            $table->integer("aspek_6");
            $table->integer("aspek_7");
            $table->integer("aspek_8");
            $table->integer("aspek_9");
            $table->integer("indikator_2");
            $table->integer("indikator_3");
            $table->integer("indikator_4");
            $table->integer("indikator_5");
            $table->integer("indikator_6");
            $table->integer("indikator_7");
            $table->integer("indikator_8");
            $table->integer("indikator_9");
            $table->integer("indikator_10");
            $table->integer("indikator_11");
            $table->integer("indikator_12");
            $table->integer("indikator_13");
            $table->timestamp("created_at")->nullable(false)->useCurrent();
            $table->timestamp("updated_at")->nullable(false)->useCurrent();
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
