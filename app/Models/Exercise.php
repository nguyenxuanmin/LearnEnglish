<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function exerciseDocuments()
    {
        return $this->hasMany(ExerciseDocument::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
