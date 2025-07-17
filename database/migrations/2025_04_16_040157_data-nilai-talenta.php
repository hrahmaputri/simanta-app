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
        Schema::create('tbl_nilai_talenta', function (Blueprint $table) {
            $table->increments("id");
            $table->integer("id_pegawai");
            $table->decimal("ind_1");
            $table->decimal("ind_2");
            $table->decimal("ind_3");
            $table->decimal("ind_4");
            $table->decimal("ind_5");
            $table->decimal("ind_6");
            $table->decimal("ind_7");
            $table->decimal("ind_8");
            $table->decimal("ind_9");
            $table->decimal("ind_10");
            $table->decimal("ind_11");
            $table->decimal("ind_12");
            $table->decimal("ind_13");
            $table->timestamp("created_at")->nullable(false)->useCurrent();
            $table->timestamp("updated_at")->nullable(false)->useCurrent();
        });
    }


    public function down(): void
    {
        //
    }
};
