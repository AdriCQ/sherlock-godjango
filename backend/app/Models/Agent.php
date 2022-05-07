<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
    /**
     * -----------------------------------------
     *	Helpers
     * -----------------------------------------
     */

    public function readFromFiles()
    {
        // Check folder
        if (!Storage::exists($this->path)) return false;

        // Check coordinates
        if (!Storage::exists($this->path . '/coordinates')) return false;
        $coordsArray = Storage::files($this->path . '/coordinates');
    }
}
