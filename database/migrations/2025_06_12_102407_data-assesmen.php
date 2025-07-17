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
        /*Schema::create('tbl_kompetensi', function (Blueprint $table) {
            $table->increments("id");
            $table->integer("id_pegawai")->nullable(false)->default(0);
            $table->integer("aspek_1")->default(0);
            $table->integer("aspek_2")->default(0);
            $table->integer("aspek_3")->default(0);
            $table->integer("aspek_4")->default(0);
            $table->integer("aspek_5")->default(0);
            $table->integer("aspek_6")->default(0);
            $table->integer("aspek_7")->default(0);
            $table->integer("aspek_8")->default(0);
            $table->integer("aspek_9")->default(0);
            $table->integer("level_eselon")->default(0);
            $table->timestamp("created_at")->nullable(false)->useCurrent();
            $table->timestamp("updated_at")->nullable(false)->useCurrent();
            $table->timestamp("deleted_at")->nullable(true);
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
