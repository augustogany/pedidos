@include('common.modalHeader')
<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" wire:model.lazy="name" class="form-control product-name" placeholder="Ej: Augusto">
            @error('name')
                <span class="text-danger er">{{ $message}}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Apellidos</label>
            <input type="text" wire:model.lazy="lastName" class="form-control product-name" placeholder="Ej: Carvalho Chavez">
            @error('lastName')
                <span class="text-danger er">{{ $message}}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Tipo de Documento</label>
            <select wire:model="custom_typedocument" class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                @foreach ($documentos as $document)
                    <option value="{{$document->id}}">{{$document->name}}</option>
                @endforeach
            </select>
            @error('custom_typedocument')
                <span class="text-danger er">{{ $message}}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>NIT</label>
            <input type="text" wire:model.lazy="custom_nit" class="form-control" placeholder="Ej: 763508801524">
            @error('custom_nit')
                <span class="text-danger er">{{ $message}}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>PHONE</label>
            <input type="text" wire:model.lazy="custom_phone" class="form-control" placeholder="Ej: 69658908">
            @error('custom_phone')
                <span class="text-danger er">{{ $message}}</span>
            @enderror
        </div>
    </div>
</div>
@include('common.modalFooter')