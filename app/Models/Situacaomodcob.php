<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Situacaomodcob
 * 
 * @property int $id_situacao
 * @property string $descricao
 * 
 * @property Collection|Modocobranca[] $modocobrancas
 *
 * @package App\Models
 */
class Situacaomodcob extends Model
{
	protected $table = 'situacaomodcob';
	protected $primaryKey = 'id_situacao';
	public $timestamps = false;

	protected $fillable = [
		'descricao'
	];

	public function modocobrancas()
	{
		return $this->hasMany(Modocobranca::class, 'situacao');
	}
}
