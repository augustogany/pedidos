<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'type','name','lastName','fullName','business_name','address_1',
        'address','ci','phone','email','typedocument_id'
    ];
}
