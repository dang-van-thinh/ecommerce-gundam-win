<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Kiểm tra xem cột 'status' đã tồn tại chưa
            if (!Schema::hasColumn('orders', 'status')) {
                // Thêm cột status nếu chưa tồn tại
                $table->enum('status', ['PENDING', 'DELIVERING', 'SHIPPED', 'COMPLETED', 'CANCELED', 'REFUND'])
                      ->default('PENDING')
                      ->after('payment_method');
            } else {
                // Nếu cột đã tồn tại, chỉ cần thay đổi nếu cần
                $table->enum('status', ['PENDING', 'DELIVERING', 'SHIPPED', 'COMPLETED', 'CANCELED', 'REFUND'])
                      ->default('PENDING')
                      ->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Nếu rollback migration, xóa cột status
            $table->dropColumn('status');
        });
    }
};
