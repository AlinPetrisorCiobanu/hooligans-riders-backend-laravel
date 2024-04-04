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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->require();
            $table->string('last_name')->require();
            $table->string('date')->require();
            $table->string('phone')->unique()->require();
            $table->string('email')->unique()->require();
            $table->string('nickname')->unique();
            $table->string('password')->require();
            $table->enum('role', ['user','rider','admin','super_admin'])->default('user');
            $table->boolean('is_active')->default(true);
            $table->boolean('confirmed')->default(false);
            $table->timestamp("created_at")->useCurrent();
            $table->timestamp("updated_at")->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
