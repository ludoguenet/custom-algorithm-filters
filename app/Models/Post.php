<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PostStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use HasFactory;

    /**
     * @var array<string, mixed>
     */
    protected $casts = [
        'status' => PostStatusEnum::class,
    ];

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeFilters(
        Builder $query,
        ?string $sortBy,
        ?string $direction,
    ): void {
        $query
            ->when(
                value: $sortBy,
                callback: static function ($query, $sortBy) use ($direction): void {
                    match ($sortBy) {
                        'title' => $query->orderBy('title', $direction),
                        'status' => $query->orderByStatus($direction),
                        'analysis' => $query->orderByLikesAndCommentsCount($direction),
                    };
                }
            );
    }

    public function scopeOrderByStatus(
        Builder $query,
        string $direction,
    ): void {
        $query->orderBy(
            column: DB::raw("
                case
                    when status = 'draft' then 1
                    when status = 'validated' then 2
                    when status = 'online' then 3
                end
            "),
            direction: $direction,
        );
    }

    public function scopeOrderByLikesAndCommentsCount(
        Builder $query,
        string $direction,
    ): void {
        $query->orderByRaw(
            sql: "(likes_count + (comments_count * 5)) $direction",
        );
    }
}
