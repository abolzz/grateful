<?php

namespace Grateful;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    // Table Name
    protected $table = 'shops';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;

    public function user(){
        return $this->belongsTo('Grateful\User');
    }
}
