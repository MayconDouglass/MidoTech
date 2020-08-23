<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Setunidade
 * 
 * @property int $id_unidade
 * @property string $descricao
 * @property int $ativo
 *
 * @package App\Models
 */
class Setunidade extends Model
{
	protected $table = 'setunidades';
	protected $primaryKey = 'id_unidade';
	public $timestamps = false;

	protected $casts = [
		'ativo' => 'int'
	];

	protected $fillable = [
		'descricao',
		'ativo'
	];
}
