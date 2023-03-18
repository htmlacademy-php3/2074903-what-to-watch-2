<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Film extends Model
{
    protected $with = [
        'posterImage',
        'previewImage',
        'backgroundImage',
        'backgroundColor',
        'videoLink',
        'previewVideoLink',
        'director',
        'status',
        'actors',
        'genres'
    ];

    use HasFactory;
    use SoftDeletes;

    public function posterImage(): HasOne
    {
        return $this->hasOne(File::class, 'poster_image_id')->withDefault();
    }

    public function previewImage(): HasOne
    {
        return $this->hasOne(File::class, 'preview_image_id')->withDefault();
    }

    public function backgroundImage(): HasOne
    {
        return $this->hasOne(File::class, 'background_image_id')->withDefault();
    }

    public function backgroundColor(): HasOne
    {
        return $this->hasOne(Color::class, 'background_color_id')->withDefault();
    }

    public function videoLink(): HasOne
    {
        return $this->hasOne(Link::class, 'video_link_id')->withDefault();
    }

    public function previewVideoLink(): HasOne
    {
        return $this->hasOne(Link::class, 'preview_video_link_id')->withDefault();
    }

    public function director(): HasOne
    {
        return $this->hasOne(Director::class)->withDefault();
    }

    public function status(): HasOne
    {
        return $this->hasOne(FilmStatus::class, 'status_id');
    }

    public function reviews(): BelongsTo
    {
        return $this->belongsTo(Review::class)->withDefault();
    }

    public function actors(): BelongsToMany
    {
        return $this->belongsToMany(Actor::class);
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    public function lovers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorite_films');
    }
}
