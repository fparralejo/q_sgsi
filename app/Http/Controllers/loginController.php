<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use App\Usuario;

use Illuminate\Http\Request;

class loginController extends Controller {

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


	public function main(){
        //control de sesion
        if (!$this->getControl()) {
            return redirect('/')->with('login_errors', '<font color="#ff0000">La sesión a expirado. Vuelva a logearse.</font>');
        }

        return view('main');
	}

    public function login(Request $request) {

        //busco en la tabla de claves si existe
        $encontrado = Usuario::where('email', '=', $request->email)
                ->where('password', '=', $request->password)
                ->get();

        if (count($encontrado) > 0) {
            //guardo las vbles de sesion para navegar por la app
            Session::put('id', $encontrado[0]->id);
            Session::put('nombre', $encontrado[0]->nombre);
            Session::put('apellidos', $encontrado[0]->apellidos);
            Session::put('rol', $encontrado[0]->rol);


            return redirect('main');
        } else {
            return redirect('/')->with('login_errors', '<font color="#ff0000">Email o contraseña incorrectas.</font>');
        }
    }

    public function logout() {
        Session::flush();
        return redirect('/');
    }

    public function getControl() {
        //controlamos si estaamos en sesion por las distintas paginas de la app
        //controlamos las vbles sesion 'nombre', 'apellidos' y 'rol'
        if (Session::has('nombre') && Session::has('apellidos') && Session::has('rol')) {
            //chequeamos que estos valores del usuario existan en la tabla 'usuarios'
            $existe = Usuario::where('nombre', '=', Session::get('nombre'))
                    ->where('apellidos', '=', Session::get('apellidos'))
                    ->where('rol', '=', Session::get('rol'))
                    ->get();

            //si existe el contador es mayor que 0
            if (count($existe) > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}
