<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentCheckpoint extends Model
{
    use HasFactory;

    protected $table = 'assignment_checkpoints';
    protected $guarded = ['id'];
    public $timestamps = false;
    protected $casts = ['coordinate' => 'json'];

    public static $STATUS = ['waiting', 'canceled', 'completed'];


    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }
}
