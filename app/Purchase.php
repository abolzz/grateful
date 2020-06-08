<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    // Table Name
    protected $table = 'purchses';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    // public $timestamps = true;

    public function user(){
        return $this->belongsTo('App\User');
    }
}
