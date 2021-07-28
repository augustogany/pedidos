<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Type;
class TypeDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Type::count() == 0) {
            $documentos = [
                [
                    'name' => 'CARNET DE IDENTIDAD',
                    'tipo' => 'docidentidad'
                ],
                [
                    'name' => 'NIT',
                    'tipo' => 'docidentidad'
                ],
                [
                    'name' => 'RUT',
                    'tipo' => 'docidentidad'
                ],
                [
                    'name' => 'Nº PASAPORTE',
                    'tipo' => 'docidentidad'
                ],
                [
                    'name' => 'LIBRETA DE SERVICIO MILITAR',
                    'tipo' => 'docidentidad'
                ],
                [
                    'name' => 'FACTURA',
                    'tipo' => 'documento'
                ],
                [
                    'name' => 'RECIBO',
                    'tipo' => 'documento'
                ]
           ];
            foreach ($documentos as $document) {
                Type::create($document);
            }
        }
        
    }
}
