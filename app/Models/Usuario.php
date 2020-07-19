<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Usuario
 * 
 * @property int $id_usuario
 * @property int $empresa
 * @property int $perfil_fk
 * @property string $nome
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property int $licencas
 * @property int $ativo
 * @property int|null $usucad
 * @property Carbon $data_cadastro
 * @property Carbon|null $data_alteracao
 * 
 * @property Usuario $usuario
 * @property Perfil $perfil
 * @property Setempresa $setempresa
 * @property Collection|Perfil[] $perfils
 * @property Collection|PerfilAcesso[] $perfil_acessos
 * @property Collection|Usuario[] $usuarios
 *
 * @package App\Models
 */
class Usuario extends Model
{
	protected $table = 'usuarios';
	protected $primaryKey = 'id_usuario';
	public $timestamps = false;

	protected $casts = [
		'empresa' => 'int',
		'perfil_fk' => 'int',
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
		'perfil_fk',
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

	public function perfil()
	{
		return $this->belongsTo(Perfil::class, 'perfil_fk');
	}

	public function setempresa()
	{
		return $this->belongsTo(Setempresa::class, 'empresa');
	}

	public function perfils()
	{
		return $this->hasMany(Perfil::class, 'usualt');
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
