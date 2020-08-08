<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * 
 * @property int $id_role
 * @property string $descricao
 * 
 * @property Collection|PerfilAcesso[] $perfil_acessos
 *
 * @package App\Models
 */
class Role extends Model
{
	protected $table = 'roles';
	protected $primaryKey = 'id_role';
	public $timestamps = false;

	protected $fillable = [
		'descricao'
	];

	public function perfil_acessos()
	{
		return $this->hasMany(PerfilAcesso::class, 'role');
	}
}
