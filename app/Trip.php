<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];


    public function setYearAttribute($value)
    {
        $this->attributes['year'] = Carbon::parse($value);
    }

    public function scopeCurrentCar($query, $id)
    {
        return $query->where('car_id', '=', $id);
    }

    /**
     * Get the comments for the blog post.
     */
    public function car()
    {
        return $this->belongsTo(Car::class );
    }

}
