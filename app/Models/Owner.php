<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'email',
        'person_id',
        'phone_number',
        'cell_phone_number',
        'zip_code',
        'state',
        'city',
        'neighborhood',
        'street',
        'house_number',
        'address_reference',
        'birth_date',
        'active',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function interections()
    {
        return $this->hasMany(Interection::class);
    }

    public function animals()
    {
        return $this->belongsToMany(Animal::class);
    }
}
