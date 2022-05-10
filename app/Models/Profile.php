<?php

namespace Seara\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public $table = "profiles";

    protected $fillable = [
      
      'profile_name',
      
    ];
   
    protected $primaryKey = "profile_id";
}
