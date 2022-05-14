<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $table = 'assignments';
    protected $guarded = ['id'];
    public $timestamps = false;
    protected $with = ['checkpoints', 'agent'];


    /**
     * -----------------------------------------
     *	Relations
     * -----------------------------------------
     */

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function checkpoints()
    {
        return $this->hasMany(AssignmentCheckpoint::class);
    }
}
