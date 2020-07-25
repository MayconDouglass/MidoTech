<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Regimetrib
 * 
 * @property int $id_regime
 * @property string $descricao
 * @property int $ativo
 * 
 * @property Collection|Setempresa[] $setempresas
 *
 * @package App\Models
 */
class Regimetrib extends Model
{
	protected $table = 'regimetrib';
	protected $primaryKey = 'id_regime';
	public $timestamps = false;

	protected $casts = [
		'ativo' => 'int'
	];

	protected $fillable = [
		'descricao',
		'ativo'
	];

	public function setempresas()
	{
		return $this->hasMany(Setempresa::class, 'regimetrib');
	}
}
