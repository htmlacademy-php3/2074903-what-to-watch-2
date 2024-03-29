<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Rennokki\QueryCache\Traits\QueryCacheable;

/**
 * App\Models\File
 *
 * @property int $id
 * @property string $link
 * @property int $file_type_id
 * @property-read \App\Models\FileType|null $type
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $withAvatarUsers
 * @property-read int|null $with_avatar_users_count
 * @method static \Database\Factories\FileFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|File newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|File newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|File query()
 * @method static \Illuminate\Database\Eloquent\Builder|File whereFileTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereLink($value)
 * @mixin \Eloquent
 */
class File extends Model
{
    use HasFactory, QueryCacheable;

    public $cacheFor = 24*60*60;
    public $cacheTags = ['file'];

    public $timestamps = false;

    protected function cacheForValue()
    {
        if (request()?->user()?->userRole->role === User::ADMIN_ROLE) {
            return null;
        }

        return $this->cacheFor;
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(FileType::class);
    }

    /** Just for file type 'avatar'
     * Potentially we should extend this method with 'where'
     */
    public function withAvatarUsers(): HasMany
    {
        return $this->hasMany(User::class, 'avatar_id');
    }

    /** Just for file type 'poster'
     * Potentially we should extend this method with 'where'
     */
    public function withPosterFilms(): HasMany
    {
        return $this->hasMany(Film::class, 'poster_image_id');
    }

    /** Just for file type 'preview'
     * Potentially we should extend this method with 'where'
     */
    public function withPreviewFilms(): HasMany
    {
        return $this->hasMany(Film::class, 'preview_image_id');
    }

    /** Just for file type 'background'
     * Potentially we should extend this method with 'where'
     */
    public function withBackgroundFilms(): HasMany
    {
        return $this->hasMany(Film::class, 'background_image_id');
    }
}
