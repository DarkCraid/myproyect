@extends('footer')
@extends('header')

@section('header')
	@parent
	<?php

$link = new PDO('mysql:host=localhost;dbname=prueba', 'root', ''); // el campo vacio es para la password. 

?>
	<div ng-controller="ctrl">
		<form>
			<h2 class="titulo"> Registros </h2>

			<div class="col-lg-12">
				<a href="{{URL::to('/formulario')}}" class="btn btn-info buscar">Regresar</a>
			</div>
			<div class="col-lg-12">
				<label class="text">Buscar</label>
				<input type="text" ng-model="nombre" class="form-control">
			</div>
			<br></br>
			<div class="col-lg-12"></div>
			<table class="table tabla"> 
		  		<thead class="thead-dark">
			    	<tr>
				      <th class="txtTabla" scope="col">Nombre</th>
				      <th class="txtTabla" scope="col">Apellido</th>
				      <th class="txtTabla" scope="col">Edad</th>
				      <th class="txtTabla" scope="col">Fecha de Nacimiento</th>
				      <th class="txtTabla" scope="col">Dia de Cita</th>
				      <th class="txtTabla" scope="col">Hora de Cita</th>
			    	</tr>
		  		</thead>
		  		<tbody ng-repeat="per in personas | filter:nombre as result" >

					
					<tr>
						<td class="txtTabla">@{{ per.Nombre }}</td>
					    <td class="txtTabla">@{{ per.Apellidos }}</td>
					    <td class="txtTabla">@{{per.Edad}}</td>
					    <td class="txtTabla">@{{per.Fecha_nac}}</td>
					    <td class="txtTabla">@{{per.Dias}}</td>
					    <td class="txtTabla">@{{per.Horario}}</td>
					    <td> <button ng-click="delete(per.id)" class="btn btn-danger eliminar">Eliminar</button></td>
					    <td> <a href="{{URL::to('/modificar')}}/@{{per.id}}" class="btn btn-warning editar">Modificar</a></td>
					 </tr>
				
						
		 		</tbody> 
		 		</tbody>
			</table>
		</form>
	</div>

	@section('footer')
		@parent
		app.controller('ctrl',function($scope,$http){

		$scope.personas = <?= json_encode($data['personas']) ?>;

		$scope.delete=function(indice){
			(confirm('Deseas Eliminar?'))?
			$http.post('/eliminar',{id:indice})
				.then(function(resp){
					//alert("se elimino a "+resp.data);
					console.log(resp);
					window.location.reload();
				},
				function(err){console.log(err)}
			)
    		:''; //el splice reacomoda el array como si no hubiera pasado nada
  		};
		
		 $scope.edit=function(indice){
			(confirm('Deseas Modificar?'))?
			$http({
			    url: '/modificar', 
			    method: "GET",
			    params: {id: indice}
			 })
    		:'';

  		};

	});	
		</script>
	@endsection
@endsection

