<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentCheckpoint extends Model
{
    use HasFactory;

    protected $table = 'assignment_checkpoints';
    protected $guarded = ['id'];
    protected $casts = ['position' => 'array'];

    /**
     * assignment
     */
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }
    /**
     * agent
     */
    public function agent()
    {
        return $this->assignment->agent;
    }
}
