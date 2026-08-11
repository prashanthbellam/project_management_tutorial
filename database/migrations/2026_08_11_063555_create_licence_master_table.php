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
        Schema::create('licenceMaster', function (Blueprint $table) {
        $table->id();
        $table->string('name', 255);
        $table->string('required_for', 255)->nullable();
        $table->timestamp('created_at')->useCurrent();
        $table->unsignedBigInteger('created_by');
        $table->timestamp('updated_at')->useCurrent();
        $table->unsignedBigInteger('updated_by');
        $table->boolean('is_deleted')->default(false);
        $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licence_master');
    }
};
