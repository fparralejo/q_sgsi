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
                { "sType": 'string' },
                { "sType": 'string' },
                { "sType": 'none' }
            ],                    
            "bJQueryUI":true,
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]]
        });
	} );

	function cambioCriterio(objeto,CriConf2){
		objeto.value = CriConf2.value;

	}

	function leerActivo(Id){
        $.ajax({
          data:{"Id":Id},  
          url: '{{ URL::asset("md/mActivos/show") }}',
          type:"get",
          success: function(data) {
            var activo = JSON.parse(data);
            $('#IdActivo').val(activo.IdActivo);
            $('#Nombre').val(activo.Nombre);
            $('#Referencia').val(activo.Referencia);
            $('#Unidades').val(activo.Unidades);
            $('#Marca').val(activo.Marca);
            $('#Modelo').val(activo.Modelo);
            $("#Localizacion").val(activo.Localizacion);
            $("#Descripcion").val(activo.Descripcion);
            $("#Observaciones").val(activo.Observaciones);
            $("#Categoria").val(activo.Categoria);
            $("#Tipo").val(activo.Tipo);
            $("#Propietario").val(activo.Propietario);
            $("#Padre").val(activo.Padre);
            $("#Confidencialidad").val(activo.Confidencialidad);
            $("#CriConf").val(activo.CriterioConfidencialidad);
            $("#CriConf2").val(activo.CriterioConfidencialidad);
            $("#Disponibilidad").val(activo.Disponibilidad);
            $("#CriDisp").val(activo.CriterioDisponibilidad);
            $("#CriDisp2").val(activo.CriterioDisponibilidad);
            $("#Integridad").val(activo.Integridad);
            $("#CriInt").val(activo.CriterioIntegridad);
            $("#CriInt2").val(activo.CriterioIntegridad);
            //cambiar nombre del titulo del formulario
            $("#tituloForm").html('Editar Datos');
            $("#submitir").val('OK');
            $("#Id").val(activo.Id);
          }
        });
	}

	function borrarActivo(Id){
        if (confirm("¿Desea borrar el activo?"))
        {
	        $.ajax({
	          data:{"Id":Id},  
	          url: '{{ URL::asset("md/mActivos/delete") }}',
	          type:"get",
	          success: function(data) {
	          	$('#accionTabla').html(data);
	          	$('#accionTabla').show();
	          }
	        });
	        setTimeout(function ()
	        {
	            document.location.href="{{URL::to('md/mActivos')}}";
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

<h3>M. de Activos</h3>

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
			<th>IdActivo</th>
			<th>Nombre</th>
			<th>Referencia</th>
			<th>Unidades</th>
			<th>Marca</th>
			<th>Modelo</th>
			<th>Localización</th>
			<th></th>
			</tr>
		</thead>
		<tbody>
		@foreach ($listado as $activo)
		<?php
		//carga los datos en el formulario para editarlos
        $url="javascript:leerActivo('$activo->Id');";
		?>
			<tr>
				<td class="sgsiRow" onClick="{{ $url }}">{{ $activo->IdActivo }}</td>
				<td class="sgsiRow" onClick="{{ $url }}">{{ $activo->Nombre }}</td>
				<td class="sgsiRow" onClick="{{ $url }}">{{ $activo->Referencia }}</td>
				<td class="sgsiRow" onClick="{{ $url }}">{{ $activo->Unidades }}</td>
				<td class="sgsiRow" onClick="{{ $url }}">{{ $activo->Marca }}</td>
				<td class="sgsiRow" onClick="{{ $url }}">{{ $activo->Modelo }}</td>
				<td class="sgsiRow" onClick="{{ $url }}">{{ $activo->Localizacion }}</td>
				<td>
					<button type="button" onclick="borrarActivo({{$activo->Id}})" class="btn btn-xs btn-danger">Borrar</button>
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

<form role="form" class="form-horizontal" id="productForm" name="productForm" action="{{ URL::asset('md/mActivos') }}" method="post">
    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="row">
		<div class="col-md-2">
		  <div class="form-group">
		    <label for="IdActivo">IdActivo:</label><input type="text" class="form-control" id="IdActivo" name="IdActivo" maxlength="3">
		  </div>
	    </div>
    </div>

	<div class="row">
		<div class="col-md-8">
		  <div class="form-group">
		    <label for="Nombre">Nombre:</label><input type="text" class="form-control" id="Nombre" name="Nombre" maxlength="255">
		  </div>
	    </div>
    </div>

	<div class="row">
		<div class="col-md-4">
		  <div class="form-group">
		    <label for="Referencia">Referencia:</label><input type="text" class="form-control" id="Referencia" name="Referencia" maxlength="50">
		  </div>
	    </div>
    </div>

	<div class="row">
		<div class="col-md-2">
		  <div class="form-group">
		    <label for="Unidades">Unidades:</label><input type="text" class="form-control" id="Unidades" name="Unidades" maxlength="11">
		  </div>
	    </div>
    </div>

	<div class="row">
		<div class="col-md-4">
		  <div class="form-group">
		    <label for="Marca">Marca:</label><input type="text" class="form-control" id="Marca" name="Marca" maxlength="50">
		  </div>
	    </div>
    </div>

	<div class="row">
		<div class="col-md-4">
		  <div class="form-group">
		    <label for="Modelo">Modelo:</label><input type="text" class="form-control" id="Modelo" name="Modelo" maxlength="50">
		  </div>
	    </div>
    </div>

	<div class="row">
		<div class="col-md-4">
			<label for="Localización">Localización</label>
	        <select class="form-control" id="Localizacion" name="Localizacion">
	        @foreach ($listLocalizacion as $localizacion)
		        <option value="{{ $localizacion->IdLocalizacion }}">{{ $localizacion->Localizacion }}</option>
	        @endforeach
	        </select>
	    </div>
    </div>
    <br/>

	<div class="row">
		<div class="col-md-6">
		  <div class="form-group">
		    <label for="Descripcion">Descripcion:</label>
		    <textarea class="form-control" rows="2" name="Descripcion" id="Descripcion"></textarea>
		  </div>
	    </div>
    </div>

	<div class="row">
		<div class="col-md-6">
		  <div class="form-group">
		    <label for="Observaciones">Observaciones:</label>
		    <textarea class="form-control" rows="2" name="Observaciones" id="Observaciones"></textarea>
		  </div>
	    </div>
    </div>

	<div class="row">
		<div class="col-md-4 jumbotron">
			<label for="Categoria">Categoría:</label>
	        <select class="form-control" name="Categoria" id="Categoria">
	        @foreach ($listCategorias as $categoria)
		        <option value="{{ $categoria->IdCategoria }}">{{ $categoria->Categoria }}</option>
	        @endforeach
	        </select>
	        <br/>
			<label for="Departamento">Departamento:</label>
	        <select class="form-control" name="Departamento" id="Departamento">
	        @foreach ($listDepartamentos as $departamento)
		        <option value="{{ $departamento->IdDepartamento }}">{{ $departamento->Departamento }}</option>
	        @endforeach
	        </select>
	        <br/>
			<label for="Tipo">Tipo:</label>
	        <select class="form-control" name="Tipo" id="Tipo">
	        @foreach ($listTipo as $tipo)
		        <option value="{{ $tipo->IdTipo }}">{{ $tipo->Tipo }}</option>
	        @endforeach
	        </select>
	        <br/>
	        <br/>
			<label for="Propietario">Propietario:</label>
	        <select class="form-control" name="Propietario" id="Propietario">
	        @foreach ($listPropietarios as $propietario)
		        <option value="{{ $propietario->IdPropietario }}">{{ $propietario->Propietario }}</option>
	        @endforeach
	        </select>
	        <br/>
			<label for="Padre">Padre:</label>
	        <select class="form-control" name="Padre" id="Padre">
	        @foreach ($listPadre as $padre)
		        <option value="{{ $padre->IdPadre }}">{{ $padre->Padre }}</option>
	        @endforeach
	        </select>
	    </div>

		<div class="col-md-2"></div>


		<div class="col-md-6 jumbotron">
			<label for="Confidencialidad">Confidencialidad:</label>
	        <select class="form-control" name="Confidencialidad" id="Confidencialidad">
	        @foreach ($listConfidencialidad as $confidencialidad)
		        <option value="{{ $confidencialidad->IdConfidencialidad }}">{{ $confidencialidad->Descripcion }}</option>
	        @endforeach
	        </select>
	        <br/>
			<div class="col-md-2">
		   	    <div class="form-group">
				    <label for="CriConf">Criterio:</label>
				    <input type="text" class="form-control" 
							id="CriConf" name="CriConf" value="00" readonly>
				</div>
			</div>

	        <br/>
			<label for="CriConf2"></label>
	        <select class="form-control" id="CriConf2" name="CriConf2" onchange="cambioCriterio(document.productForm.CriConf,this);">
	        @foreach ($listCriterio as $criterio)
		        <option value="{{ $criterio->IdCriterio }}">{{ $criterio->Descripcion }} - {{ $criterio->Codigo }}</option>
	        @endforeach
	        </select>
	    </div>

		<div class="col-md-2"></div>

		<div class="col-md-6 jumbotron">
			<label for="Disponibilidad">Disponibilidad:</label>
	        <select class="form-control" name="Disponibilidad" id="Disponibilidad">
	        @foreach ($listDisponibilidad as $disponibilidad)
		        <option value="{{ $disponibilidad->IdDisponibilidad }}">{{ $disponibilidad->Descripcion }}</option>
	        @endforeach
	        </select>
	        <br/>
			<div class="col-md-2">
		   	    <div class="form-group">
				    <label for="CriDisp">Criterio:</label>
				    <input type="text" class="form-control" 
							id="CriDisp" name="CriDisp" value="00" readonly>
				</div>
			</div>

	        <br/>
			<label for="CriDisp2"></label>
	        <select class="form-control" id="CriDisp2" name="CriDisp2" onchange="cambioCriterio(document.productForm.CriDisp,this);">
	        @foreach ($listCriterio as $criterio)
		        <option value="{{ $criterio->IdCriterio }}">{{ $criterio->Descripcion }} - {{ $criterio->Codigo }}</option>
	        @endforeach
	        </select>
	    </div>

		<div class="col-md-6"></div>

		<div class="col-md-6 jumbotron">
			<label for="Integridad">Integridad:</label>
	        <select class="form-control" name="Integridad" id="Integridad">
	        @foreach ($listIntegridad as $integridad)
		        <option value="{{ $integridad->IdIntegridad }}">{{ $integridad->Descripcion }}</option>
	        @endforeach
	        </select>
	        <br/>
			<div class="col-md-2">
		   	    <div class="form-group">
				    <label for="CriInt">Criterio:</label>
				    <input type="text" class="form-control" 
							id="CriInt" name="CriInt" value="00" readonly>
				</div>
			</div>

	        <br/>
			<label for="CriDisp2"></label>
	        <select class="form-control" id="CriInt2" name="CriInt2" onchange="cambioCriterio(document.productForm.CriInt,this);">
	        @foreach ($listCriterio as $criterio)
		        <option value="{{ $criterio->IdCriterio }}">{{ $criterio->Descripcion }} - {{ $criterio->Codigo }}</option>
	        @endforeach
	        </select>
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
            IdActivo: {
                validators: {
                    notEmpty: {
                        message: 'El IdActivo es requerido'
                    },
                    numeric: {
                        message: 'El IdActivo tiene que ser un valor numérico'
                    }
                }
            },
            Nombre: {
                validators: {
                    notEmpty: {
                        message: 'El Nombre es requerido'
                    }
                }
            },
            Unidades: {
                validators: {
                    notEmpty: {
                        message: 'Las Unidades es requerida'
                    },
                    integer: {
                        message: 'Las Unidades tiene que ser un valor numérico'
                    }
                }
            }
        }
    });
});
</script>

@stop

