<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasksMaster', function (Blueprint $table) {

            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('tasksMaster')->nullOnDelete();
            $table->string('task', 255);
            $table->text('task_details')->nullable();
            $table->integer('task_order')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasksMaster');
    }
};
