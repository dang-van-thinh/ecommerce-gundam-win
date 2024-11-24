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
        Schema::table('voucher_usages', function (Blueprint $table) {
            $table->boolean('used')->default(false)->after('voucher_id');
        });
    
        Schema::table('voucher_usages', function (Blueprint $table) {
            $table->dropColumn('voucher_code');
            $table->dropColumn('end_date');
            $table->dropColumn('status');
        });
    }
    
};
