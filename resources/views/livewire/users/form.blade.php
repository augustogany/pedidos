@include('common.modalHeader')
<div class="row">
    <div class="col-sm-12 col-md-8">
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="Ej: Augusto Carvalho">
            @error('name')
                <span class="text-danger er">{{ $message}}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Phone</label>
            <input 
            type="text" 
            wire:model.lazy="phone" 
            class="form-control" 
            placeholder="Ej: 69658908"
            maxlength="10">
            @error('phone')
                <span class="text-danger er">{{ $message}}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Email</label>
            <input 
            type="text" 
            wire:model.lazy="email" 
            class="form-control" 
            placeholder="Ej: auguss24@gmail.com">
            @error('email')
                <span class="text-danger er">{{ $message}}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Password</label>
            <input 
            type="text" 
            wire:model.lazy="password" 
            class="form-control" >
            @error('password')
                <span class="text-danger er">{{ $message}}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Estado</label>
            <select wire:model.lazy="status" class="form-control">
                <option value="Elegir" selected>Elegir</option>
                <option value="Active">Activo</option>
                <option value="Locked">Bloqueado</option>
            </select>
            @error('status')
                <span class="text-danger er">{{ $message}}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Asignar Rol</label>
            <select wire:model.lazy="profile" class="form-control">
                <option value="Elegir" selected>Elegir</option>
                @foreach ($roles as $rol)
                     <option value="{{$rol->name}}">{{$rol->name}}</option>
                @endforeach
            </select>
            @error('profile')
                <span class="text-danger er">{{ $message}}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Imagen de Perfil</label>
            <input 
            type="file"
            wire:model="image"
            accept="image/x-png, image/jpeg, image/jpg, image/gif"
            class="form-control">
            @error('image')
                <span class="text-danger er">{{ $message}}</span>
            @enderror
        </div>
    </div>
</div>
@include('common.modalFooter')