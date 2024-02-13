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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false);
            $table->string('key_name')->nullable()->comment('key name in openStack');
            $table->text('public_key')->nullable();
            $table->string('public_key_path')->nullable();
            $table->text('private_key')->nullable();
            $table->string('private_key_path')->nullable();
            $table->string('key_fingerprint')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('public_key');
                $table->dropColumn('public_key_path');
                $table->dropColumn('private_key_path');
                $table->dropColumn('private_key');
                $table->dropColumn('key_name');
            });
        });
    }
};
