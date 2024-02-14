<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'package_id'];

    // Define the relationship with the Package model
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
