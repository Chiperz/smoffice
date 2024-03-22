<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailStoreVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'header_visit_id',
        'category_product_id',
        'display_product_id',
    ];

    public function header_visit(){
        return $this->belongsTo(HeaderVisit::class, 'header_visit_id', 'id');
    }

    public function display(){
        return $this->belongsTo(DisplayProduct::class, 'display_product_id', 'id');
    }

    public function category(){
        return $this->belongsTo(CategoryProduct::class, 'category_product_id', 'id');
    }

}
