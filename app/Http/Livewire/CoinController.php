<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Denomination;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CoinController extends Component
{
    use WithFileUploads,WithPagination;

    public $type, $value , $search, $image, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;
    protected $paginationTheme = 'bootstrap';

    public function mount(){
        $this->pageTitle = 'Listado';
        $this->componentName = 'Denominaciones';
        $this->type = 'Elegir';
        $this->selected_id = 0;
    }

    public function render()
    {
        if (strlen($this->search) > 0) 
            $data = Denomination::where('type','like','%' .$this->search. '%')
                                ->orWhere('value','like','%' .$this->search . '%')
                                ->paginate($this->pagination);
        else
        $data = Denomination::orderBy('id','desc')->paginate($this->pagination);

        return view('livewire.coins.index',
            ['denominations' => $data
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function Edit($id){
        $record = Denomination::find($id,['id','type','value','image']);
        $this->type = $record->type;
        $this->value = $record->value;
        $this->selected_id = $record->id;
        $this->image = null;

        $this->emit('show-modal', 'show modal!');
    }

    public function Store(){
        $rules= [
            'type' => 'required|not_in:Elegir',
            'value' => 'required|unique:denominations'
        ];

        $messages = [
            'type.required' => 'El tipo es requerido',
            'type.not_in' => 'Elige un tipo distinto a Elegir',
            'value.unique' => 'Ya existe un tipo con este valor',
            'value.required' => 'El valor es requerido'
        ];

        $this->validate($rules,$messages);

        $denomination = Denomination::create([
            'type' => $this->type,
            'value' => $this->value
        ]);

        $customFileName;
        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/coins', $customFileName);
            $denomination->image = $customFileName;
            $denomination->save();
        }

        $this->resetUI();
        $this->emit('item-added','Denominacion Registrada');
    }

    public function Update(){
        $rules = [
            'type' => 'required|not_in:Elegir',
            'value' => "required|unique:denominations,value,{$this->selected_id}"
        ];

        $messages = [
            'type.required' => 'El tipo es requerido',
            'type.not_in' => 'Eligeun tipo valido',
            'value.unique' => 'Este valor ya esta registrado',
            'value.required' => 'El valor es requerido'
        ];

        $this->validate($rules,$messages);

        $denomination = Denomination::find($this->selected_id);
        $denomination->update([
            'type' => $this->type,
            'value' => $this->value
        ]);

        if ($this->image) {
            $customFileName = uniqid() . '_.' .$this->image->extension();
            $this->image->storeAs('public/coins/', $customFileName);
            $imageName = $denomination->image;
            $denomination->image = $customFileName;
            $denomination->save();
            
            if ($imageName != null) {
                if (file_exists('storage/coins/' . $imageName)) {
                    unlink('storage/coins/' . $imageName);
                }
            }
        }

        $this->resetUI();
        $this->emit('item-updated','Denominacion Actualizada');
    }

    public function resetUI(){
        $this->type = '';
        $this->value = '';
        $this->image = null;
        $this->search = '';
        $this->selected_id = 0;
    }

    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    public function Destroy(Denomination $denomination){
        $imageName = $denomination->image;
        $denomination->update([
            'image' => null
        ]);
        $denomination->delete();

        if ($imageName != null) {
            unlink('storage/coins/' . $imageName);
        }

        $this->resetUI();
        $this->emit('item-deleted','Denominacion Eliminada');
    }
}
