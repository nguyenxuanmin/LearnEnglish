<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function isKeyDocuments()
    {
        return $this->hasMany(Document::class)->where('isKey',1);
    }

    public function isNotKeyDocuments()
    {
        return $this->hasMany(Document::class)->where('isKey',0);
    }

    public function exercises()
    {
        return $this->hasMany(Exercise::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    protected function casts(): array
    {
        return [
            'time' => 'date',
        ];
    }
}
