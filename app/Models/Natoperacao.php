<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Natoperacao
 * 
 * @property int $id_natoperacao
 * @property string $descricao
 * @property int $classificacao
 * @property int $dre
 * @property int $fluxo
 * @property int $ativo
 * 
 * @property Collection|Modocobranca[] $modocobrancas
 *
 * @package App\Models
 */
class Natoperacao extends Model
{
	protected $table = 'natoperacao';
	protected $primaryKey = 'id_natoperacao';
	public $timestamps = false;

	protected $casts = [
		'classificacao' => 'int',
		'dre' => 'int',
		'fluxo' => 'int',
		'ativo' => 'int'
	];

	protected $fillable = [
		'descricao',
		'classificacao',
		'dre',
		'fluxo',
		'ativo'
	];

	public function modocobrancas()
	{
		return $this->hasMany(Modocobranca::class, 'natureza');
	}
}
