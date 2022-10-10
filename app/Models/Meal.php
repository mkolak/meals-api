<?php

namespace App\Models;

use App\Models\{Tag, Category, Ingredient};
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Meal extends Model implements TranslatableContract
{
    use HasFactory, SoftDeletes, Translatable;

    public $translatedAttributes = ['title', 'description'];
    protected $fillable = ['category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class);
    }
}
