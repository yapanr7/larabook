<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

class Package extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $casts = [
        'duration_type' => 'string',
        'duration_value' => 'integer',
    ];

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }
}
