<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    public function category(){
        return $this->belongsTo(CategoryProduct::class, 'category_product_id', 'id');
    }

    public function brand(){
        return $this->belongsTo(BrandProduct::class, 'brand_product_id', 'id');
    }

    public function subBrand(){
        return $this->belongsTo(SubBrandProduct::class, 'sub_brand_product_id', 'id');
    }

    public function deleted_actor(){
        return $this->belongsTo(User::class, 'deleted_by', 'id');
    }

    public function created_actor(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updated_actor(){
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}