<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Change status column from enum to string to support all statuses
        DB::statement("ALTER TABLE `orders` MODIFY COLUMN `status` VARCHAR(50) NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum (if needed)
        DB::statement("ALTER TABLE `orders` MODIFY COLUMN `status` ENUM('pending', 'waiting_verification', 'paid', 'rejected') NOT NULL DEFAULT 'pending'");
    }
};
