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
            $table->string('full_name');
            $table->string('image')->nullable();
            $table->string('phone', 15);
            $table->enum('status', ['ACTIVE', 'IN_ACTIVE'])->default('IN_ACTIVE');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->integer('login_attempts')->default(0);     // Đếm số lần đăng nhập thất bại
            $table->timestamp('last_login_attempt')->nullable(); // Thời điểm đăng nhập thất bại cuối
            $table->timestamp('password_changed_at')->nullable(); // Lần thay đổi mật khẩu cuối
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
