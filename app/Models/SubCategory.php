<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }


    /**
     * Get the post that owns the comment.
     *
     * Syntax: return $this->belongsTo(Post::class, 'foreign_key', 'owner_key');
     *
     * Example: return $this->belongsTo(Post::class, 'post_id', 'id');
     *
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
