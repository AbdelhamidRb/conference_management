<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chair extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'id';
    public $incrementing = false; // important
    protected $keyType = 'int';



    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function conferences()
    {
        return $this->hasMany(Conference::class);
    }
}
