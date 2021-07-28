<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Livewire\WithPagination;

class PermisosController extends Component
{
    use WithPagination;
    public $permissionName, $search ,$selected_id, $pageTitle, $componentName;
    private $pagination = 10;
    protected $paginationTheme = 'bootstrap'; 

    public function mount(){
        $this->pageTitle = 'Listado';
        $this->componentName = 'Permisos';
    }

    public function render()
    {
        if (strlen($this->search) > 0) {
            $permissions = Permission::where('name','like','%' . $this->search . '%')->paginate($this->pagination);
        }else{
            $permissions = Permission::orderBy('name','asc')->paginate($this->pagination);
        }
        return view('livewire.permisos.index',[
            'permisions' => $permissions
        ])
                ->extends('layouts.theme.app')
                ->section('content');
    }

    public function CreatePermission(){
        $rules =['permissionName' => 'required|min:2|unique:permissions,name'];
        $messages = [
            'permissionName.required' => 'El nombre es requerido',
            'permissionName.min' => 'El nombre deve contener al menos dos caracteres',
            'permissionName.unique' => 'Ya existe un permiso con este nombre',
        ];
        $this->validate($rules,$messages);
        Permission::create([
            'name' => $this->permissionName
        ]);
        $this->emit('permission-added','Registro con exito');
        $this->resetUI();
    }

    public function Edit(Permission $permission){
        $this->selected_id = $permission->id;
        $this->permissionName = $permission->name;
        $this->emit('show-modal','Show modal');
    }

    public function UpdatePermission(){
        $rules = ['permissionName' => "required|min:2|unique:permissions,name,{$this->selected_id}"];
        $message = [
            'permissionName.required' => 'El nombre del permiso es requerido',
            'permissionName.unique' => 'El permiso ya existe',
            'permissionName.min' => 'El nombre debe tener al menos 2 caracteres'
        ];
        $this->validate($rules, $message);
        $permission = Permission::find($this->selected_id);
        $permission->name = $this->permissionName;
        $permission->save();

        $this->emit('permission-updated','Actualizacion con exito');
        $this->resetUI();
    }

    protected $listeners = ['destroy' => 'Destroy'];
    
    public function Destroy($id){
        $rolesCount = Permission::find($id)->getRoleNames()->count();
        if ($rolesCount > 0) {
            $this->emit('permission-error','No se puede eliminar porque tiene roles asociados');
            return;
        }
        Permission::find($id)->delete();
        $this->emit('permission-deleted','Se elimino el permiso con exito');
    }

    public function resetUI(){
        $this->permissionName = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}
