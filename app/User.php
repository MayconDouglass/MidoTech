<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'usuarios';
	protected $primaryKey = 'id_usuario';
	public $timestamps = false;

	protected $casts = [
		'empresa' => 'int',
		'perfil' => 'int',
		'licencas' => 'int',
		'ativo' => 'int',
		'usucad' => 'int'
	];

	protected $dates = [
		'data_cadastro',
		'data_alteracao'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'empresa',
		'perfil',
		'nome',
		'email',
		'password',
		'remember_token',
		'licencas',
		'ativo',
		'usucad',
		'data_cadastro',
		'data_alteracao'
	];

	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'usucad');
	}

	public function perfil_acessos()
	{
		return $this->hasMany(PerfilAcesso::class, 'usuario');
	}

	public function usuarios()
	{
		return $this->hasMany(Usuario::class, 'usucad');
	}
}
