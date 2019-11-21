<?php

namespace App\Models;

use App\Models\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class Token extends Model {

    /**
     * Fillable attributes
     *
     * @var array
     */
    protected $fillable = [
        'token',
        'expiration',
    ];

    /**
     * Converted to Carbon attributes
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'expiration'
    ];

    /**
     * Hidden attributes
     *
     * @var array
     */
    protected $hidden = [
        "created_at",
        "updated_at",
        "user_id",
        "id",
    ];

    /**
     * Return is the token is expired
     *
     * @return bool
     */
    public function getExpiredAttribute() {
        return $this->expiration < Carbon::now();
    }

    /**
     * Get the active tokens
     *
     * @param Builder $query
     * @return mixed
     */
    public function scopeActive(Builder $query) {
        return $query->where("expiration", ">", Carbon::now());
    }

}
