<style>
    .pagination {
        gap: 5px;  /* Espacio entre botones */
    }
    
    .page-link {
        display: flex;          /* Para centrar los iconos */
        align-items: center;    /* Alineación vertical */
        justify-content: center; /* Alineación horizontal */
        padding: 8px 12px;      /* Padding uniforme */
        height: 38px;           /* Altura fija */
        line-height: 1;         /* Evitar desbordamiento */
    }

    .page-link i {
        font-size: 14px;        /* Tamaño del icono */
        vertical-align: middle; /* Alineación vertical del icono */
    }
</style>

<div class="card-footer bg-white border-top-0 p-3">
    {{ $actividades->links() }}
</div> 