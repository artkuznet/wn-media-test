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
 * @property-read Collection $authors
 * @method static Builder whereId(int $id)
 */
class Book extends Model
{
    /**
     * @var string
     */
    protected $table = 'book';
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
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'author_book', 'book_id', 'author_id');
    }
}