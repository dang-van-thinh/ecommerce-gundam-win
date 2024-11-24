<?php

use App\Models\User;
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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            // Tạo cột sender_id với kiểu dữ liệu integer và tạo khóa ngoại tham chiếu đến bảng users
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('receiver_id');

            // Khóa ngoại sender_id tham chiếu đến bảng 'users'
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            // Khóa ngoại receiver_id tham chiếu đến bảng 'users'
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');

            $table->text("message");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
