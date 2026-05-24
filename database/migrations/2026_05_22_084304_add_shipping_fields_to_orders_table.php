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
            $table->string('shipping_type')->default('local')->after('notes'); // pickup, local, outside
            $table->string('courier')->nullable()->after('shipped_at');
            $table->string('tracking_number')->nullable()->after('courier');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['shipping_type', 'courier', 'tracking_number']);
        });
    }
};
