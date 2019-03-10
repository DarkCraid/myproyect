
@section ('header')  <!--se le debe de poner un identificador unico mediante section -->
<!DOCTYPE html>
<html ng-app="app">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE-edge">
	<title>Templates</title>
	<link rel="stylesheet" type="text/css" href="">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/estilos.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('css/bootstrap.3.3.7.min.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('datePicker/css/bootstrap-datepicker.min.css') }}">
</head>
<body>
 @show <!-- para mostrar lo de arriba-->