<?php

	namespace App\Http\Controllers;
	use App\Http\Controllers\Controller;
	use Illuminate\Http\Request; //porque se va recibir peticiones de la vista al controlador, con este archivo nosotros podemos trabajar con las peticiones

	class Prueba82 extends Controller{

		function notificacion(){
			//return 'Tienes una notificacion en la bandeja-.....-.-.';
			return view('notificacion');
		}

		

		function save(Request $request){
			return $request->all();
		}
	}



?>