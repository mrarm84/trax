<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['make', 'model', 'year' ];


    public function getTripCountAttribute()
    {
        return $this->trips()
                    ->givenCar($this->id)
                    ->count('id');
    }

    public function getTripMilesAttribute()
    {
        return $this->trips()
                    ->where('car_id', '=', $this->id)
                    ->sum('miles');
    }

    /**
     * Get the comments for the blog post.
     */
    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

}
