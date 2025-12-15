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
            // Custom design additional fields
            $table->date('custom_deadline')->nullable()->after('custom_notes');
            $table->string('custom_reference_link')->nullable()->after('custom_deadline');
            
            // Update status column to support new statuses
            // Note: If using enum, you may need to modify this based on your current setup
            // For now, we'll keep it as string to support all statuses
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['custom_deadline', 'custom_reference_link']);
        });
    }
};
