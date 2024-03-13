<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        @this.on('confirmDestroy', id => {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Confirme que realmente desea eliminar este registro",
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: '¡Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('destroy', id);
                }
            });
        });
    });
</script>
