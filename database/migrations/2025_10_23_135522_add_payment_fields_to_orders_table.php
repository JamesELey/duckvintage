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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_method')->nullable()->after('commission_paid_at');
            $table->enum('payment_status', ['pending', 'completed', 'failed', 'refunded'])->default('pending')->after('payment_method');
            $table->string('payment_reference')->nullable()->after('payment_status');
            $table->timestamp('payment_completed_at')->nullable()->after('payment_reference');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'payment_status', 'payment_reference', 'payment_completed_at']);
        });
    }
};