@extends('layouts.admin')

@section('header')
    Listado de Incidencias
@endsection

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
@section('content')


<!-- Termina  Archivo ccs para implementar DataTable -->

  <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bitácora de Incidencias') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                {{-- 1. Alertas de Sesión (Limpias) --}}
                @if (session('success'))
                    <div class="mb-4 font-medium text-sm text-green-600 bg-green-100 p-3 rounded-md shadow-sm border border-green-200">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 font-medium text-sm text-red-600 bg-red-100 p-3 rounded-md shadow-sm border border-red-200">
                        {{ session('error') }}
                    </div>
                @endif
                <h2 style="text-align: right; font-weight: bold; color: #0066cc; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);">Exportación del Reporte</h2>
                {{-- 2. Barra de Herramientas (Botones Alineados) --}}
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <a href="{{ route('incidencias.create') }}" 
                       style="background-color: #4f46e5; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none; font-weight: bold; font-size: 14px;">
                        + Nueva Incidencia
                    </a>

                    <div style="display: flex; gap: 10px;">
                        {{-- Botón Excel --}}
                        <a href="{{ route('incidencias.excel') }}" 
                           style="background-color: #16a34a; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none; font-weight: bold; font-size: 14px; display: inline-block;">
                            Excel
                        </a>

                        {{-- Botón PDF --}}
                        <a href="{{ route('incidencias.pdf') }}"
                           style="background-color: #dc2626; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none; font-weight: bold; font-size: 14px; display: inline-block;">
                            PDF
                        </a>
                    </div>
                </div>

                {{-- 3. Tabla de Resultados --}}
                <div class="overflow-x-auto mt-6">
                    <!-- Se asigna Id para implementar DataTable -->
                    <table id='tabla-incidencias' class="table table-striped table-bordered shadow-lg mt-4">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase">ID</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase">Sistema</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase">Área</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase">Descripción</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase">Observaciones</th>
                                <th class="px-4 py-2 text-center text-xs font-bold text-gray-500 uppercase">Evidencia</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase">Fecha</th>
                                <th class="px-4 py-2 text-center text-xs font-bold text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($incidencias as $incidencia)
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $incidencia->id }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $incidencia->sistema->nombre_sistema }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $incidencia->area->nombre_area }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    <span title="{{ $incidencia->descripcion }}">
                                        {{ Str::limit($incidencia->descripcion, 30) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500 italic">
                                    {{ Str::limit($incidencia->observaciones, 30) ?? 'Sin observaciones' }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($incidencia->evidencia)
                                        <a href="{{ asset($incidencia->evidencia) }}" target="_blank">
                                            <img src="{{ asset($incidencia->evidencia) }}" class="h-10 w-10 rounded shadow-sm mx-auto object-cover border">
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400">Sin foto</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500">
                                    {{ $incidencia->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-4 py-3 text-center text-sm font-medium">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('incidencias.edit', $incidencia->id) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 px-2 py-1 rounded">
                                            Editar
                                        </a>
                                        <form action="{{ route('incidencias.destroy', $incidencia->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 px-2 py-1 rounded">
                                                Borrar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                </div>

            </div>
        </div>
    </div>  
    


@endsection

@push('js')
    <!-- JS para implementar DataTable -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#tabla-incidencias').DataTable({
            "pageLength": 5, // <--- Aquí definimos que sea de 5 en 5
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json" // Traducción al español
            },
             // Esto fuerza a que la paginación use los números de Bootstrap
            "pagingType": "full_numbers"
        });
       
    });
</script>
<!-- Termina ccs para implementar DataTable -->
@endpush