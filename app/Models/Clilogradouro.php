<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Clilogradouro
 * 
 * @property int $id_endereco
 * @property int $emp_cod
 * @property int $cli_cod
 * @property int $tipo
 * @property string $cep
 * @property string $endereco
 * @property string $numero
 * @property int $bairro
 * @property int $cidade
 * @property string $UF
 * @property int $Pais
 * @property string|null $referencia
 *
 * @package App\Models
 */
class Clilogradouro extends Model
{
	protected $table = 'clilogradouro';
	protected $primaryKey = 'id_endereco';
	public $timestamps = false;

	protected $casts = [
		'emp_cod' => 'int',
		'cli_cod' => 'int',
		'tipo' => 'int',
		'bairro' => 'int',
		'cidade' => 'int',
		'Pais' => 'int'
	];

	protected $fillable = [
		'emp_cod',
		'cli_cod',
		'tipo',
		'cep',
		'endereco',
		'numero',
		'bairro',
		'cidade',
		'UF',
		'Pais',
		'referencia'
	];
}
