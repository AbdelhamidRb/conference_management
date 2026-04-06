<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->unsignedBigInteger('conference_id')->primary();
            $table->foreign('conference_id')
                ->references('id')->on('conferences')
                ->onDelete('cascade');

            $table->integer('numberArticle')->default(10);
            $table->integer('numberReviewer')->default(5);
            $table->boolean('submissionAllowed')->default(true);
            $table->boolean('submissionUpdateAllowed')->default(true);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'))->onUpdate(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuration');
    }
};
