<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalGroup extends Model
{
    use HasFactory;
    protected $table = 'personal_groups';
    protected $guarded = ['id'];
    public $timestamps = false;

    /**
     * users
     */
    public function users()
    {
        return $this->hasMany(User::class, 'group_id', 'id');
    }
}
