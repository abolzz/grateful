<?php

namespace Grateful;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    // Table Name
    protected $table = 'likes';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;
}
