<?php

use App\Models\User;
use App\Models\Voucher;
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
        Schema::create('voucher_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(Voucher::class)->constrained();
            $table->string('vourcher_code');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->enum('status', [
                'ACTIVE',
                'IN_ACTIVE'
            ]);
            $table->enum('type', ['OTHER', 'REGISTER', 'SUCCESS'])->default('OTHER');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher_usages');
    }
};
