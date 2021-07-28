@push('style')
<link rel="stylesheet" href="{{ asset('css/select2.min.css')}}" type="text/css">
@endpush
<div>
    <style></style>
    <div class="row layout-top-spacing">
        <div class="col-sm-12 col-md-8">
            <!-- DETALLE -->
            @include('livewire.purchases.partials.detail')
        </div>
        <div class="col-sm-12 col-md-4">
            <!-- FACTURA -->
            @include('livewire.purchases.partials.factura')

            <!-- PROVEEDOR Y TOTAL -->
            @include('livewire.purchases.partials.total')
        </div>
        @include("livewire.purchases.modalprovider")
    </div>
</div>
<script src="{{ asset('js/keypress.js')}}"></script>
<script src="{{ asset('js/onscan.min.js')}}"></script>
@push('script')
<script src="{{ asset('js/select2.min.js') }}"></script>
@endpush
@include('livewire.purchases.scripts.shortcuts')
@include('livewire.purchases.scripts.events')
@include('livewire.purchases.scripts.general')
@include('livewire.purchases.scripts.scan')