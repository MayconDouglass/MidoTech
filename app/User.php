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
		'perfil_fk' => 'int',
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
		'perfil_fk',
		'nome',
		'email',
		'password',
		'remember_token',
		'ativo',
		'usucad',
		'data_cadastro',
		'data_alteracao'
	];

	public function usuario()
	{
		return $this->belongsTo(\App\Models\Usuario::class, 'usucad');
	}

	public function perfil()
	{
		return $this->belongsTo(\App\Models\Perfil::class, 'perfil_fk');
	}

	public function setempresa()
	{
		return $this->belongsTo(\App\Models\Setempresa::class, 'empresa');
	}

	public function perfils()
	{
		return $this->hasMany(\App\Models\Perfil::class, 'usualt');
	}

	public function perfil_acessos()
	{
		return $this->hasMany(\App\Models\PerfilAcesso::class, 'usuario');
	}

	public function usuarios()
	{
		return $this->hasMany(\App\Models\Usuario::class, 'usucad');
	}
}
