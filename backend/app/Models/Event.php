<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'events';

    public static $TYPES = ['info', 'warning', 'danger'];
    public static $STATUS = ['completed', 'onprogress'];

    /**
     * user
     */
    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    /**
     * client
     */
    public function client(){
        return $this->belongsTo(Client::class);
    }
}
