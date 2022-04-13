<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentJoin extends Model
{
    use HasFactory;

    protected $table = 'assignment_joins';
    protected $guarded = ['id'];
    public $timestamps = false;

    public static $STATUS = ['waiting', 'canceled', 'completed'];


    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }
}
