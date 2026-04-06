<?php

namespace App\Models;

use App\Models\Auteur;
use App\Models\Conference;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $primaryKey = 'idSubmission';

    // Tell Eloquent that the primary key is not auto-incrementing
    public $incrementing = false;
    protected $guarded = [];

    function primaryAuthor()
    {
        return $this->belongsTo(Auteur::class, 'auteur_id', 'id');
    }

    public function secondaryAuthors()
    {
        return $this->belongsToMany(Auteur::class, 'auteur_submissions', 'idSubmission', 'auteur_id')
            ->withTimestamps();
    }

    public function conference()
    {
        return $this->belongsTo(Conference::class);
    }
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'submission_id');
    }
    public function pdfs()
    {
        return $this->hasMany(Pdf::class, 'submission_id', 'idSubmission');
    }
    public function latestPdf()
    {
        return $this->hasOne(Pdf::class, 'submission_id', 'idSubmission')->latestOfMany('version');
    }
}
