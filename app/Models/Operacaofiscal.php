<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Operacaofiscal
 * 
 * @property int $id_operacao
 * @property string $tipo
 * @property int $cfop
 * @property string $descricao
 * @property int $ativo
 *
 * @package App\Models
 */
class Operacaofiscal extends Model
{
	protected $table = 'operacaofiscal';
	protected $primaryKey = 'id_operacao';
	public $timestamps = false;

	protected $casts = [
		'cfop' => 'int',
		'ativo' => 'int'
	];

	protected $fillable = [
		'tipo',
		'cfop',
		'descricao',
		'ativo'
	];
}
