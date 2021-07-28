<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <p>{{$componentName}}</p>
                </h4>
            </div>
            <div class="widget-content">
                <div class="form-inline">
                    <div class="form-group mr-5">
                        <select wire:model="role" class="form-control">
                            <option value="Elegir" selected>Seleccione el Rol==</option>
                            @foreach ($roles as $rol)
                                <option value="{{$rol->id}}">{{$rol->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button wire:click.prevent="SyncAll()" class="btn btn-dark mbmobile inblock mr-5">
                        Sincronizar Todos
                    </button>
                    <button onclick="Revocar()" class="btn btn-dark mbmobile mr-5">
                        Revocar Todos
                    </button>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered striped mt-1">
                                <thead class="text-white" style="background: #3B3F5C">
                                    <tr>
                                        <th class="table-th text-white text-center">ID</th>
                                        <th class="table-th text-white text-center">PERMISO</th>
                                        <th class="table-th text-white text-center">ROLES CON EL PERMISO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $permission)
                                    <tr>
                                        <td><h6 class="text-center">{{$permission->id}}</h6></td>
                                        <td class="text-center">
                                            <div class="n-check">
                                                <label class="new-control new-checkbox checkbox-primary">
                                                    <input type="checkbox"
                                                    wire:change="SyncPermission($('#p'+{{$permission->id}}).is(':checked'), '{{$permission->name}}')"
                                                    id="p{{$permission->id}}"
                                                    value="{{$permission->id}}"
                                                    class="new-control-input"
                                                    {{ $permission->checked == 1 ? 'checked' : '' }}>
                                                    <span class="new-control-indicator"></span>
                                                    <h6>{{$permission->name}}</h6>
                                                </label>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <h6>{{ \App\Models\User::permission($permission->name)->count() }}</h6>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$permissions->links()}}
                        </div>
                    </div>
                </div>   
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        window.livewire.on('sync-error', Msg => {
            noty(Msg)
        })
        window.livewire.on('permi', Msg => {
            noty(Msg)
        })
        window.livewire.on('sync-all', Msg => {
            noty(Msg)
        })
        window.livewire.on('remove-all', Msg => {
            noty(Msg)
        })
    });

    function Revocar()
    {
        let me = this
        swal({
            title: 'CONFIRMAR',
            text: '¿DESEAS REVOCAR TODOS LOS PERMISOS?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3B3F5C',//#3B3F5C
            cancelButtonColor: '#fff',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            closeOnConfirm: false
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('revokeall')
                swal.close()
            }
        })
    }
</script>