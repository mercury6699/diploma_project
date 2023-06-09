<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'content',
        'sub_category_id',
        'variable_ids',
        'created_by',
        'updated_by',
        'updated_at',
        'post_id',
        'is_current',
    ];

    protected function serializeDate(\DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
