<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Apartment extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    public function sponsors()
    {
        return $this->belongsToMany(Sponsor::class)->withPivot("ending_date")->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    protected $fillable = [
        'title',
        'slug',
        'description',
        'room',
        'bed',
        'bathroom',
        'sqm',
        'address',
        'coordinate',
        'img_path',
        'img_name',
        'is_visible',
        'user_id',
    ];
}
