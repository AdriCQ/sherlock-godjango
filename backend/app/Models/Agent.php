<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    protected $table = 'agents';
    protected $guarded = ['id'];
    protected $casts = ['coordinate' => 'json'];

    /**
     * -----------------------------------------
     *	Relations
     * -----------------------------------------
     */
    /**
     * category
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'agent_categories');
    }
    /**
     * user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
