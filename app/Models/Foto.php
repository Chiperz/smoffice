<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    use HasFactory;

    protected $fillable = [
        'header_visit_id',
        'file_name',
        'file_size',
        'type'
    ];

    public function headerVisit(){
        return $this->belongsTo(HeaderVisit::class, 'header_visit_id', 'id');
    }
}
