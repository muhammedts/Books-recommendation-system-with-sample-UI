<?php

namespace App\Models;

use Database\Factories\RatingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * A user's 1-5 star rating of a book. The table has a composite primary key
 * (user_id, book_id) and is read by the Spark ALS job, so writes go through
 * Book::rateBy(), which upserts the row and refreshes the book aggregates.
 */
class Rating extends Model
{
    /** @use HasFactory<RatingFactory> */
    use HasFactory;

    protected $primaryKey = null;

    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'book_id',
        'rating',
    ];

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'book_id' => 'integer',
            'rating' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
