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
     * updateStatus
     */
    static public function updateStatus(int $id)
    {
        $ass = self::find($id);
        foreach ($ass->checkpoints as $checkpoint) {
            if ($checkpoint->status == 0) {
                $ass->agent()->update(['bussy' => true]);
                return $ass;
            }
        }
        $ass->update(['status' => 1]);
        $ass->agent()->update(['bussy' => false]);
        return $ass = self::find($id);
    }


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

    /**
     * client
     */
    public function client(){
        return $this->belongsTo(Client::class);
    }
}
