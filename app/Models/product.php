<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['categories_id', 'product', 'description', 'price', 'stock', 'image'];

    public function categorie()
    {
        return $this->belongsTo(categorie::class);
    }
}
