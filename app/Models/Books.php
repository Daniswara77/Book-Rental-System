<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Books extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'release_date',
        'pages',
        'isbn',
        'description',
        'genre',
        'in_stock',
        'cover',
        'language',
    ];

    public function genres() 
    {
        return $this->belongsToMany(Genre::class, 'book_genre', 'book_id', 'genre_id');
    }

    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }
}
