<div class="row">
    <div class="col-sm-12">
        <div>
            <div class="connect-sorting">
                <span class="text-center input-group-text input-gp hideonsm" style="background: #3B3F5C; color:withe;">
                    DATOS DEL COMPROBANTE
                </span>
                <div class="connect-sorting-content">
                    <div class="form-group">
                        <div class="mt-2">
                            <select wire:model="typedocument_id" class="form-control">
                                <option value="Elegir">Elegir</option>
                                @foreach ($comprobantes as $item)
                                    <option value="{{ $item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-2">
                            <input 
                                wire:model.lazy="invoice_number" 
                                type="text" 
                                placeholder="nro factura o comprobante..."
                                class="form-control"
                            >
                        </div>
                        @if ($typedocument_id == '6')
                            <div class="mt-2">
                                <input 
                                    wire:model.lazy="authorization_number" 
                                    type="text" 
                                    placeholder="nro authorizacion..."
                                    class="form-control"
                                >
                            </div>
                        @endif
                        <div class="mt-2">
                            <input 
                                wire:model="date" 
                                type="date" 
                                class="form-control"
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>