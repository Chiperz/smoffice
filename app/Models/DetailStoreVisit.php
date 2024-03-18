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
}
