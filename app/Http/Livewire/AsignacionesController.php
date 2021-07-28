<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Livewire\WithPagination;
use DB;

class AsignacionesController extends Component
{
    use WithPagination;

    public $role, $componentName,$permisosSelected = [], $old_permissions = [];
    private $pagination = 10;
    protected $paginationTheme = 'bootstrap'; 
    
    public function mount(){
        $this->role = 'Elegir';
        $this->componentName = 'Asignar Permisos';
    }

    public function render()
    {
        $permissions = Permission::select('name','id',DB::raw("0 as checked"))
                                  ->orderBy('name','asc')
                                  ->paginate($this->pagination);
        if ($this->role != 'Elegir') {
            $list = Permission::join('role_has_permissions as rp','rp.permission_id','permissions.id')
                                ->where('role_id',$this->role)
                                ->pluck('permissions.id')
                                ->toArray();
            $this->old_permissions = $list;
        }

        if ($this->role != 'Elegir') {
            foreach ($permissions as $permission) {
                $role = Role::find($this->role);
                $tienePermiso = $role->hasPermissionTo($permission->name);
                if ($tienePermiso) {
                    $permission->checked = 1;
                }
            }
        }
        return view('livewire.asignaciones.component',[
                    'roles' => Role::orderBy('name','asc')->get(),
                    'permissions' => $permissions
                ])
                ->extends('layouts.theme.app')
                ->section('content');
    }

    public $listeners = ['revokeall' => 'RemoveAll'];

    public function RemoveAll(){
        if ($this->role == 'Elegir') {
            $this->emit('sync-error','Selecciona un rol valido');
            return;
        }

        $role = Role::find($this->role);
        $role->syncPermissions([0]);
        $this->emit('remove-all',"Se revocaron todos los permisos al rol $role->name");
    }

    public function SyncAll(){
        if ($this->role == 'Elegir') {
            $this->emit('sync-error','Selecciona un rol valido');
            return;
        }

        $role = Role::find($this->role);
        $permissions = Permission::pluck('id')->toArray();
        $role->syncPermissions($permissions);

        $this->emit('sync-all',"Se sincronizaron todos los permisos al rol $role->name");

    }

    public function SyncPermission($state,$permissionName){
        if ($this->role != 'Elegir') {
            $roleName = Role::find($this->role);
            if ($state) {
                $roleName->givePermissionTo($permissionName);
                $this->emit('permi','Permiso asignado correctamente');
            }else {
                $roleName->revokePermissionTo($permissionName);
                $this->emit('permi','Permiso eliminado correctamente');
            }
        }else {
            $this->emit('permi','Elige un rol valido');
        }
    }
}
