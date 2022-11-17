<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Animal extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'species',
        'breed',
        'sex',
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
        return $this->belongsToMany(Owner::class, 'owner_animal');
    }
}
