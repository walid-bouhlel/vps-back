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
        Schema::table('vps', function (Blueprint $table) {
            $table->unsignedBigInteger('os_id');
            $table->unsignedBigInteger('config_id');
            $table->foreign('os_id')->references('id')->on('os');
            $table->foreign('config_id')->references('id')->on('flavors');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vps', function (Blueprint $table) {
            $table->dropColumn('os_id');
            $table->dropColumn('config_id');
        });
    }
};
