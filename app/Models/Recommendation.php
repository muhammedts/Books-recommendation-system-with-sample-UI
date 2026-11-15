<?php

namespace App\Models;

use Database\Factories\RecommendationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * A book recommended to a user. The table is owned by the Spark ALS job
 * (Recommendation-system-ALS-with-JDBC), which truncates and refills it;
 * the web app only reads it.
 */
class Recommendation extends Model
{
    /** @use HasFactory<RecommendationFactory> */
    use HasFactory;

    protected $primaryKey = null;

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'book_id',
        'rank',
        'score',
        'generated_at',
    ];

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'book_id' => 'integer',
            'rank' => 'integer',
            'score' => 'float',
            'generated_at' => 'datetime',
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
