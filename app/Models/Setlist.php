<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'song_name', 'position', 'artist_id',
    ];
    
    public function artist()
    {
        return $this->belongsto(Artist::class);
    }
}