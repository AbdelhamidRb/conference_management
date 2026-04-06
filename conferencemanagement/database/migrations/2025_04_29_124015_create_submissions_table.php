<?php

use App\Models\Auteur;
use App\Models\Conference;
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
        Schema::create('submissions', function (Blueprint $table) {
            $table->string('idSubmission')->primary();
            $table->string('titre');
            $table->string('keywords');
            $table->string('resume');
            $table->string('statut')->default('pending');
            $table->boolean('notified')->default(false);
            $table->foreignIdFor(Auteur::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Conference::class)->constrained()->cascadeOnDelete();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'))->onUpdate(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
