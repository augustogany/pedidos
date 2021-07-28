<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable= [
        'date','nit','date','invoice_number','authorization_number','total','discount','status',
        'observation','contact_id','user_id','company_id','typedocument_id'
    ];
}
