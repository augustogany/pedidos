<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();   
        
        $arrayOfPermissionNames = [
            'browse-categorias','categorias.index', 'categorias.edit','categorias.show',
            'categorias.create','categorias.destroy','browse-products','products.index',
            'products.edit','products.show','products.create','products.destroy',
            'browse-users','users.index','users.edit','users.show','users.create','users.destroy',
            'browse-roles','roles.index','roles.edit','roles.show','roles.create','roles.destroy',
            'browse-permissions','permissions.index','permissions.edit','permissions.show','permissions.create',
            'permissions.destroy','browse-asignaciones','asignar-permisos-roles','browse-sales','sales.index',
            'sales.edit','sales.show','sales.create','sales.nuled','browse-purchases','purchases.index',
            'purchases.edit','purchases.show','purchases.create','purchases.nuled'
        ];
        
        $permissions = collect($arrayOfPermissionNames)->map(function ($permission) {
            return ['name' => $permission, 'guard_name' => 'web'];
        });
    
        Permission::insert($permissions->toArray());    

        $rolesa = Role::create(['name' => 'admin']);
        $rolesa->givePermissionTo(Permission::all());

        //Manager
        $manager = Role::create(['name' => 'Manager'])
                        ->givePermissionTo(
                            [
                            'browse-categorias','categorias.index', 'categorias.edit','categorias.show',
                            'categorias.create','categorias.destroy','browse-products','products.index',
                            'products.edit','products.show','products.create','products.destroy',
                            'browse-users','users.index','users.edit','users.show','users.create','users.destroy',
                            'browse-roles','roles.index','roles.edit','roles.show','roles.create','roles.destroy',
                            'browse-asignaciones','asignar-permisos-roles','browse-sales','sales.index',
                            'sales.edit','sales.show','sales.create','sales.nuled','browse-purchases','purchases.index',
                            'purchases.edit','purchases.show','purchases.create','purchases.nuled'
                            ]);
        //Reg Ventas
        $document = Role::create(['name' => 'Vendedor'])
                        ->givePermissionTo(
                            [
                                'browse-categorias','categorias.index', 'categorias.edit','categorias.show',
                                'categorias.create','categorias.destroy','browse-products','products.index',
                                'products.edit','products.show','products.create','products.destroy','browse-sales',
                                'sales.index','sales.edit','sales.show','sales.create','sales.nuled','browse-purchases',
                                'purchases.index','purchases.edit','purchases.show','purchases.create','purchases.nuled'
                            ]);
    }
}
