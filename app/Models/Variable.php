<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variable extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'value',
        'category_id',
        'sub_category_id',
        'created_by',
        'updated_by',
    ];

    protected function serializeDate(\DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
