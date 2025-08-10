<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "content",
        "header_image",
        "author_id",
        "created_at",
        "updated_at",
        "deleted_at",
    ];

    protected function casts(): array
    {
        return [
            "created_at" => "datetime",
            "updated_at" => "datetime",
            "deleted_at" => "datetime",
        ];
    }

    /**
     * Returns the author of this blog post.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
