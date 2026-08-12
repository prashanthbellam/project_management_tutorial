<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('timeline_masters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('timeline_masters')->nullOnDelete();
            $table->string('stage');
            $table->text('responsibility')->nullable();
            $table->boolean('is_micro')->default(false);
            $table->boolean('is_major')->default(false);
            $table->boolean('is_deleted')->default(false);
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('timeline_masters');
    }
};
