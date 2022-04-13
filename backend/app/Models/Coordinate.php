<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordinate extends Model
{
    use HasFactory;

    protected $table = 'coords';
    protected $guarded = ['id'];
    protected $casts = ['coordinate' => 'json'];
    public $timestamps = false;



    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }
}
