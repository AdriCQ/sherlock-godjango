<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    protected $table = 'agents';
    protected $guarded = ['id'];
    protected $casts = ['position' => 'array'];

    /**
     * -----------------------------------------
     *	Relations
     * -----------------------------------------
     */
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
    /**
     * category
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'agent_categories');
    }
    /**
     * events
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }
    /**
     * group
     */
    public function group()
    {
        return $this->belongsTo(AgentGroup::class);
    }
    /**
     * user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
