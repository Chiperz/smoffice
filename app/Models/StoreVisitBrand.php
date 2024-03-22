<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreVisitBrand extends Model
{
    use HasFactory;

    protected $fillable = [
        'header_visit_id',
        'brand_product_id'
    ];

    public function brand(){
        return $this->belongsTo(BrandProduct::class, 'brand_product_id', 'id');
    }
}
