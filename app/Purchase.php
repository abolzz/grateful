<?php

namespace Grateful;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    // Table Name
    protected $table = 'purchases';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    // public $timestamps = true;

    public function user(){
        return $this->belongsTo('Grateful\User');
    }
}
