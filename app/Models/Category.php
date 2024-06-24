<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'image',
        'thumbnail',
        'name',
        'slug',
        'content',
        'status',
        'cat_ust',
    ];

    public function images(){
        return $this->hasOne(İmageMedia::class,'table_id','id')->where('model_name','Category');
    }

    public function items()
    {
        return $this->hasMany(Product::class,'category_id','id');
    }

    public function subCategory()
    {
        return $this->hasMany(Category::class,'cat_ust','id');
    }

    public function category()
    {
        return $this->hasOne(Category::class,'id','cat_ust');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
