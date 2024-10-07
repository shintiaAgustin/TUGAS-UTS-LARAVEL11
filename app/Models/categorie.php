<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class categorie extends Model
{
    use HasFactory;
    protected $fillable = [
        'categories',
        'is_active',
    ];

    public function product():HasMany
    {
        return $this->hasMany(product::class);
    }
}
