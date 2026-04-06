<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PcMember extends Model
{
    protected $table = 'pcmembers';
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
}
