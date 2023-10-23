<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{

    protected $fillable = ['number', 'operator','contact_id'];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
