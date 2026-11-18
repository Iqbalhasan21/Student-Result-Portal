<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = ['name', 'roll', 'department', 'email'];

    // One student has many results
    public function results(): HasMany
    {
        return $this->hasMany(Result::class);
    }
}
