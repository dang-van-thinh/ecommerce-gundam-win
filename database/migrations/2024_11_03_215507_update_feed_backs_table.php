<?php

use App\Models\OrderItem;
use App\Models\Product;
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
        Schema::table('feedbacks', function (Blueprint $table) {
            $table->dropConstrainedForeignIdFor(Product::class);
            $table->dropColumn('product_id');
            $table->foreignIdFor(OrderItem::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedbacks', callback: function (Blueprint $table) {
            $table->foreignIdFor(Product::class)->constrained();
            $table->dropConstrainedForeignIdFor(OrderItem::class);
            $table->dropColumn('order_item_id');
        });
    }
};
