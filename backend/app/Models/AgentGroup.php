<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentGroup extends Model
{
    use HasFactory;
    protected $table = 'agent_groups';
    protected $guarded = ['id'];
    public $timestamps = false;

    /**
     * users
     */
    public function agents()
    {
        return $this->hasMany(Agent::class);
    }
}
