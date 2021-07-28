<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Denomination;
use App\Models\Product;
use App\Models\Contact;
use App\Models\Purchase;
use App\Models\Company;
use App\Models\Type;
use App\Models\PurchaseDetail;
use DB;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Exception;

class PurchaseController extends Component
{
    public $total, $authorization_number, $date, $nit, $invoice_number,
           $observation, $contact_id, $discount, $typedocument_id, $description='';

    // propiedades para la creacion del proveedor if not exists
    public $business_name, $prov_typedocument, $prov_nit, $prov_phone,
           $componentName, $selected_id;
    
    public function mount(){
        $this->total = Cart::getTotal();
        $this->typedocument_id = 'Elegir';
        $this->prov_typedocument = 'Elegir';
        $this->componentName = 'Crear Proveedor';
    }

    public function render()
    {
        return view('livewire.purchases.create',[
                'comprobantes' => Type::where('tipo','documento')->get(),
                'documentos' => Type::where('tipo','docidentidad')->get(),
                'cart' => Cart::getContent()->sortBy('name')
                ])
               ->extends('layouts.theme.app')
               ->section('content');
    }

    protected $listeners = [
        'scan-code' => 'ScanCode',
        'removeItem',
        'clearCart',
        'savePurchase'
    ];

    public function ScanCode($barcode,$cant =1){
        $product = Product::where('barcode',$barcode)->first();

        if ($product == null || empty($product)) {
            $this->emit('scan-notfound','El producto no esta registrado');
        }else{
            if ($this->InCart($product->id)) {
                $this->increaseQty($product->id);
                return;
            }

            Cart::add($product->id, $product->name,1, $cant, $product->image);
            $this->total = Cart::getTotal();
          
            $this->emit('scan-ok','Producto agregado');
        }
        
    }
    public function InCart($productid){
        $exist = Cart::get($productid);
        return $exist ? true : false;
    }

    public function increaseQty($productId,$price,$cant = 1){
        $title = '';
        $product = Product::findOrFail($productId);
        $exist = Cart::get($productId);
        
        if ($exist) {
            $title = 'Cantidad actualizada';
        } else {
            $title = 'Producto agregado';
        }

        Cart::add($product->id, $product->name, $price, $cant, $product->image);
        $this->total = Cart::getTotal();
        $this->emit('scan-ok', $title);
    }

    public function updateQty($productId,$price, $cant = 1){
        $product = Product::findOrFail($productId);
        $exist = Cart::get($productId);

        if ($exist) {
            $title = 'Cantidad actualizada';
        } else {
            $title = 'Producto agregado';
        }
       
        $this->removeItem($productId);
        if ($cant > 0) {
            Cart::add($product->id, $product->name, $price, $cant, $product->image);
            $this->total = Cart::getTotal();
            $this->emit('scan-ok', $title);
        }
    }

    public function removeItem($productId){
        Cart::remove($productId);
        $this->total= Cart::getTotal();
        $this->emit('scan-ok', 'Producto eliminado');
    }

    public function decreaseQty($productId){
        $item = Cart::get($productId);
        Cart::remove($productId);
        $newQty = ($item->quantity) -1;
        if ($newQty > 0)
            Cart::add($item->id, $item->name, $item->price, $newQty, $item->attributes[0] );
        
        $this->total= Cart::getTotal();
        $this->emit('scan-ok', 'Cantidad actualizada');
    }

    public function clearCart(){
        Cart::clear();
        $this->total= Cart::getTotal();
        $this->emit('scan-ok', 'Carrito vacio');
    }

    public function savePurchase(){
       
        if ($this->total <= 0) {
            $this->emit('sale-error','AGREGA PRODUCTOS A LA COMPRA');
            return;
        }

        DB::beginTransaction();
        try {
            $purchase = Purchase::create([
                'total' => $this->total,
                'date' => $this->date,
                'nit' => $this->nit,
                'invoice_number' => $this->invoice_number,
                'authorization_number' => $this->authorization_number,
                'observation' => $this->description,
                'discount' => $this->discount,
                'status' => 'A',
                'contact_id' => $this->contact_id,
                'company_id' => Company::first()->id,
                'typedocument_id' => $this->typedocument_id,
                'user_id' => auth()->user()->id
            ]);

            if ($purchase) {
                $items = Cart::getContent();
                foreach ($items as $item) {
                    PurchaseDetail::create([
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                        'product_id' => $item->id,
                        'purchase_id' => $purchase->id
                    ]);
                    //update stock
                    $product = Product::find($item->id);
                    $product->stock = $product->stock + $item->quantity;
                    $product->save();
                }
            }
            DB::commit();
            Cart::clear();
            $this->total= Cart::getTotal();
            $this->resetPurchase();
            $this->emit('purchase-ok', 'Compra Registrada con exito');

        } catch (Exception $e) {
            DB::rollback();
            $this->emit('purchase-error',$e->getMessage());
        }
    }
    public function Store(){
        $rules= [
            'business_name' => 'required',
            'prov_typedocument' => 'required|not_in:Elegir',
            'prov_nit' => 'required|unique:contacts,ci|min:3'
        ];

        $messages = [
            'business_name.required' => 'El nombre es requerido',
            'prov_nit.required' => 'El ci|nit es requerido',
            'ci.unique' => 'Ya existe un ci|nit con ese numero',
            'ci.min' => 'El ci deve tener al menos 3 caracteres',
            'prov_typedocument.required' => 'El tipo de documento es requerido',
            'prov_typedocument.not_in' => 'Selecciona un tipo de documento diferente de Elegir'
        ];

        $this->validate($rules,$messages);

        Contact::create([
            'business_name' => $this->business_name,
            'typedocument_id' => $this->prov_typedocument,
            'ci' => $this->prov_nit,
            'phone' => $this->prov_phone,
            'type' => 'provider'
        ]);

        $this->resetUI();
        $this->emit('provider-added','Proveedor Registrado exitosamente');
    }

    public function resetPurchase(){
        $this->total = 0;
        $this->authorization_number = 0;
        $this->nit = 0;
        $this->invoice_number = 0;
        $this->observation = 0;
        $this->discount = 0;
        $this->typedocument_id = 'Elegir';
        $this->date = null;
    }

    public function resetUI(){
        $this->business_name = '';
        $this->prov_typedocument = 'Elegir';
        $this->prov_nit = '';
        $this->prov_phone = '';
    }

}
