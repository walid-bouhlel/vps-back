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
        Schema::create('vps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('server_name');
            $table->string('instance_id');
            $table->string('description');
            $table->string('ipv4');
            $table->string('flavor_sid')->comment('config physic');
            $table->foreign('flavor_sid')->references('flavor_sid')->on('configurations');
            $table->string('image_sid')->comment('config logic');
            $table->foreign('image_sid')->references('image_sid')->on('os');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vps');
    }
};
