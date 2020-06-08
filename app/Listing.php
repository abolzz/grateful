<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    // Table Name
    protected $table = 'listings';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    // public $timestamps = true;

    public function user(){
        return $this->belongsTo('App\User');
    }
}
