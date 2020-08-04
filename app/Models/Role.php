<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * 
 * @property int $id_role
 * @property string $descricao
 * 
 * @property PerfilAcesso $perfil_acesso
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

	public function perfil_acesso()
	{
		return $this->hasOne(PerfilAcesso::class, 'role');
	}
}
