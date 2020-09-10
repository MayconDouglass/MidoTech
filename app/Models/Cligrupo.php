<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cligrupo
 * 
 * @property int $id_grupo
 * @property string $descricao
 * @property int $ativo
 *
 * @package App\Models
 */
class Cligrupo extends Model
{
	protected $table = 'cligrupo';
	protected $primaryKey = 'id_grupo';
	public $timestamps = false;

	protected $casts = [
		'ativo' => 'int'
	];

	protected $fillable = [
		'descricao',
		'ativo'
	];
}
