<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expert extends Model
{
    protected $fillable = [
        'firebase_uid',
        'name',
        'email',
        'specialization'
    ];
    public function diseases()
    {
        return $this->hasMany(Disease::class);
    }
}
