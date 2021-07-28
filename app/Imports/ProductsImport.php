<?php

namespace App\Imports;

use App\Product;
use Maatwebsite\Excel\Concerns\{Importable, ToModel, WithHeadingRow, WithValidation};

class ProductsImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            'name' => $row['name'],
            'barcode' => $row['barcode'],
            'cost' => $row['cost'],
            'price' => $row['price'],
            'stock' => $row['stock'],
            'alerts' => $row['alerts'],
            'category_id' => $row['category_id'],
        ]);
    }
}
