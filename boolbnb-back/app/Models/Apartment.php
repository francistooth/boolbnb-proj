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
        return $this->belongsToMany(Sponsor::class);
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
        'coordinate_long_lat',
        'img_path',
        'img_name',
        'is_visible',
        'user_id',
    ];
}
