<?php


namespace App\Models;


class Item extends Model
{
    public $deletable = true;
    protected $fillable = [
        "uuid",
        "name",
        "is_completed"
    ];
}