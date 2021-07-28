<div class="row">
    <div class="col-sm-12">
        <div>
            <div class="connect-sorting">
                <div class="input-group input-group-md mb-3 ml-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-gp hideonsm" style="background: #3B3F5C; color:withe">
                            DATOS DEL SOLICITANTE
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
                            <select wire:model="contact_id" id="selCustomer" class="form-control">
                                <option value='0'>-- Select Solicitante --</option>
                            </select>
                        </div>
                        <div class="mt-2">
                            <input 
                                wire:model.lazy="nit" 
                                type="text" 
                                placeholder="carnet o nit......"
                                class="form-control"
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>