<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function completions()
    {
        return $this->hasManyThrough(Completion::class, User::class);
    }
}
