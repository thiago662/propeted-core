<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interection extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'owner_id',
        'animal_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }
}
