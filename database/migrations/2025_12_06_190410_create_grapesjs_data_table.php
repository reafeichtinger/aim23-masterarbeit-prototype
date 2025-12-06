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
        Schema::create('grapesjs_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->longText('html')->nullable()->default(null);
            $table->longText('css')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('task_id')->references('id')->on('tasks')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grapesjs_data');
    }
};
