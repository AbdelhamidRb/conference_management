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
        Schema::create('conferences', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('acronyme')->unique();
            $table->string('venue');
            $table->string('country');
            $table->string('city');
            $table->string('conferenceWebPage')->nullable();
            $table->integer('estimatedNumberSubmission')->nullable();
            $table->date('firstDay');
            $table->date('lastDay');
            $table->date('submissionDeadLine');
            $table->string('organizer');
            $table->string('organizerWebPage');
            $table->string('organizerPhoneNumber');
            $table->string('organizerEmail');
            $table->string('primaryArea');
            $table->string('secondaryArea');
            $table->string('submissionLink');
            $table->unsignedBigInteger('chair_id');
            $table->foreign('chair_id')->references('id')->on('chairs')->onDelete('cascade');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'))->onUpdate(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conference');
    }
};
