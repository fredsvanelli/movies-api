<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'description',
        'director',
        'year',
        'duration',
        'score',
        'cover',
        'trailer',
    ];

    protected $casts = [
        'year' => 'integer',
        'score' => 'float',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class)->orderBy('name');
    }

    public function actors()
    {
        return $this->belongsToMany(Actor::class)->withPivot(['order'])->orderBy('order');
    }
}
