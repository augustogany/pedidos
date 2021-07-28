<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('.tblscroll').niceScroll({
            cursorcolor: "#515365",
            cursorwidth: "30px",
            background: "rgba(20,20,20,0.3)",
            cursorborder: "0px",
            cursorborderradius: 3
        })

        $("#selProvider").select2({
            ajax: { 
                url: "{{route('getProviders')}}",
                type: "get",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                }
            }
        });  
        $('#selProvider').on('select2:select', function (e) {
            var data = e.params.data;
            console.log(data)
            if (data) {
                @this.set('contact_id', data.id);
                @this.set('nit', data.ci);
            }					
        });
    })
    
    function Confirm(id,eventName,text)
    {
        let me = this
        swal({
            title: 'CONFIRMAR',
            text: text,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3B3F5C',//#3B3F5C
            cancelButtonColor: '#fff',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            closeOnConfirm: false
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit(eventName,id)
                swal.close()
            }
        })
    }
</script>