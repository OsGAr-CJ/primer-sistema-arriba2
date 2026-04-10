@extends('adminlte::page')

@section('title', 'Sistemas Nuevos')

@section('content_header')
    <h1 style="text-align: center; font-weight: bold; color: #e20e3c;">Ciudad Judicial</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Listado de Sistemas Registrados</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-alta">
                <i class="fas fa-plus"></i> Nueva Sistema
            </button>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <table id="tabla-catalogos" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del Sistema</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sistemas as $sistema)
                <tr>
                    <td>{{ $sistema->id }}</td>
                    <td>{{ $sistema->nombre_sistema }}</td>                    
                    <td>
                        <div class="btn-group">
                            <button type="button" 
                                    class="btn btn-warning btn-sm btn-edit" 
                                    data-id="{{ $sistema->id }}" 
                                    data-nombre="{{ $sistema->nombre_sistema }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('sistemas.destroy', $sistema->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este sistema?')">
                                    <i class="fas fa-trash"></i>
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

{{-- MODAL --}}
<div class="modal fade" id="modal-alta">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Registrar Nuevo Sistema</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('sistemas.store') }}" method="POST" id="form-sistemas">
                @csrf
                
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre del Sistema:</label>
                        <input type="text" name="nombre_sistema" id="input_nombre" class="form-control" required>
                    </div>                    
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar Registro</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    $(document).ready(function() {
        // Inicializar DataTable
        $('#tabla-catalogos').DataTable({
            "pageLength": 5,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
            }
        });
     });
        // Evento Editar - VERSIÓN CORREGIDA
        $(document).on('click', '.btn-edit', function() {
            var id = $(this).data('id');
            var nombre = $(this).data('nombre');

            alert (nombre);
            //var usuario = $(this).data('usuario');

            // Guardar el ID en un campo oculto o data attribute
            $('#form-sistemas').data('id', id);
            
            // Cambiar la acción del formulario
            var actionUrl = '/sistemas/' + id;
            $('#form-sistemas').attr('action', actionUrl);
            
            // Agregar o actualizar el campo _method
            if ($('#form-sistemas input[name="_method"]').length === 0) {
                $('#form-sistemas').append('<input type="hidden" name="_method" value="PUT">');
            } else {
                $('#form-sistemas input[name="_method"]').val('PUT');
            }
            
            // Asegurar que el método POST se mantenga
            if ($('#form-sistemas input[name="_token"]').length === 0) {
                $('#form-sistemas').append('@csrf');
            }

            // Llenar campos
            $('#input_nombre').val(nombre);
           // $('#input_usuario').val(usuario);
            
            // Cambiar UI del modal
            $('.modal-title').text('Editar Sistema: ' + nombre);
            $('.modal-header').removeClass('bg-primary').addClass('bg-warning');
            
            // Mostrar modal
            $('#modal-alta').modal('show');
        });

        // Limpiar al cerrar el modal
        $('#modal-alta').on('hidden.bs.modal', function () {
            // Restaurar acción del formulario para crear
            $('#form-sistemas').attr('action', '{{ route("sistemas.store") }}');
            
            // Eliminar el campo _method si existe
            $('#form-sistemas input[name="_method"]').remove();
            
            // Restaurar UI del modal
            $('.modal-header').removeClass('bg-warning').addClass('bg-primary');
            $('.modal-title').text('Registrar Nuevo Sistema');
            
            // Limpiar el formulario
            $('#form-sistemas')[0].reset();
            
            // Limpiar el data-id
            $('#form-sistemas').removeData('id');
        });
   
</script>
@stop