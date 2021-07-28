<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Denomination extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['type','value','image'];

    public function getImagenAttribute(){
        if ($this->image != null) 
            return (file_exists('storage/coins/' .$this->image) ? $this->image : 'unavailable.png');
        else
            return 'unavailable.png';
    }
}
