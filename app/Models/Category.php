<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['name','image'];

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function getImagenAttribute(){
        if ($this->image == null) return 'unavailable.png';
        if (file_exists('storage/categories/' .$this->image)) {
            return $this->image;
        }else{
            return 'unavailable.png';
        }
    }
}
