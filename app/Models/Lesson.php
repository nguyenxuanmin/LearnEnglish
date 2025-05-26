<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function exercises()
    {
        return $this->hasMany(Exercise::class);
    }
}
