<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Đổi tên bảng từ 'vourcher' thành 'voucher'
        Schema::rename('vourchers', 'vouchers');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Nếu rollback, đổi tên bảng ngược lại từ 'voucher' về 'vourcher'
        Schema::rename('voucher', 'vourcher');
    }
};
