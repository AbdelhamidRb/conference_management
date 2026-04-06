<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'id';
    public $incrementing = true;


    // Relation avec PcMember
    public function pcMember()
    {
        return $this->belongsTo(PcMember::class, 'pc_member_id'); // Déclare la colonne 'pc_member_id' explicitement
    }

    // Relation avec Submission
    public function submission()
    {
        return $this->belongsTo(Submission::class, 'submission_id'); // Déclare la colonne 'submission_id' explicitement
    }
    public function versions()
    {
        return $this->hasMany(EvaluationVersion::class, 'evaluation_id');
    }
    public function latestVersion()
    {
        return $this->hasOne(EvaluationVersion::class, 'evaluation_id')->latestOfMany();
    }
}
