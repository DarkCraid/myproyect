

@foreach($data[personas] as $persona)
	{{$persona->Nombre}}
	{{$persona->Apellido}}
	{{$persona->Dias}}
	{{$persona->Horario}}
	{{$persona->Edad}}

@endforeach
