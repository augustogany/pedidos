<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name','barcode','cost','price','stock','alerts','category_id','image'
    ];

    public function categories(){
        return $this->belongsTo(Category::class);
    }

    public function getImagenAttribute(){
        if ($this->image != null) 
            return (file_exists('storage/products/' .$this->image) ? $this->image : 'unavailable.png');
        else
            return 'unavailable.png';
    }
}
