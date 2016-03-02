<?php namespace App\Http\Controllers;

use Session;
use Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Controllers\loginController;

use App\tbActivos;
use App\tbLocalizacion;
use App\tbCategorias;
use App\tbDepartamentos;
use App\tbTipo;
use App\tbPropietarios;
use App\tbPadre;
use App\tbConfidencialidad;
use App\tbDisponibilidad;
use App\tbIntegridad;
use App\tbAmenazas;
use App\tbCategoriaAmenazas;
use App\tbDegradacion;
use App\tbFrecuencia;
use App\tbNivelRiesgoInicial;


use Illuminate\Http\Request;

class mantenimientosController extends Controller {

	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


	public function main()
	{
        //control de sesion
		$login = new loginController();
        if (!$login->getControl()) {
        	return redirect('/')->with('login_errors', '<font color="#ff0000">La sesión a expirado. Vuelva a logearse..</font>');
        }

		return view('md.main'); 
	}

	public function mActivos()
	{
        //control de sesion
		$login = new loginController();
        if (!$login->getControl()) {
        	return redirect('/')->with('login_errors', '<font color="#ff0000">La sesión a expirado. Vuelva a logearse..</font>');
        }

		$listado = tbActivos::all();
		$listLocalizacion = tbLocalizacion::all();
		$listCategorias = tbCategorias::all();
		$listDepartamentos = tbDepartamentos::all();
		$listTipo = tbTipo::all();
		$listPropietarios = tbPropietarios::all();
		$listPadre = tbPadre::all();
		$listConfidencialidad = tbConfidencialidad::all();
		$listDisponibilidad = tbDisponibilidad::all();
		$listIntegridad = tbIntegridad::all();

		$listCriConf = \DB::select("SELECT CR.IdCriterio FROM tbcodigo C INNER JOIN tbcriterios CR ON C.IdCodigo=CR.Codigo");
		$listCriterio = \DB::select("SELECT CR.IdCriterio, CR.Descripcion, C.Codigo FROM tbcodigo C INNER JOIN tbcriterios CR ON C.IdCodigo=CR.Codigo");
		return view('md.mActivos')->with('listado',$listado)->with('listLocalizacion',$listLocalizacion)
								  ->with('listCategorias',$listCategorias)->with('listDepartamentos',$listDepartamentos)
								  ->with('listTipo',$listTipo)->with('listPropietarios',$listPropietarios)
								  ->with('listPadre',$listPadre)->with('listConfidencialidad',$listConfidencialidad)
								  ->with('listCriConf',$listCriConf)->with('listCriterio',$listCriterio)
								  ->with('listDisponibilidad',$listDisponibilidad)->with('listIntegridad',$listIntegridad); 
	}

	public function mActivosShow(){
		$activo = tbActivos::find(Input::get('Id'));

		//devuelvo la respuesta al send
		echo json_encode($activo);
	}

	public function mActivosDelete(){
		$activo = tbActivos::find(Input::get('Id'));
		$IdActivo = $activo->IdActivo;

		$activo->delete();

		//devuelvo la respuesta al send
		echo "Activo ". $IdActivo ." borrado correctamente.";
	}

	public function mActivosCreateEdit(Request $request){
		//si es nuevo este valor viene vacio
		if($request->Id === ""){
			$activo = new tbActivos();
			$ok = 'Se ha dado de alta correctamente el activo.';
			$error = 'ERROR al dar de alta el activo.';
		}
		//sino se edita este Id
		else{
			$activo = tbActivos::find($request->Id);
			$ok = 'Se ha editado correctamente el activo.';
			$error = 'ERROR al edtar el activo.';
		}

		$activo->IdActivo = $request->IdActivo;
		$activo->Categoria = $request->Categoria;
		$activo->Departamento = $request->Departamento;
		$activo->Confidencialidad = $request->Confidencialidad;
		$activo->CriterioConfidencialidad = $request->CriConf;
		$activo->Disponibilidad = $request->Disponibilidad;
		$activo->CriterioDisponibilidad = $request->CriDisp;
		$activo->Integridad = $request->Integridad;
		$activo->CriterioIntegridad = $request->CriInt;
		$activo->Referencia = $request->Referencia;
		$activo->Unidades = $request->Unidades;
		$activo->Nombre = $request->Nombre;
		$activo->Marca = $request->Marca;
		$activo->Modelo = $request->Modelo;
		$activo->Tipo = $request->Tipo;
		$activo->Localizacion = $request->Localizacion;
		$activo->Propietario = $request->Propietario;
		$activo->Padre = $request->Padre;
		$activo->Descripcion = $request->Descripcion;
		$activo->Observaciones = $request->Observaciones;

		if($activo->save()){
			return redirect('md/mActivos')->with('errors', $ok);
		}else{
			return redirect('md/mActivos')->with('errors', $error);
		}
	}

	public function mAmenazas()
	{
        //control de sesion
		$login = new loginController();
        if (!$login->getControl()) {
        	return redirect('/')->with('login_errors', '<font color="#ff0000">La sesión a expirado. Vuelva a logearse..</font>');
        }
        
		$listado = tbAmenazas::all();
		$listCatAmenaza = tbCategoriaAmenazas::all();
		$listDegradacion = tbDegradacion::all();
		$listFrecuencia = tbFrecuencia::all();
		return view('md.mAmenazas')->with('listado',$listado)->with('listCatAmenaza',$listCatAmenaza)
								   ->with('listDegradacion',$listDegradacion)->with('listFrecuencia',$listFrecuencia); 
	}


	public function mAmenazasShow(){
		$amenaza = tbAmenazas::find(Input::get('Id'));

		//devuelvo la respuesta al send
		echo json_encode($amenaza);
	}

	public function mAmenazasCreateEdit(Request $request){
		//si es nuevo este valor viene vacio
		if($request->Id === ""){
			$amenaza = new tbAmenazas();
			$ok = 'Se ha dado de alta correctamente la amenaza.';
			$error = 'ERROR al dar de alta la amenaza.';
		}
		//sino se edita este Id
		else{
			$amenaza = tbAmenazas::find($request->Id);
			$ok = 'Se ha editado correctamente la amenaza.';
			$error = 'ERROR al edtar la amenaza.';
		}

		$amenaza->IdAmenaza = $request->IdAmenaza;
		$amenaza->Nombre = $request->Nombre;
		$amenaza->Categoria = $request->Categoria;
		$amenaza->Degradacion = $request->Degradacion;
		$amenaza->Frecuencia = $request->Frecuencia;
		$amenaza->Descripcion = $request->Descripcion;
		if($request->D === 'on'){
			$amenaza->D = 1;
		}else{
			$amenaza->D = 0;
		}
		if($request->S === 'on'){
			$amenaza->S = 1;
		}else{
			$amenaza->S = 0;
		}
		if($request->SW === 'on'){
			$amenaza->SW = 1;
		}else{
			$amenaza->SW = 0;
		}
		if($request->HW === 'on'){
			$amenaza->HW = 1;
		}else{
			$amenaza->HW = 0;
		}
		if($request->COM === 'on'){
			$amenaza->COM = 1;
		}else{
			$amenaza->COM = 0;
		}
		if($request->SI === 'on'){
			$amenaza->SI = 1;
		}else{
			$amenaza->SI = 0;
		}
		if($request->AUX === 'on'){
			$amenaza->AUX = 1;
		}else{
			$amenaza->AUX = 0;
		}
		if($request->L === 'on'){
			$amenaza->L = 1;
		}else{
			$amenaza->L = 0;
		}
		if($request->P === 'on'){
			$amenaza->P = 1;
		}else{
			$amenaza->P = 0;
		}

		if($amenaza->save()){
			return redirect('md/mAmenazas')->with('errors', $ok);
		}else{
			return redirect('md/mAmenazas')->with('errors', $error);
		}
	}

	public function mAmenazasDelete(){
		$amenaza = tbAmenazas::find(Input::get('Id'));
		$IdAmenaza = $amenaza->IdAmenaza;

		$amenaza->delete();

		//devuelvo la respuesta al send
		echo "Amenaza ". $IdAmenaza ." borrada correctamente.";
	}


	public function mActAmen(){
        //control de sesion
		$login = new loginController();
        if (!$login->getControl()) {
        	return redirect('/')->with('login_errors', '<font color="#ff0000">La sesión a expirado. Vuelva a logearse..</font>');
        }

        $listado = tbNivelRiesgoInicial::all();
		$listActivos = \DB::select("SELECT DISTINCT A.Nombre FROM tbactivos A");
		$listAmenazas = \DB::select("SELECT DISTINCT A.Nombre FROM tbamenazas A");
		return view('md.mActAmen')->with('listado',$listado)->with('listActivos',$listActivos)
								  ->with('listAmenazas',$listAmenazas); 
	}

	public function mActAmenShow(){
		$amenaza = tbNivelRiesgoInicial::find(Input::get('Id'));

		//devuelvo la respuesta al send
		echo json_encode($amenaza);
	}

	
}
