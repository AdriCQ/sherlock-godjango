<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $table = 'assignments';
    protected $guarded = ['id'];


    /**
     * -----------------------------------------
     *	Relations
     * -----------------------------------------
     */

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function joints()
    {
        return $this->hasMany(AssignmentJoin::class);
    }
}
