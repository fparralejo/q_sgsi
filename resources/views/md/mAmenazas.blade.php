@extends('md.main')


@section('principal')
<style>
    .sgsiRow:hover{
        cursor: pointer;
    }

</style>
<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
        $('#ejemplo1').dataTable({
        	"responsive": true,
            "bProcessing": true,
            "sPaginationType":"full_numbers",
            "oLanguage": {
                "sLengthMenu": "Ver _MENU_ registros por pagina",
                "sZeroRecords": "No se han encontrado registros",
                "sInfo": "Ver _START_ al _END_ de _TOTAL_ Registros",
                "sInfoEmpty": "Ver 0 al 0 de 0 registros",
                "sInfoFiltered": "(filtrados _MAX_ total registros)",
                "sSearch": "Busqueda:"
            },
            "bSort":true,
            "aaSorting": [[ 0, "asc" ]],
            "aoColumns": [
                { "sType": 'string' },
                { "sType": 'string' },
                { "sType": 'string' },
                { "sType": 'string' },
                { "sType": 'string' },
                { "sType": 'none' }
            ],                    
            "bJQueryUI":true,
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]]
        });
	} );

    function leerAmenaza(Id){
        $.ajax({
          data:{"Id":Id},  
          url: '{{ URL::asset("md/mAmenazas/show") }}',
          type:"get",
          success: function(data) {
            var amenaza = JSON.parse(data);
            $('#IdAmenaza').val(amenaza.IdAmenaza);
            $('#Nombre').val(amenaza.Nombre);
            $('#Categoria').val(amenaza.Categoria);
            $('#Degradacion').val(amenaza.Degradacion);
            $('#Frecuencia').val(amenaza.Frecuencia);
            $('#Descripcion').val(amenaza.Descripcion);

            comprobarCheck(amenaza.D,D);
            comprobarCheck(amenaza.S,S);
            comprobarCheck(amenaza.SW,SW);
            comprobarCheck(amenaza.HW,HW);
            comprobarCheck(amenaza.COM,COM);
            comprobarCheck(amenaza.SI,SI);
            comprobarCheck(amenaza.AUX,AUX);
            comprobarCheck(amenaza.L,L);
            comprobarCheck(amenaza.P,P);

            //cambiar nombre del titulo del formulario
            $("#tituloForm").html('Editar Datos');
            $("#submitir").val('OK');
            $("#Id").val(amenaza.Id);
          }
        });
    }

    function comprobarCheck(amenaza,check){
        if(amenaza === "1"){
            $(check).prop('checked',true);
        }else{
            $(check).prop('checked',false);
        }
    }

    function borrarAmenaza(Id){
        if (confirm("¿Desea borrar la amenaza?"))
        {
            $.ajax({
              data:{"Id":Id},  
              url: '{{ URL::asset("md/mAmenazas/delete") }}',
              type:"get",
              success: function(data) {
                $('#accionTabla').html(data);
                $('#accionTabla').show();
              }
            });
            setTimeout(function ()
            {
                document.location.href="{{URL::to('md/mAmenazas')}}";
            }, 1000);
        }
    }

    //hacer desaparecer en cartel
    $(document).ready(function() {
        setTimeout(function() {
            $("#accionTabla2").fadeOut(1500);
        },3000);
    }); 
</script>

<h3>M. de Amenazas</h3>

<!-- aviso de alguna accion -->
<div class="alert alert-success" role="alert" id="accionTabla" style="display: none; ">
</div>

@if (Session::has('errors'))
<div class="alert alert-success" id="accionTabla2" role="alert" style="display: block; ">
{{ $errors }}
</div>
@endif


<table id="ejemplo1" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>IdAmenaza</th>
			<th>Nombre</th>
			<th>Categoria</th>
			<th>Degradación</th>
			<th>Frecuencia</th>
			<th></th>
			</tr>
		</thead>
		<tbody>
		@foreach ($listado as $amenaza)
		<?php
		//carga los datos en el formulario para editarlos
        $url="javascript:leerAmenaza('$amenaza->Id');";
		?>
			<tr>
				<td class="sgsiRow" onClick="{{ $url }}">{{ $amenaza->IdAmenaza }}</td>
				<td class="sgsiRow" onClick="{{ $url }}">{{ $amenaza->Nombre }}</td>
				<td class="sgsiRow" onClick="{{ $url }}">{{ $amenaza->Categoria }}</td>
				<td class="sgsiRow" onClick="{{ $url }}">{{ $amenaza->Degradacion }}</td>
				<td class="sgsiRow" onClick="{{ $url }}">{{ $amenaza->Frecuencia }}</td>
				<td>
					<button type="button" onclick="borrarAmenaza({{$amenaza->Id}})" class="btn btn-xs btn-danger">Borrar</button>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>

<hr/>
<h3><span id="tituloForm">Nuevos Datos</span></h3>
<br/>

<style type="text/css">
#productForm .inputGroupContainer .form-control-feedback,
#productForm .selectContainer .form-control-feedback {
    top: 0;
    right: -15px;
}
</style>

<form role="form" class="form-horizontal" id="productForm" name="productForm" action="{{ URL::asset('md/mAmenazas') }}" method="post">
    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="row">
		<div class="col-md-2">
		  <div class="form-group">
		    <label for="IdAmenaza">IdAmenaza:</label><input type="text" class="form-control" id="IdAmenaza" name="IdAmenaza" maxlength="3">
		  </div>
	    </div>
    </div>

	<div class="row">
		<div class="col-md-6">
		  <div class="form-group">
		    <label for="Nombre">Nombre:</label><input type="text" class="form-control" id="Nombre" name="Nombre" maxlength="255">
		  </div>
	    </div>
    </div>

	<div class="row">
		<div class="col-md-6">
			<label for="Categoria">Categoria</label>
	        <select class="form-control" id="Categoria" name="Categoria">
	        @foreach ($listCatAmenaza as $categoria)
		        <option value="{{ $categoria->IdCatAmenaza }}">{{ $categoria->Nombre }}</option>
	        @endforeach
	        </select>
	    </div>
    </div>
    <br/>
    
    <div class="row">
        <div class="col-md-6">
            <label for="Degradacion">Degradacion</label>
            <select class="form-control" id="Degradacion" name="Degradacion">
            @foreach ($listDegradacion as $degradacion)
                <option value="{{ $degradacion->IdDegradacion }}">{{ $degradacion->ValorDegradacion }} - {{ $degradacion->Descripcion }}</option>
            @endforeach
            </select>
        </div>
    </div>
    <br/>

    <div class="row">
        <div class="col-md-6">
            <label for="Frecuencia">Frecuencia</label>
            <select class="form-control" id="Frecuencia" name="Frecuencia">
            @foreach ($listFrecuencia as $frecuencia)
                <option value="{{ $frecuencia->IdFrecuencia }}">{{ $frecuencia->Frecuencia }} - {{ $frecuencia->DescripcionLarga }}</option>
            @endforeach
            </select>
        </div>
    </div>
    <br/>
    <br/>

    <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="Descripcion">Descripción:</label>
            <textarea class="form-control" rows="2" name="Descripcion" id="Descripcion"></textarea>
          </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-1 jumbotron">
            <div  class="checkbox-inline">
               <label><input type="checkbox" name="D" id="D">D</label>
            </div>
        </div>
        <div class="col-md-1 jumbotron">
            <div  class="checkbox-inline">
               <label><input type="checkbox" name="S" id="S">S</label>
            </div>
        </div>
        <div class="col-md-1 jumbotron">
            <div  class="checkbox-inline">
               <label><input type="checkbox" name="SW" id="SW">SW</label>
            </div>
        </div>
        <div class="col-md-1 jumbotron">
            <div  class="checkbox-inline">
               <label><input type="checkbox" name="HW" id="HW">HW</label>
            </div>
        </div>
        <div class="col-md-1 jumbotron">
            <div  class="checkbox-inline">
               <label><input type="checkbox" name="COM" id="COM">COM</label>
            </div>
        </div>
        <div class="col-md-1 jumbotron">
            <div  class="checkbox-inline">
               <label><input type="checkbox" name="SI" id="SI">SI</label>
            </div>
        </div>
        <div class="col-md-1 jumbotron">
            <div  class="checkbox-inline">
               <label><input type="checkbox" name="AUX" id="AUX">AUX</label>
            </div>
        </div>
        <div class="col-md-1 jumbotron">
            <div  class="checkbox-inline">
               <label><input type="checkbox" name="L" id="L">L</label>
            </div>
        </div>
        <div class="col-md-1 jumbotron">
            <div  class="checkbox-inline">
               <label><input type="checkbox" name="P" id="P">P</label>
            </div>
        </div>
    </div>


    <input type="hidden" id="Id" name="Id" value="" />
    <input type="submit" id="submitir" class="btn btn-default" value="Nuevo"/>
</form>




<script>
$(document).ready(function() {
    $('#productForm').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            IdAmenaza: {
                validators: {
                    notEmpty: {
                        message: 'El IdAmenaza es requerido'
                    },
                    numeric: {
                        message: 'El IdAmenaza tiene que ser un valor numérico'
                    }
                }
            },
            Nombre: {
                validators: {
                    notEmpty: {
                        message: 'El Nombre es requerido'
                    }
                }
            }
        }
    });
});
</script>

@stop

