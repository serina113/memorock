<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fes extends Model
{
    use HasFactory;
    

    protected $fillable = [
        'title','fes_name', 'body', 'hashtag', 'date', 'user_id', 'image_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function artists()
    {
        return $this->hasMany(Artist::class);
    }

    function getPaginateByLimit(int $limit_count = 5)
    {
        return $this::with('fes') -> orderBy('updated_at', 'DESC')->paginate($limit_count);
    }
}