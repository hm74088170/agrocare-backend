<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Expert;

class Disease extends Model
{
    protected $fillable = [
    'disease_name',
    'plant_name',
    'symptoms',
    'prevention',
    'medicine',
    'image',
    'expert_id'
];
public function expert(){
    return $this->belongsTo(Expert::class);
}
}
