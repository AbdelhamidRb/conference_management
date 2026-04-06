<?php

use App\Models\PcMember;
use App\Models\Submission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id(); // primary key, auto-incremented

            $table->unsignedBigInteger('pc_member_id');
            $table->string('submission_id');

            $table->boolean('emailCheck')->nullable();

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'))->onUpdate(DB::raw('CURRENT_TIMESTAMP'));

            // Foreign keys
            $table->foreign('pc_member_id')->references('id')->on('pcmembers')->onDelete('cascade');
            $table->foreign('submission_id')->references('idSubmission')->on('submissions')->onDelete('cascade');

            // Composite UNIQUE constraint to avoid duplicates
            $table->unique(['pc_member_id', 'submission_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
