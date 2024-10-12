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
        // Đổi tên bảng từ 'vourcher_usages' thành 'voucher_usages'
        Schema::rename('vourcher_usages', 'voucher_usages');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Nếu rollback, đổi tên bảng ngược lại từ 'voucher_usages' về 'vourcher_usages'
        Schema::rename('voucher_usages', 'vourcher_usages');
    }
};
