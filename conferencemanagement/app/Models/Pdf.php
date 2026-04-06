<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pdf extends Model
{
    protected $guarded = [];

    public function submission()
    {
        return $this->belongsTo(Submission::class, 'submission_id', 'idSubmission');
    }
}
