<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{

    protected $table = 'employees';
    protected $primaryKey = 'id';
     protected $fillable = [
          'name',
          'email',
          'address',
          'phone',
      ];
      
    use HasFactory;

}
