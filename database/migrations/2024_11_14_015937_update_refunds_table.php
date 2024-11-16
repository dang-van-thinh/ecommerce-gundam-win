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
        Schema::table('refunds', function (Blueprint $table) {
            // Thêm cột status với các giá trị có thể có
            $table->enum('status', [
                'ORDER_CREATED',              // Tạo đơn thành công
                'CANCEL_REFUND_ORDER',        // Hủy đơn hoàn
                'HANDOVER_TO_SHIPPING',       // Giao cho đơn vị vận chuyển
                'REFUND_COMPLETED',           // Đã hoàn hàng thành công
                'DELIVERY_FAILED'             // Giao hàng thất bại
            ])
                ->default('ORDER_CREATED')  // Thiết lập giá trị mặc định
                ->after('image')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('refunds', function (Blueprint $table) {
            // Xóa cột status nếu rollback migration
            $table->dropColumn('status');
        });
    }
};
