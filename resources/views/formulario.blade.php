<?php 

if(isset($data['x'])){	// isset (si existe)
	
}

	$dias = array(
		['dia' => 'Lunes', 		'horas' => null],
		['dia' => 'Martes', 	'horas' => null],
		['dia' => 'Miercoles', 	'horas' => null],
		['dia' => 'Jueves', 	'horas' => null],
		['dia' => 'Viernes', 	'horas' => null]
	);

	$horarios = array(
		'9:00:00 am',
		'10:00:00 am',
		'11:00:00 am',
		'12:00:00 am',
		'1:00:00 pm',
		'2:00:00 pm',
		'3:00:00 pm',
		'4:00:00 pm',
		'5:00:00 pm'
	);
	foreach ($dias as $key => $dia) { //a cada dia se le asigna las horas 
		$dias[$key]['horas'] = $horarios;
	}
	foreach ($data['personas'] as $key => $per) {//lee cada persona guardada en la base de datos

		foreach ($dias as $key => $dia) {//lee todos los dias de la variable dias
			
			if($dia['dia'] == $per['Dias']){//pregunta si el dia encontrado es igual a la que trae la persona
				
				$dias[$key]['horas'] = \array_diff($dias[$key]['horas'], [$per['Horario']]);// ELIMINA LAS HORAS OCUPADAS SEGUN EL DIA
			}
		}
	}

	foreach ($dias as $key => $dia) {
		if(count($dia['horas']) <= 0)
			unset($dias[$key]);
	}
	//echo "<pre>";
	//print_r($dias);
	//echo "</pre>";

?>

@extends('footer')
@extends('header') <!--se pone al reves para que se ejecute primero el header -->

@section('header')
	@parent
	<div ng-controller="ctrl">

		<form name="FRMpersona">
			<h1 class="titulo">Consultorio</h1>
			<div class="col-xs-6">
				<div class="col-xs-12">
					<label class="text">Nombre</label>
					<input  class="form-control" type="text" ng-model="persona.Nombre" name="nombre" value="{{ ((isset($data['x']))? $data['x']->Nombre : '') }}" ng-keypress="validInput('text',$event)" required/>
				</div>
				<br></br>
				<div class="col-xs-12">
					<label class="text">Apellido</label>
					<input class="form-control" type="text" ng-model="persona.Apellidos" name="apellido" ng-keypress="validInput('text',$event)" required/>
				</div>
				<br></br>
				<div class="col-xs-12">
					<label class="text">Edad</label>
					<input class="form-control" type="number" ng-model="persona.Edad" name="edad" ng-keypress="validInput('number',$event)" ng-max="150" ng-min="0" disabled/>
				</div>
				<br></br>
				<div class="col-xs-12">
					<label class="text">Fecha de Nacimiento</label>
					<input 
						min="@{{ min }}" 
						max="@{{ max }}"
						type="date"
						class="form-control"
						ng-model="persona.Fecha_nac" 
						name="fechaNac" 
						ng-change="fechaNacCambio()" 
						required
						
					/>
				</div>
				<br></br>
				<div class="col-xs-12">
					<label class="text">Fecha de Cita</label>
					 <select class="form-control" id="dias" ng-model="persona.Dias" ng-change="cambio()" name="dias" required>
						<?php foreach ($dias as $key => $dia): ?>
		
							<option value="<?php echo $dia['dia']; ?>"><?php echo $dia['dia']; ?></option>
						<?php endforeach ?>
					  </select>
				</div>
				<br></br>
				<div class="col-xs-12">
					<label class="text">Horario</label>
					 <select ng-options="hora for hora in Horario"  class="form-control" id="hora" ng-change=cambio() ng-model="persona.Horario"  name="horario" required>

					  </select>
				</div>
				<?php if(isset($data['x'])): // si existe una persona para modificar enotnces?>
					<button  type="button" class="btn btn-success agregar" ng-click="actualizar({{ $data['x']['id'] }})" ng-disabled="!FRMpersona.$valid">ACTUALIZAR</button>
				<?php else: // si no existe entonces guardar una nueva persona?>
					<button  type="button" class="btn btn-success agregar" ng-click="guardar()" ng-disabled="!FRMpersona.$valid">GUARDAR</button>
				<?php endif; ?>

				<button onclick="location.href='/buscar'" type="button" class="btn btn-info buscar" ng-click="buscar()">BUSCAR</button>
			</div>
			<br></br>
			
		</form>
	</div>
	@section('footer')
		@parent
		app.controller('ctrl',function($scope,$http,$filter){
		var date = new Date();	
		
		$scope.Horario = [];

		let fech = new Date();
		let ano = fech.getFullYear();
		let mes = parseInt(fech.getMonth() + 1);
		let dia = fech.getDate();

		//	ano + "-" + mes + "-" + dia
		$scope.max = `${ano}-${((mes < 10)? '0'+mes : mes)}-${((dia < 10)? '0'+dia : dia)}`;
		//	a la fecha actual se le restan 150 años
		$scope.min = `${parseInt(ano - 150)}-${((mes < 10)? '0'+mes : mes)}-${((dia < 10)? '0'+dia : dia)}`;

		let dias = <?= json_encode($dias) ?>;
		let modificar = <?= ((isset($data['x']))? json_encode($data['x']) : 'undefined') ?>;
		console.log(modificar);

	

		if(modificar == undefined)
			$scope.persona={};
		else{
			$scope.persona = modificar;
			for(let dia of dias){
				if(dia.dia == $scope.persona.Dias){      
					$scope.Horario = dia.horas;                           
					$scope.Horario = Object.values($scope.Horario);
					$scope.Horario.push($scope.persona.Horario);
				}
			}
		}
									//**************************************FUNCION DE GUARDAR
		$scope.guardar=function(){
			$('button').attr('disabled','disabled');
			$http.post('/save',$scope.persona).then(
				function(response){
					window.location.reload();
				},function(errorResponse){

			}
		)};


								//***************************** FUNCION PARA ACTUALIZAR UNA PERSONA
		$scope.actualizar=function(id){
			console.log('id: ',id);

			$scope.persona.id = id;
			$http.post('/actualizar',$scope.persona).then(
				function(response){
					window.location.reload();
				},function(errorResponse){

				}
			)
		};



		                                                //**********************FUNCION DE CAMBIO DE HORAS

		$scope.cambio = function() {
   			console.log($scope.persona.Dias);

   			for(let dia of dias){
				if(dia.dia == $scope.persona.Dias){      //si el dia que buscamos es igual al dia del select que pulsamos (Martes == Martes)
					$scope.Horario = dia.horas;  //al horario que queremos mostrar le damos las                          
						console.log("from php: ",dia.horas);								 // horas que encontramos del dia que seleccionamos
						console.log('from angular: ',$scope.Horario);
					}
				}
		}




		$scope.fechaNacCambio = function(){
			let currentYear = new Date().getTime();// fecha de hoy en milisegundos
			var one_day		= 1000*60*60*24;// un dia en milisegundos

			let selectedYear 	= new Date($scope.persona.Fecha_nac).getTime();// fecha seleccionada en milisegundos

			let difference_ms 	= currentYear - selectedYear;// diferencia entre la fecha de hoy y la seleccionada en milisegundos
			let dias 			= Math.round(difference_ms/one_day);// nos dice cuantos dias hay entre esas dos fechas

			if(dias < 365)// si la cantidad de dias es menor a un año entonces tiene 0 años
				$scope.persona.Edad = 0;
			else// si la cantidad de dias es mayor a un año entonces calcular cuantos años son en esa cantidad de dias
				$scope.persona.Edad = parseInt(dias/365);
			

			
		}





					//**************************************** validacion de caracteres
		$scope.validInput = function(tipo,e){
			let key 	= (e.keyCode ? e.keyCode : e.which);
			teclado 	= String.fromCharCode(key).toLowerCase();
			especiales 	= "8-09";

			switch(tipo){
				case "text": 	var caracteres = " abcdefghijklmnopqrstuvwxyzñáéíóúü";	break;
				case "number":	var caracteres = "1234567890";							break;
			}
    		
    		teclado_especial = false;
		    for(var i in especiales){
		        if(key==especiales[i]){
		            teclado_especial=true;
		            break;
		        }
		    }

			// si la tecla que pulsamos no esta en los caracteres permitidos y no es una tecla especial como borrar
			// entonces evitar que se escriba en el input
    		if(caracteres.indexOf(teclado) == -1 && !teclado_especial){
        		e.preventDefault(); // evita que se escriba en el input
    		}
		}
		
		$scope.persona.Fecha_nac = new Date ($filter('date')($scope.persona.Fecha_nac));	

	});	
		</script>

	@endsection
@endsection

