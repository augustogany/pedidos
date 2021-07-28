<div class="row mt-3">
    <div class="col-sm-12">
        <div class="connect-sorting">
            <h5 class="text-center mb-2">TOTALES</h5>
            <div class="connect-sorting-content mt-4">
                <div class="card simple-title-task-ui-sortable-handle">
                    <div class="card-body">
                        <div class="input-group input-group-md mb-3">
                            <div class="task-header">
                                <div>
                                    <h2>TOTAL: Bs{{number_format($total,2)}}</h2>
                                    <input type="hidden" id="hiddenTotal" value="{{$total}}">
                                </div>
                                <div>
                                    <h4 class="mt-3">Articulos: {{$itemsQuantity}}</h4>
                                </div>
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
                                    <button wire:click.prevent="saveSale" class="btn btn-dark btn-md btn-block">GUARDAR F9</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>