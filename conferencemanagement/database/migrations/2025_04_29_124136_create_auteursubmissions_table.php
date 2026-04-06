<?php

use App\Models\Auteur;
use App\Models\Submission;
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
        Schema::create('auteur_submissions', function (Blueprint $table) {
            $table->string('idSubmission');
            $table->foreign('idSubmission')
                ->references('idSubmission')
                ->on('submissions')
                ->cascadeOnDelete();
            $table->foreignId('auteur_id') // Nom de la colonne 'auteur_id'
                ->constrained('auteurs') // Table de référence
                ->cascadeOnDelete();
            $table->primary(['idSubmission', 'auteur_id']);

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auteursubmissions');
    }
};
