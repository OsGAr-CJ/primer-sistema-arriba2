<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $areas = \App\Models\Area::all();
       return view('areas.index', compact('areas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
        {
            // 1. Validamos que el nombre del área sea obligatorio y único
            $request->validate([
                'nombre_area' => 'required|unique:areas|max:191',
                'usuario_reporta' => 'nullable|max:191'
            ]);

            // 2. Creamos el registro
            \App\Models\Area::create($request->all());

            // 3. Redireccionamos con un mensaje de éxito
            return redirect()->route('areas.index')->with('success', '¡Área registrada con éxito!');
        }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_area' => 'required|max:191|unique:areas,nombre_area,' . $id,
            'usuario_reporta' => 'nullable|max:191'
        ]);

        $area = \App\Models\Area::findOrFail($id);
        $area->update($request->all());

        return redirect()->route('areas.index')->with('success', '¡Registro actualizado!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $area = \App\Models\Area::findOrFail($id);
        $area->delete();
        return redirect()->route('areas.index')->with('success', 'Área eliminada correctamente');
    }
}
