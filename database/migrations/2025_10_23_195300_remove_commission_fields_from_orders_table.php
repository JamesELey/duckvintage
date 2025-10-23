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
            $table->dropColumn(['commission_rate', 'commission_amount', 'commission_paid', 'commission_paid_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('commission_rate', 5, 2)->default(12.00);
            $table->decimal('commission_amount', 10, 2)->default(0);
            $table->boolean('commission_paid')->default(false);
            $table->timestamp('commission_paid_at')->nullable();
        });
    }
};