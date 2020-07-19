<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Setatividade
 * 
 * @property int $id_atividade
 * @property string $descricao
 * @property int $ativo
 * 
 * @property Collection|Setempresa[] $setempresas
 *
 * @package App\Models
 */
class Setatividade extends Model
{
	protected $table = 'setatividades';
	protected $primaryKey = 'id_atividade';
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
		return $this->hasMany(Setempresa::class, 'atividade');
	}
}
