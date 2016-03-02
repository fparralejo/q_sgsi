<?php
//var_dump($listActivos);die;
?>


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
                { "sType": 'string' }
            ],                    
            "bJQueryUI":true,
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]]
        });
	} );

    function leerRiesgo(Id){
        $.ajax({
          data:{"Id":Id},  
          url: '{{ URL::asset("md/mActAmen/show") }}',
          type:"get",
          success: function(data) {
            var actAmen = JSON.parse(data);

            comprobarCheck(actAmen.Activado,Activado);
            $('#IdRiesgo').val(actAmen.IdRiesgo);
            $('#Activo').val(actAmen.Activo);
            $('#Amenaza').val(actAmen.Amenaza);
            //cambiar nombre del titulo del formulario
            $("#Id").val(actAmen.Id);
            $("#submitir").prop('disabled',false);
          }
        });
    }

    function comprobarCheck(amenaza,check){
        if(amenaza == "1"){
            $(check).prop('checked',true);
        }else{
            $(check).prop('checked',false);
        }
    }


</script>

<h3>Revisión manual aplicabilidad Amenazas</h3>

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
            <th>Activado</th>
            <th>IdRiesgo</th>
            <th>Activo</th>
            <th>Amenaza</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($listado as $actAmen)
        <?php
        //carga los datos en el formulario para editarlos
        $url="javascript:leerRiesgo('$actAmen->Id');";
        ?>
            <tr>
                <td class="sgsiRow" onClick="{{ $url }}">
                <?php if((string)$actAmen->Activado === "1"){ ?>
                    <input type="checkbox" name="activado{{ $actAmen->Id }}" 
                           id="activado{{ $actAmen->Id }}" checked disabled>
                <?php }else{ ?>
                    <input type="checkbox" name="activado{{ $actAmen->Id }}" 
                           id="activado{{ $actAmen->Id }}" disabled>
                <?php } ?>
                </td>
                <td class="sgsiRow" onClick="{{ $url }}">{{ $actAmen->IdRiesgo }}</td>
                <td class="sgsiRow" onClick="{{ $url }}">{{ $actAmen->Activo }}</td>
                <td class="sgsiRow" onClick="{{ $url }}">{{ $actAmen->Amenaza }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

<hr/>
<h3><span id="tituloForm">Editar Datos</span></h3>
<br/>

<style type="text/css">
#productForm .inputGroupContainer .form-control-feedback,
#productForm .selectContainer .form-control-feedback {
    top: 0;
    right: -15px;
}
</style>

<form role="form" class="form-horizontal" id="productForm" name="productForm" action="{{ URL::asset('md/mActAmen') }}" method="post">
    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="col-md-2">
          <div class="form-group">
            <label for="Activado">Activado:</label><br/>
            <input type="checkbox" name="Activado" id="Activado">
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <label for="IdRiesgo">IdRiesgo:</label><input type="text" class="form-control" id="IdRiesgo" name="IdRiesgo" maxlength="50">
          </div>
        </div>

        <div class="col-md-4">
            <label for="Activo">Activo:</label>
            <select class="form-control" name="Activo" id="Activo">
            @for($i=0;$i<count($listActivos);$i++)
                <option value="{{ $listActivos[$i]->Nombre }}">{{ $listActivos[$i]->Nombre }}</option>
            @endfor
            </select>
        </div>

        <div class="col-md-4">
            <label for="Amenaza">Amenaza:</label>
            <select class="form-control" name="Amenaza" id="Amenaza">
            @for($i=0;$i<count($listAmenazas);$i++)
                <option value="{{ $listAmenazas[$i]->Nombre }}">{{ $listAmenazas[$i]->Nombre }}</option>
            @endfor
            </select>
        </div>
    </div>


    <input type="hidden" id="Id" name="Id" value="" />
    <input type="submit" id="submitir" class="btn btn-default" value="OK" disabled/>
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
