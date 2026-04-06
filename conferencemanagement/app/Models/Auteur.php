<?php

namespace App\Models;

use App\Models\User;
use App\Models\Submission;
use Illuminate\Database\Eloquent\Model;

class Auteur extends Model
{
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function submissionsPrimaryAuthor()
    {
        return $this->hasMany(Submission::class);
    }
    public function submissionsSecondaryAuthor()
    {
        return $this->belongsToMany(Submission::class);
    }
}
