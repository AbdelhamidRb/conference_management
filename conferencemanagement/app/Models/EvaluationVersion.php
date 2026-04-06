<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationVersion extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Relation vers l'évaluation principale (1 version appartient à 1 évaluation)
     */
    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class, 'evaluation_id');
    }


    /**
     * Optionnel : Si tu veux accéder facilement au membre du comité
     */
    public function pcMember()
    {
        return $this->belongsTo(PcMember::class, 'pc_member_id');
    }

    /**
     * Optionnel : Si tu veux accéder à la soumission depuis la version
     */
    public function submission()
    {
        return $this->belongsTo(Submission::class, 'submission_id', 'idSubmission');
    }
}
