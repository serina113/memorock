<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fes extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'body', 'fes_name', 'hashtag', 'date', 'user_id',
    ];

    public function artists()
    {
        return $this->hasMany(Artist::class);
    }
}