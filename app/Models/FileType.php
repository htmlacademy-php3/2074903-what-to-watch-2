<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\FileType
 *
 * @property int $id
 * @property string $type
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\File> $files
 * @property-read int|null $files_count
 * @method static \Illuminate\Database\Eloquent\Builder|FileType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FileType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FileType query()
 * @method static \Illuminate\Database\Eloquent\Builder|FileType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileType whereType($value)
 * @mixin \Eloquent
 */
class FileType extends Model
{
    use HasFactory;

    public const AVATAR_TYPE = 'avatar';
    public const POSTER_TYPE = 'poster';
    public const PREVIEW_TYPE = 'preview';
    public const BACKGROUND_TYPE = 'background';

    public $timestamps = false;

    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }

}
