<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SistemaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $sistemas = \App\Models\Sistema::all();
       return view('sistemas.index', compact('sistemas'));
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
            // 1. Validamos que el nombre del sistema sea obligatorio y único
            $request->validate([
                'nombre_sistema' => 'required|unique:sistemas|max:191',
               
            ]);

            // 2. Creamos el registro
            \App\Models\Sistema::create($request->all());

            // 3. Redireccionamos con un mensaje de éxito
            return redirect()->route('sistemas.index')->with('success', 'Sistema registrada con éxito!');
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
            'nombre_sistema' => 'required|max:191|unique:sistemas,nombre_sistema,' . $id
            
        ]);

        $sistema = \App\Models\Sistema::findOrFail($id);
        $sistema->update($request->all());
       // die("Tu mensaje aquí...se guardó update");
        return redirect()->route('sistemas.index')->with('success', '¡Registro actualizado!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sistema = \App\Models\Sistema::findOrFail($id);
        $sistema->delete();
        return redirect()->route('sistemas.index')->with('success', 'Sistema eliminada correctamente');
    }
}
