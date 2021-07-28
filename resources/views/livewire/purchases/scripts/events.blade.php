<script>
    document.addEventListener('DOMContentLoaded', function () {
        window.livewire.on('provider-added', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        })
        window.livewire.on('purchase-ok', Msg => {
            noty(Msg)
        })
        window.livewire.on('scan-ok', Msg => {
            noty(Msg)
        })
        window.livewire.on('scan-notfound', Msg => {
            noty(Msg,2)
        })
        window.livewire.on('purchase-error', Msg => {
            noty(Msg)
        })
    })
</script>
