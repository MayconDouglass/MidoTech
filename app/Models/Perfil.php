<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Perfil
 * 
 * @property int $id_perfil
 * @property int $emp_cod
 * @property string $nome
 * @property int $ativo
 * @property Carbon $datacad
 * @property Carbon|null $dataalt
 * @property int $usucad
 * @property int|null $usualt
 * 
 * @property Usuario $usuario
 * @property Setempresa $setempresa
 * @property Collection|PerfilAcesso[] $perfil_acessos
 * @property Collection|Usuario[] $usuarios
 *
 * @package App\Models
 */
class Perfil extends Model
{
	protected $table = 'perfil';
	protected $primaryKey = 'id_perfil';
	public $timestamps = false;

	protected $casts = [
		'emp_cod' => 'int',
		'ativo' => 'int',
		'usucad' => 'int',
		'usualt' => 'int'
	];

	protected $dates = [
		'datacad',
		'dataalt'
	];

	protected $fillable = [
		'emp_cod',
		'nome',
		'ativo',
		'datacad',
		'dataalt',
		'usucad',
		'usualt'
	];

	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'usucad');
	}

	public function setempresa()
	{
		return $this->belongsTo(Setempresa::class, 'emp_cod');
	}

	public function perfil_acessos()
	{
		return $this->hasMany(PerfilAcesso::class, 'perfil_cod');
	}

	public function usuarios()
	{
		return $this->hasMany(Usuario::class, 'perfil_fk');
	}
}
