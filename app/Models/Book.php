<?php

namespace App\Models;

use Database\Factories\BookFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Book extends Model
{
    /** @use HasFactory<BookFactory> */
    use HasFactory;

    public const PLACEHOLDER_COVER = 'images/no-cover.svg';

    protected $fillable = [
        'title',
        'authors',
        'isbn',
        'original_publication_year',
        'language_code',
        'image_url',
    ];

    protected function casts(): array
    {
        return [
            'original_publication_year' => 'integer',
            'average_rating' => 'decimal:2',
            'ratings_count' => 'integer',
        ];
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function recommendations(): HasMany
    {
        return $this->hasMany(Recommendation::class);
    }

    /**
     * Filter by a free-text query on title or authors.
     */
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        $term = trim((string) $term);

        if ($term === '') {
            return $query;
        }

        $like = '%'.$term.'%';

        return $query->where(function (Builder $query) use ($like) {
            $query->where('title', 'like', $like)
                ->orWhere('authors', 'like', $like);
        });
    }

    public function scopeMostRated(Builder $query): Builder
    {
        return $query->orderByDesc('ratings_count')->orderByDesc('average_rating');
    }

    /**
     * A usable cover URL: remote URLs (goodbooks-10k) are returned as-is,
     * uploaded covers are resolved on the public disk, anything else falls
     * back to a local placeholder.
     */
    protected function coverUrl(): Attribute
    {
        return Attribute::get(function (): string {
            $value = $this->image_url;

            if (blank($value) || str_contains($value, '/nophoto/')) {
                return asset(self::PLACEHOLDER_COVER);
            }

            if (Str::startsWith($value, ['http://', 'https://', '//'])) {
                return $value;
            }

            return Storage::disk('public')->url($value);
        });
    }

    public function hasUploadedCover(): bool
    {
        return filled($this->image_url)
            && ! Str::startsWith($this->image_url, ['http://', 'https://', '//']);
    }

    /**
     * Store (or replace) a user's rating for this book and refresh the aggregates.
     */
    public function rateBy(User $user, int $stars): void
    {
        Rating::query()->upsert(
            [['user_id' => $user->id, 'book_id' => $this->id, 'rating' => $stars]],
            uniqueBy: ['user_id', 'book_id'],
            update: ['rating'],
        );

        $this->refreshRatingStats();
    }

    public function refreshRatingStats(): void
    {
        static::recalculateRatingStats([$this->id]);

        $this->refresh();
    }

    /**
     * Recompute average_rating and ratings_count from the ratings table.
     * This is the only place the aggregates are calculated.
     *
     * @param  array<int>|null  $bookIds  limit to these books, or null for all books
     */
    public static function recalculateRatingStats(?array $bookIds = null): int
    {
        return DB::table('books')
            ->when($bookIds !== null, fn ($query) => $query->whereIn('id', $bookIds))
            ->update([
                'ratings_count' => DB::raw('(select count(*) from ratings where ratings.book_id = books.id)'),
                'average_rating' => DB::raw('coalesce((select round(avg(rating), 2) from ratings where ratings.book_id = books.id), 0)'),
            ]);
    }

    /**
     * Number of ratings per star value, e.g. [5 => 10, 4 => 3, ..., 1 => 0].
     *
     * @return array<int, int>
     */
    public function ratingBreakdown(): array
    {
        $counts = $this->ratings()
            ->selectRaw('rating, count(*) as total')
            ->groupBy('rating')
            ->pluck('total', 'rating');

        $breakdown = [];
        foreach ([5, 4, 3, 2, 1] as $stars) {
            $breakdown[$stars] = (int) ($counts[$stars] ?? 0);
        }

        return $breakdown;
    }
}
