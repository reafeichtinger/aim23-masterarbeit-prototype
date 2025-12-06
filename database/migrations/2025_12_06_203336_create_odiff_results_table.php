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
        Schema::create('odiff_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('test_run_id');
            $table->string('editor'); // App\Enums\EditorEnum
            $table->integer('pixels')->default(0);
            $table->decimal('percent')->default(0.00);
            $table->json('lines')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('test_run_id')->references('id')->on('test_runs')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('odiff_results');
    }
};
