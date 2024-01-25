<?php

namespace App\Models;

use App\Transformers\CategoryTransformer;
use http\Exception\InvalidArgumentException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,softDeletes;
    protected $dates=['deleted_at'];

    protected $fillable=[
        'name',
        'description',
    ];
    protected $hidden=[
        'pivot'
        ];
    public $transformer = CategoryTransformer::class;
    public function products(){
        return $this->belongsToMany(Product::class,'category_product','product_id','category_id');
    }
}
