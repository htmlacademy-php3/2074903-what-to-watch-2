<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FileType extends Model
{
    public $timestamps = false;

    use HasFactory;

    public function files(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

}
