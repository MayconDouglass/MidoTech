<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PerfilAcesso
 * 
 * @property int $id_acesso
 * @property int $perfil_cod
 * @property int $usuario
 * @property int $role
 * @property int $ativo
 * 
 * @property Perfil $perfil
 *
 * @package App\Models
 */
class PerfilAcesso extends Model
{
	protected $table = 'perfil_acesso';
	protected $primaryKey = 'id_acesso';
	public $timestamps = false;

	protected $casts = [
		'perfil_cod' => 'int',
		'usuario' => 'int',
		'role' => 'int',
		'ativo' => 'int'
	];

	protected $fillable = [
		'perfil_cod',
		'usuario',
		'role',
		'ativo'
	];

	public function perfil()
	{
		return $this->belongsTo(Perfil::class, 'perfil_cod');
	}

	public function role()
	{
		return $this->belongsTo(Role::class, 'role');
	}
}
