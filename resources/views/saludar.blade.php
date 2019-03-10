<!DOCTYPE html>
<html ng-app="app">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<title>Laravel</title>
	<link rel="stylesheet" type="text/css" href="">
	<script src="{{asset('js/angular.js')}}" type="text/javascript"></script>
</head>
<body ng-controller="ctrl">
	<h1>@{{saludo}}</h1>

</body>
</html>

<script>
	
	var app=angular.module('app',[]);
	app.controller('ctrl',function($scope,$http){

		$scope.saludo="Bienvenidos al curso , este archivo genera una peticion de tipo POST";
		$scope.persona={
			nombre: 'Vreni',
			edad: 21,
			matricula: '2016030146'
		};
		$scope.send=function(){
			$http.post('/save',$scope.persona).then(
				function(response){

				},function(errorResponsive){

				}
			);
		}
		$scope.send();
	});

</script>