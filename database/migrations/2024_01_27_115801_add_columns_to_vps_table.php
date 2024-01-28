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
            $table->string('instance_id')->after('server_name');
            $table->string('ipv4');
            $table->string('flavor_id');
            $table->string('image_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vps', function (Blueprint $table) {
            $table->dropColumn('instance_id');
            $table->dropColumn('ipv4');
            $table->dropColumn('flavor_id');
            $table->dropColumn('image_id');
        });
    }
};
