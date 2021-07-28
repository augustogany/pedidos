@include('common.modalHeader')
<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" wire:model.lazy="business_name" class="form-control product-name" placeholder="Ej: SAN JORGE">
            @error('business_name')
                <span class="text-danger er">{{ $message}}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Tipo de Documento</label>
            <select wire:model="prov_typedocument" class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                @foreach ($documentos as $document)
                    <option value="{{$document->id}}">{{$document->name}}</option>
                @endforeach
            </select>
            @error('prov_typedocument')
                <span class="text-danger er">{{ $message}}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>NIT</label>
            <input type="text" wire:model.lazy="prov_nit" class="form-control" placeholder="Ej: 763508801524">
            @error('prov_nit')
                <span class="text-danger er">{{ $message}}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>PHONE</label>
            <input type="text" wire:model.lazy="prov_phone" class="form-control" placeholder="Ej: 69658908">
            @error('prov_phone')
                <span class="text-danger er">{{ $message}}</span>
            @enderror
        </div>
    </div>
</div>
@include('common.modalFooter')