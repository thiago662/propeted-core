<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'type',
        'title',
        'schedule_at',
        'body',
        'finished',
        'finish_at',
        'answered',
        'response_message',
        'response_body',
        'interection_id',
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

    public function interection()
    {
        return $this->belongsTo(Interection::class);
    }
}
