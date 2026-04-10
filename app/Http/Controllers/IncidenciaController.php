<?php

namespace App\Http\Controllers;
use App\Models\Sistema;
use App\Models\Area;
use App\Models\TipoIncidencia;
use App\Models\Incidencia; // También lo necesitaremos más adelante
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel; 
use App\Exports\IncidenciasExport;
use Barryvdh\DomPDF\Facade\Pdf;

class IncidenciaController extends Controller
{

    public function exportExcel() 
    {
        return Excel::download(new \App\Exports\IncidenciasExport, 'reporte-incidencias.xlsx');
        
    }

        /* public function __construct()
            {
                $this->middleware('auth'); // con esta instrucción restringe y obliga al usuario a pedir el acceso de autenticidad
            }     */                          // Evita que el usuario pueda blindarse la autenticidad ej. teclear http://127.0.0.1:8000/articulos
            
       

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Traemos todos los registros para que DataTables los gestione
    $incidencias = Incidencia::with(['sistema', 'area', 'tipoIncidencia'])->get();
    return view('incidencias.index', compact('incidencias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Traemos toda la información de las tablas maestras
        $sistemas = Sistema::all();
        $tipos = TipoIncidencia::all();
        $areas = Area::all();

        // Enviamos las variables a la vista 'create'
        return view('incidencias.create', compact('sistemas', 'tipos', 'areas'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
                
        $request->validate([
        'sistema_id' => 'required|exists:sistemas,id',
        'tipo_incidencia_id' => 'required|exists:tipo_incidencias,id',
        'area_id' => 'required|exists:areas,id',
        'descripcion' => 'required|string',
        'observaciones' => 'nullable|string', // Validamos observaciones
        'evidencia' => 'nullable|image|max:2048',
         ]);

        // Creamos el registro con todos los campos
        $data = $request->all();

        // Lógica para la imagen (evidencia)
       if ($request->hasFile('evidencia')) {
                // 1. Guardar el archivo físicamente en public/uploads/evidencias
                $file = $request->file('evidencia');
                $nombreImagen = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/evidencias'), $nombreImagen);
        
        // 2. Guardar la ruta en el array para la BD
        $data['evidencia'] = 'uploads/evidencias/' . $nombreImagen;
         }
        Incidencia::create($data); // Esto funciona gracias al $fillable que pusimos en el Modelo

        return redirect()->route('incidencias.index')->with('success', 'Incidencia guardada con éxito.');

      
       //*****Otro metodo*****
       
            /* // 1. Validar los datos
                $request->validate([
                    'sistema_id' => 'required',
                    'tipo_incidencia_id' => 'required',
                    'area_id' => 'required',
                    'descripcion' => 'required',
                    'observaciones' => 'nullable|string', // Validación sencilla
                    'evidencia' => 'nullable|image|mimes:jpg,png,jpeg|max:2048', // Max 2MB
                ]);

                // 2. Crear la instancia de la incidencia
                $incidencia = new Incidencia();
                $incidencia->sistema_id = $request->sistema_id;
                $incidencia->tipo_incidencia_id = $request->tipo_incidencia_id;
                $incidencia->area_id = $request->area_id;
                $incidencia->descripcion = $request->descripcion;
                $incidencia->observaciones = $request->observaciones;

                // 3. Manejar la subida de la evidencia (Imagen)
                if ($request->hasFile('evidencia')) {
                    $file = $request->file('evidencia');
                    $destino = 'uploads/evidencias/';
                    $nombreArchivo = time() . '-' . $file->getClientOriginalName();
                    $file->move(public_path($destino), $nombreArchivo); // Guarda en C:\xampp\htdocs\tu_proyecto\public\uploads\evidencias
                    
                    $incidencia->evidencia = $destino . $nombreArchivo;
                }

                     $incidencia->save();

            return redirect()->route('incidencias.index')->with('success', 'Incidencia reportada correctamente.'); 
         */
    
    
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
    public function edit(Incidencia $incidencia)
    {
        $sistemas = Sistema::all();
        $tipos = TipoIncidencia::all();
        $areas = Area::all();
        
        return view('incidencias.edit', compact('incidencia', 'sistemas', 'tipos', 'areas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Incidencia $incidencia)
    {
            $request->validate([
            'tipo_incidencia_id' => 'required',
            'sistema_id' => 'required',
            'area_id' => 'required',
            'descripcion' => 'required',
            'observaciones' => 'nullable|string', // Cambiado de required a nullable
            'evidencia' => 'nullable|image|max:2048'
          
            ]);

            $data = $request->all();

            if ($request->hasFile('evidencia')) {
                // Si subes una nueva, guardamos la ruta
                $file = $request->file('evidencia');
                $nombreImagen = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/evidencias'), $nombreImagen);
                $data['evidencia'] = 'uploads/evidencias/' . $nombreImagen;
            }

            $incidencia->update($data);

            return redirect()->route('incidencias.index')->with('success', 'Incidencia actualizada correctamente.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // 1. Buscar la incidencia por su ID
        $incidencia = Incidencia::findOrFail($id);

        // 2. Opcional: Borrar el archivo físico de la evidencia del disco duro
        if ($incidencia->evidencia && file_exists(public_path($incidencia->evidencia))) {
            unlink(public_path($incidencia->evidencia));
        }

        // 3. Eliminar el registro de la base de datos
        $incidencia->delete();

        // 4. Redireccionar con un mensaje de éxito
        return redirect()->route('incidenci as.index')->with('success', 'Incidencia eliminada correctamente.');
    }

    public function exportPdf() 
    {
        $incidencias = Incidencia::with(['sistema', 'area', 'tipoIncidencia'])->get();
                
        // Convertimos el logo a Base64 para que el PDF lo lea sin errores
        $path = public_path('img/logo.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $logoBase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $pdf = Pdf::loadView('incidencias.pdf', compact('incidencias', 'logoBase64'))
                ->setPaper('letter', 'portrait')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'isPhpEnabled' => true, // IMPORTANTE para el número de página
                ]);

            // --- AQUÍ ESTÁ EL TRUCO ---
        $pdf->render(); // Renderizamos primero el PDF para poder acceder al canvas
        $canvas = $pdf->getCanvas();
        
        // Obtenemos dimensiones de la página
        $width = $canvas->get_width();
        $height = $canvas->get_height();

        // Definimos el formato del texto: "Página X de Y"
        // {PAGE_NUM} y {PAGE_COUNT} son variables internas que DomPDF entiende aquí
        $text = "Página {PAGE_NUM} de {PAGE_COUNT}";
        
        // Definimos fuente y tamaño
        $font = null; // Usará la fuente por defecto
        $size = 10;
        $color = array(0.5, 0.5, 0.5); // Color gris (RGB en escala 0-1)
        
        // Dibujamos el texto (x, y, texto, fuente, tamaño, color)
        // El 520 es la altura (ajusta este número si sale muy arriba o muy abajo)
        $canvas->page_text($width / 2.3, $height - 35, $text, $font, $size, $color);

        return $pdf->download('reporte-incidencias.pdf');

        
    }
}
