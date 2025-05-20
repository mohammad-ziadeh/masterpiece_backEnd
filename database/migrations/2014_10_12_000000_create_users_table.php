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
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('role', ['trainer', 'admin', 'student'])->default('student');
            $table->index('role');
            $table->enum('city', ['Aqaba', 'Amman', 'Irbid', 'Balqa']);
            $table->integer('weekly_points')->default(1000);
            $table->date('last_reset_at')->nullable();
            $table->softDeletes();
            $table->string('password');
            $table->string('avatar')->default('avatars/9WR2Qdn2rzp8NwFrImt57ewJfydX3DkRiuvcZ55n.p...');
            $table->string('phone')->nullable();
            $table->string('gender')->nullable();
            $table->rememberToken();
            $table->timestamps();
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
