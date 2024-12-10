<thead>
    <tr>
        <th class="text-center align-middle">
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'fecha', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" 
               class="text-decoration-none text-dark d-flex align-items-center justify-content-center">
                <i class="fas fa-calendar-alt me-1"></i> FECHA
                @if(request('sort') == 'fecha')
                    <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                @else
                    <i class="fas fa-sort ms-1 text-muted"></i>
                @endif
            </a>
        </th>
        <th class="text-center align-middle">
            <i class="fas fa-cogs"></i> SERVICIO
        </th>
        <th class="text-center align-middle">
            <i class="fas fa-stethoscope"></i> DIAGNÓSTICO
        </th>
        <th class="text-center align-middle">
            <i class="fas fa-building"></i> SEDE
        </th>
        <th class="text-center align-middle">
            <i class="fas fa-building"></i> DEPARTAMENTO
        </th>
        <th class="text-center align-middle">
            <i class="fas fa-user"></i> RESPONSABLE
        </th>
        <th class="text-center align-middle">
            <i class="fas fa-check-circle"></i> ESTADO
        </th>
        <th class="text-center align-middle">
            <i class="fas fa-tools"></i> ACCIONES
        </th>
    </tr>
</thead> 