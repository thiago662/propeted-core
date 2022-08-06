<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'species',
        'breed',
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

    public function owners()
    {
        return $this->belongsToMany(Owner::class);
    }
}
