<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Telefone
 * 
 * @property int $id_telefone
 * @property int $tipo
 * @property string $numero
 * @property int $cli_cod
 * @property int $emp_cod
 *
 * @package App\Models
 */
class Telefone extends Model
{
	protected $table = 'telefones';
	protected $primaryKey = 'id_telefone';
	public $timestamps = false;

	protected $casts = [
		'tipo' => 'int',
		'cli_cod' => 'int',
		'emp_cod' => 'int'
	];

	protected $fillable = [
		'tipo',
		'numero',
		'cli_cod',
		'emp_cod'
	];
}
