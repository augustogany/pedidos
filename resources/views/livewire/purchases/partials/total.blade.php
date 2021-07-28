<div class="row mt-3">
    <div class="col-sm-12">
        <div>
            <div class="connect-sorting">
                <div class="input-group input-group-md mb-3 ml-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-gp hideonsm" style="background: #3B3F5C; color:withe">
                            DATOS DEL PROVEEDOR
                        </span>
                    </div>
                    <div class="input-group-append">
                        <span
                            data-toggle="modal" data-target="#theModal" 
                            class="input-group-text" 
                            style="background: #3B3F5C" color:white>
                            <i class="fas fa-plus fa-2x"></i>
                        </span>
                    </div>
                </div>
                <div class="connect-sorting-content">
                    <div class="form-group">
                        <div wire:ignore class="mt-2">
                            <!-- For defining autocomplete -->
                            <select wire:model="contact_id" id="selProvider" class="form-control">
                                <option value='0'>-- Select Provider --</option>
                            </select>
                        </div>
                        <div class="mt-2">
                            <input 
                                wire:model.lazy="nit" 
                                type="text" 
                                placeholder="nit......"
                                class="form-control"
                            >
                        </div>
                    </div>
                </div>
                <div class="connect-sorting-content mt-4">
                    <div class="card simple-title-task-ui-sortable-handle">
                        <div class="col-sm-12 col-md-12 mt-2">
                            <label>Descripcion</label>
                            <textarea class="form-control" wire:model="description" rows="4" value="{{$description}}"></textarea>
                            @error('description')
                                <span class="text-danger er">{{ $message}}</span>
                            @enderror
                        </div>
                        <div class="card-body">
                            <div class="task-header">
                                <div>
                                    <h2>TOTAL: Bs{{number_format($total,2)}}</h2>
                                    <input type="hidden" id="hiddenTotal" value="{{$total}}">
                                </div>
                            </div>
                            <div class="row justify-content-between mt-5">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    @if ($total > 0)
                                        <button onclick="Confirm('','clearCart','Seguro de Eliminar el Carrito?')" class="btn btn-dark mtmobile">
                                            CANCELAR F4
                                        </button>
                                    @endif
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    @if ($total > 0)
                                        <button wire:click.prevent="savePurchase" class="btn btn-dark btn-md btn-block">GUARDAR F9</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>