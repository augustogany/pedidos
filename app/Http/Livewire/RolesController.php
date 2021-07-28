<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;
use App\Models\User;
use DB;

class RolesController extends Component
{
    use WithPagination;
    public $roleName, $search ,$selected_id, $pageTitle, $componentName;
    private $pagination = 5;
    protected $paginationTheme = 'bootstrap'; 

    public function mount(){
        $this->pageTitle = 'Listado';
        $this->componentName = 'Roles';
    }
    public function render()
    {
        if (strlen($this->search) > 0) {
            $roles = Role::where('name','like','%' . $this->search . '%')->paginate($this->pagination);
        }else{
            $roles = Role::orderBy('name','asc')->paginate($this->pagination);
        }
        return view('livewire.roles.index',[
                    'roles' => $roles
                ])
                ->extends('layouts.theme.app')
                ->section('content');
    }
    
    public function CreateRole(){
        $rules =['roleName' => 'required|min:2|unique:roles,name'];
        $messages = [
            'roleName.required' => 'El nombre es requerido',
            'roleName.min' => 'El nombre deve contener al menos dos caracteres',
            'roleName.unique' => 'Ya existe un rol con este nombre',
        ];
        $this->validate($rules,$messages);
        Role::create([
            'name' => $this->roleName
        ]);
        $this->emit('role-added','Registro con exito');
        $this->resetUI();
    }
    
    public function Edit(Role $role){
        $this->selected_id = $role->id;
        $this->roleName = $role->name;
        $this->emit('show-modal','Show modal');
    }
    public function UpdateRole(){
        $rules = ['roleName' => "required|min:2|unique:roles,name,{$this->selected_id}"];
        $message = [
            'roleName.required' => 'El nombre del rol es requerido',
            'roleName.unique' => 'El rol ya existe',
            'roleName.min' => 'El nombre del rol debe tener al menos 2 caracteres'
        ];
        $this->validate($rules, $message);
        $role = Role::find($this->selected_id);
        $role->name = $this->roleName;
        $role->save();

        $this->emit('role-updated','Actualizacion con exito');
        $this->resetUI();
    }

    protected $listeners = ['destroy' => 'Destroy'];

    public function Destroy($id){
        $permissionsCount = Role::find($id)->permissions()->count();
        if ($permissionsCount > 0) {
            $this->emit('role-error','No se puede eliminar porque tiene permisos asociados');
            return;
        }

        Role::find($id)->delete();
        $this->emit('role-deleted','Se elimino el rol con exito');
    }

    public function AsignarRoles($rolesList){
        if ($this->userSelected > 0) {
            $user = User::find($this->userSelected);
            if ($user) {
                $user->syncRoles($rolesList);
                $this->emit('msg-ok','Roles asignados correctamente');
                $this->resetUI();
            }
        }
    }

    public function resetUI(){
        $this->roleName = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}
