<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $name
 * @property-read Collection $books
 * @method static Builder whereId(int $id)
 * @method static Builder whereIn(string $column, array $data)
 */
class Author extends Model
{
    /**
     * @var string
     */
    protected $table = 'author';
    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
    ];
    /**
     * @var string[]
     */
    protected $hidden = [
        'pivot',
        'created_at',
        'updated_at',
    ];

    /**
     * @return BelongsToMany
     */
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'author_book', 'author_id', 'book_id');
    }
}