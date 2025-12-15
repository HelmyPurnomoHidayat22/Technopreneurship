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
        Schema::create('custom_design_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
            $table->enum('uploader_role', ['admin', 'user']);
            $table->string('file_path');
            $table->enum('file_type', ['design', 'revision', 'feedback'])->default('design');
            $table->text('notes')->nullable();
            $table->integer('version')->default(1);
            $table->timestamps();
            
            $table->index('order_id');
            $table->index(['order_id', 'file_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_design_files');
    }
};
