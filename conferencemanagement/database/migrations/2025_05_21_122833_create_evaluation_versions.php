<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluation_versions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('evaluation_id');

            $table->string('remarque')->nullable();
            $table->string('decision')->nullable();
            $table->text('commentaire_confidentiel')->nullable();
            $table->timestamps();

            $table->foreign('evaluation_id')
                ->references('id')
                ->on('evaluations')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluation_versions');
    }
};
