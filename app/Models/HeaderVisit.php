<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderVisit extends Model
{
    use HasFactory;

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function foto(){
        return $this->hasMany(Foto::class);
    }

    public function gift(){
        return $this->hasMany(DetailGiftVisit::class);
    }

    public function detail_store(){
        // return $this->hasMany(DetailStoreVisit::class);
        return $this->hasMany(DetailStoreVisit::class, 'header_visit_id', 'id');
    }

    public function detail_outlet(){
        return $this->hasMany(DetailOutletVisit::class);
    }

    public function available_stok(){
        return $this->hasMany(StoreVisitBrand::class);
    }

    public function store_reason(){
        return $this->hasMany(StoreVisitUnproductiveReason::class);
    }

    public function used_product(){
        return $this->hasMany(OutletVisitProduct::class);
    }

    public function outlet_reason(){
        return $this->hasMany(OutletVisitUnproductiveReason::class);
    }
}
