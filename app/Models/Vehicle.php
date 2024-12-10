<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'parking_number',
        'category_id',
        'vehicle_company',
        'registration_number',
        'owner_name',
        'owner_contact',
        'owner_email',
        'intime',
        'outtime',
        'charges',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
