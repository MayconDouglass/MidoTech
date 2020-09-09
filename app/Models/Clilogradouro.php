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
 * @property string|null $complemento
 * @property string $numero
 * @property string $bairro
 * @property string $cidade
 * @property string|null $IBGE
 * @property string $UF
 * @property string|null $referencia
 * 
 * @property Cliente $cliente
 * @property Setempresa $setempresa
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
		'tipo' => 'int'
	];

	protected $fillable = [
		'emp_cod',
		'cli_cod',
		'tipo',
		'cep',
		'endereco',
		'complemento',
		'numero',
		'bairro',
		'cidade',
		'IBGE',
		'UF',
		'referencia'
	];

	public function cliente()
	{
		return $this->belongsTo(Cliente::class, 'cli_cod');
	}

	public function setempresa()
	{
		return $this->belongsTo(Setempresa::class, 'emp_cod');
	}
}
