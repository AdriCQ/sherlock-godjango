<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';
    protected $guarded = ['id'];

    public function agentGroups(){
        return $this->hasMany(AgentGroup::class);
    }
    public function assignments(){
        return $this->hasMany(Assignment::class);
    }
    public function events(){
        return $this->hasMany(Event::class);
    }
    public function users(){
        return $this->hasMany(User::class);
    }
}
