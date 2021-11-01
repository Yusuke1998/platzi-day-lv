<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price', 'category_id', 'created_by'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function created_by()
    {
        return $this->belongsTo(User::class);
    }
}
