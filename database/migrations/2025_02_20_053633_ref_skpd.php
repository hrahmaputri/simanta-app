<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*Schema::create('ref_skpd', function (Blueprint $table) {
            $table->integer("id_skpd");
            $table->integer("id_instansi");
            $table->string("kode_skpd");
            $table->integer("tingkan");
            $table->text("skpd");
            $table->string("alamat_skpd")->nullable(true);
            $table->string("rayon_skpd")->nullable(true);
            $table->integer("status");
            $table->string("id_bkn");
            $table->timestamp("created_at")->nullable(false)->useCurrent();
            $table->timestamp("updated_at")->nullable(false)->useCurrent();
            $table->timestamp("deleted_at")->nullable(false)->useCurrent();
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
