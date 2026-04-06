<?php

namespace App\Models;

use App\Models\Submission;
use App\Models\Configuration;
use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    protected $guarded = [];
    public function chair()
    {
        return $this->belongsTo(Chair::class);
    }
    public function configuration()
    {
        return $this->hasOne(Configuration::class);
    }
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
    public function userconferences()
    {
        return $this->hasMany(UserConference::class);
    }
}
