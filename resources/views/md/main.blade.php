@extends('layout')

@section('head')
<script type="text/javascript">
function mActivos(){
	window.location="{{ URL::asset('md/mActivos')}}";
}	
function mAmenazas(){
	window.location="{{ URL::asset('md/mAmenazas')}}";
}	
function mDesacActivoAmenaza(){
	window.location="{{ URL::asset('md/mActAmen')}}";
}	
</script>
@stop
@section('submenu')
<p>
	<button type="button" class="btn btn-default" onclick="mActivos();">M. de Activos</button>
	<button type="button" class="btn btn-default" onclick="mAmenazas();">M. de Amenazas</button>
	<button type="button" class="btn btn-default" onclick="mDesacActivoAmenaza();">Desactivación Activo Amenazas</button>
	<button type="button" class="btn btn-default">M. de Controles</button>
	<button type="button" class="btn btn-default">M. de otras tablas</button>
</p>

@stop
