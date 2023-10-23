<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
  
    use SoftDeletes;
    protected $fillable = ['name', 'address'];

    public function phoneNumbers()
    {
        return $this->hasMany(PhoneNumber::class);
    }
}
