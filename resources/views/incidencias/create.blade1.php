<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registrar Nueva Incidencia
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 overflow-hidden shadow-xl sm:rounded-lg">
                
                <form action="{{ route('incidencias.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Sistema --}}
                        <div class="mb-3">
                            <label class="block font-medium text-sm text-gray-700">Sistema:</label>
                            <select name="sistema_id" class="form-select w-full border-gray-300 rounded-md shadow-sm" required>
                                @foreach($sistemas as $sistema)
                                    <option value="{{ $sistema->id }}">{{ $sistema->nombre_sistema }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tipo de Incidencia --}}
                        <div class="mb-3">
                            <label class="block font-medium text-sm text-gray-700">Tipo de Incidencia:</label>
                            <select name="tipo_incidencia_id" class="form-select w-full border-gray-300 rounded-md shadow-sm" required>
                                @foreach($tipos as $tipo)
                                    <option value="{{ $tipo->id }}">{{ $tipo->nombre_tipo }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Área --}}
                    <div class="mb-3">
                        <label class="block font-medium text-sm text-gray-700">Área:</label>
                        <select name="area_id" class="form-select w-full border-gray-300 rounded-md shadow-sm" required>
                            @foreach($areas as $area)
                                <option value="{{ $area->id }}">{{ $area->nombre_area }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Descripción --}}
                    <div class="mb-3">
                        <label class="block font-medium text-sm text-gray-700">Descripción:</label>
                        <textarea name="descripcion" class="form-control w-full border-gray-300 rounded-md shadow-sm" rows="3" required></textarea>
                    </div>

                    {{-- Observaciones (El campo que faltaba) --}}
                    <div class="mb-3">
                        <label class="block font-medium text-sm text-gray-700">Observaciones:</label>
                        <textarea name="observaciones" class="form-control w-full border-gray-300 rounded-md shadow-sm" rows="3"></textarea>
                    </div>

                    {{-- Evidencia --}}
                    <div class="mb-3">
                        <label class="block font-medium text-sm text-gray-700">Evidencia (Imagen):</label>
                        <input type="file" name="evidencia" class="form-control w-full">
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" 
                                class="btn btn-primary" 
                                style="background-color: #2563eb !important; color: white !important; padding: 10px 20px; border-radius: 6px; border: none; cursor: pointer; font-weight: bold;">
                            {{ __('Guardar Incidencia') }}
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>