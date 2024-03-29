<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Rennokki\QueryCache\Traits\QueryCacheable;

/**
 * App\Models\Color
 *
 * @property int $id
 * @property string $color
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Film> $withBackgroundColorFilms
 * @property-read int|null $with_background_color_films_count
 * @method static \Database\Factories\ColorFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Color newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Color newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Color query()
 * @method static \Illuminate\Database\Eloquent\Builder|Color whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Color whereId($value)
 * @mixin \Eloquent
 */
class Color extends Model
{
    use HasFactory, QueryCacheable;

    public $cacheFor = 24*60*60;
    public $cacheTags = ['color'];

    public $timestamps = false;

    public $fillable = ['color'];

    protected function cacheForValue()
    {
        if (request()?->user()?->userRole->role === User::ADMIN_ROLE) {
            return null;
        }

        return $this->cacheFor;
    }

    public function withBackgroundColorFilms(): HasMany
    {
        return $this->HasMany(Film::class, 'background_color_id');
    }
}
