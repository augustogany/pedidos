<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Sale;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class UsersController extends Component
{
    use WithFileUploads,WithPagination;

    public $name, $phone, $email, $status, $image, $password,$search, 
           $selected_id, $fileLoaded,$profile,$componentName,$pageTitle;
    private $pagination = 5;
    protected $paginationTheme = 'bootstrap'; 

    public function mount(){
        $this->componentName = 'Users';
        $this->pageTitle = 'Listado';
        $this->status = 'Elegir';
    }

    public function render()
    {
        if (strlen($this->search) > 0) 
            $data = User::where('name','like','%' .$this->search. '%')
                          ->select('*')
                          ->orderBy('name','asc')
                          ->paginate($this->pagination);
        else
        $data = User::select('*')->orderBy('name','asc')->paginate($this->pagination);

        return view('livewire.users.index',[
                    'users' => $data,
                    'roles' => Role::orderBy('name','asc')->get()
                ])
                ->extends('layouts.theme.app')
                ->section('content');
    }

    public function resetUI(){
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->phone = '';
        $this->image = '';
        $this->search = '';
        $this->status = 'Elegir';
        $this->selected_id = 0;
        $this->resetValidation();
        $this->resetPage();
    }

    public function Edit(User $user){
        $this->selected_id = $user->id;
        $this->name = $user->name;
        $this->phone = $user->phone;
        $this->profile = $user->profile;
        $this->status = $user->status;
        $this->email = $user->email;
        $this->password = '';

        $this->emit('show-modal','Open Modal');
    }

    protected $listeners =[
        'deleteRow' => 'destroy',
        'resetUi' => 'resetUI'
    ];

    public function Store(){
        $rules =[
            'name' => 'required|min:3',
            'email' => 'required|unique:users|email',
            'status' => 'required|not_in:Elegir',
            'profile' => 'required|not_in:Elegir',
            'password' => 'required|min:3'
        ];

        $messages = [
            'name.required' => 'Ingresa Nombre',
            'name.min' => 'El nombre debe tener al menos 3 caracteres',
            'email.required' => 'Ingresa el correo',
            'email.email' => 'Ingresa un correo valido',
            'email.unique' => 'Este correo ya esta registrado',
            'status.required' => 'Selecciona el estado para el usuario',
            'status.not_in' => 'Selecciona el status distintode elegir',
            'profile.required' => 'Selecciona el perfil/role del usuario',
            'profile.not_in' => 'Selecciona un perfil/role',
            'password.required' => 'Ingresa tu password',
            'password.min' => 'El password debe tener al menos 3 caracteres'
        ];
        $this->validate($rules,$messages);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'profile' => $this->profile,
            'password' => bcrypt($this->password),
        ]);

        $user->syncRoles($this->profile);

        if ($this->image) {
            $customFileName = uniqid() . '_.' .$this->image->extension();
            $this->image->storeAs('public/users', $customFileName);
            $user->image = $customFileName;
            $user->save();
        }

        $this->resetUI();
        $this->emit('user-added','Usuario Registrado');
    }

    public function Update(){
        $rules =[
            'name' => 'required|min:3',
            'email' => "required|email|unique:users,email,{$this->selected_id}",
            'status' => 'required|not_in:Elegir',
            'profile' => 'required|not_in:Elegir'
        ];

        $messages = [
            'name.required' => 'Ingresa Nombre',
            'name.min' => 'El nombre debe tener al menos 3 caracteres',
            'email.required' => 'Ingresa el correo',
            'email.email' => 'Ingresa un correo valido',
            'email.unique' => 'Este correo ya esta registrado',
            'status.required' => 'Selecciona el estado para el usuario',
            'status.not_in' => 'Selecciona el status distintode elegir',
            'profile.required' => 'Selecciona el perfil/role del usuario',
            'profile.not_in' => 'Selecciona un perfil/role'
        ];
        $this->validate($rules,$messages);

        $user = User::find($this->selected_id);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'profile' => $this->profile
        ]);

        $user->syncRoles($this->profile);
        
        if ($this->password != '') {
            $user->password = bcrypt($this->password);
            $user->save();
        }
        if ($this->image) {
            $customFileName = uniqid() . '_.' .$this->image->extension();
            $this->image->storeAs('public/users', $customFileName);
            $imageTemp = $user->image;
            $user->image = $customFileName;
            $user->save();

            if ($imageTemp != null) {
                if (file_exists('storage/users/' .$imageTemp)) {
                    unlink('storage/users/' .$imageTemp);
                }
            }
        }

        $this->resetUI();
        $this->emit('user-added','Usuario Actualizado correctamente');
    }

    public function destroy(User $user){
        if ($user) {
            $sales = Sale::where('user_id', $user->id)->count();
            if ($sales > 0) {
                $this->emit('user-withsales','No es posible eliminar el usuario porque tiene ventas registradas');
            }else {
                $user->delete();
                $this->resetUI();
                $this->emit('user-deleted','usuario eliminado correctamente');
            }
        }
    }
}
