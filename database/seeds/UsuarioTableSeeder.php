<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Usuario;

class UsuarioTableSeeder extends Seeder {

	public function run()
	{
		DB::table('usuarios')->delete();

		Usuario::create(array(
			"nombre"=>"Paco",
			"apellidos"=>"Parralejo",
			"email"=>"fparralejo1970@gmail.com",
			"direccion"=>"Calle Olimpiada 3, Alcorcón",
			"telefono"=>671108309,
			"rol"=>0,
			"password"=>'0000'
		));
	}

}