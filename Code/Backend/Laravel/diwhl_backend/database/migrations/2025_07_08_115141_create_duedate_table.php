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
        Schema::create('duedate', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')
                ->unique()
                ->constrained('tasks')
                ->onDelete('cascade');
            $table->date('due_at');
            $table->integer('repeat_days')
                ->nullable()
                ->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('duedate');
    }
};
