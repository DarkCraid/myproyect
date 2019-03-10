<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Personas;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Persona;

class Personas extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$personas = new Persona();
        //$data=$personas::all();
        $data = [
        'personas' => Persona::all(),
        
        ];

        return view('formulario',compact('data'));
        //return view('buscar','personas@index')->with('Personas',$personas);
    }

    public function buscar()
    {
        //$personas = new Persona();
        //$data=$personas::all();
        $data = [
        'personas' => Persona::all()
        
        ];

        return view('buscar',compact('data'));
        //return view('buscar','personas@index')->with('Personas',$personas);
    }

    public function eliminar(Request $request){
        $data = $request->all();
        print_r($data);
        $per = Persona::find($data['id']);

        $persona = $per->Nombre;

        $per->delete($per);
        
        return $persona;

    }

    public function modificar($id){
        $per = Persona::find($id);        
        $data = [
        'personas' => Persona::all(),
        'x' => $per
        
        ];

        return view('formulario',compact('data'));

    }



    public function actualizar(Request $req){
        $input = $req->all();
        $input['Fecha_nac'] = date('Y-m-d', strtotime($input['Fecha_nac']));
        
        echo "<pre>";
        print_r($input);
        echo "</pre>";

        //$data = new Persona();

        Persona::where('id', $input['id'])  // find your user by their email
        ->limit(1)  // optional - to ensure only one record is updated.
        ->update($input); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $data = new Persona();
      $data->Nombre = $request-> input('Nombre');
      $data->Apellidos = $request-> input('Apellidos');
      $data->Edad = $request-> input('Edad');
      $data->Fecha_nac = date('Y-m-d H:i:s', strtotime($request ->input('Fecha_nac')));//$request-> input('fechaNac');
      $data->Dias = $request-> input ('Dias');
      $data->Horario = $request-> input ('Horario');
      $data->save();
      return $data-> id;
     
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
