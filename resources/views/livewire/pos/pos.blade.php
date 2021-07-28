@push('style')
<link rel="stylesheet" href="{{ asset('css/select2.min.css')}}" type="text/css">
@endpush
<div>
    <style></style>
    <div class="row layout-top-spacing">
        <div class="col-sm-12 col-md-8">
            <!-- DETALLE -->
            @include('livewire.pos.partials.detail')
        </div>
        <div class="col-sm-12 col-md-4">
            <!-- TOTAL -->
            @include('livewire.pos.partials.total')

            <!-- DENOMINACIONES -->
            @include('livewire.pos.partials.coins')
        </div>
        @include("livewire.pos.modalcustomer")
    </div>
</div>
<script src="{{ asset('js/keypress.js')}}"></script>
<script src="{{ asset('js/onscan.min.js')}}"></script>
@push('script')
<script src="{{ asset('js/select2.min.js') }}"></script>
@endpush
@include('livewire.pos.scripts.shortcuts')
@include('livewire.pos.scripts.events')
@include('livewire.pos.scripts.general')
@include('livewire.pos.scripts.scan')