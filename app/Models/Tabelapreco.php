<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tabelapreco
 * 
 * @property int $id_tabela
 * @property int $emp_cod
 * @property string $descricao
 * @property int $prevenda
 * @property int $pedidoweb
 * @property int $ativo
 * 
 * @property Setempresa $setempresa
 *
 * @package App\Models
 */
class Tabelapreco extends Model
{
	protected $table = 'tabelapreco';
	protected $primaryKey = 'id_tabela';
	public $timestamps = false;

	protected $casts = [
		'emp_cod' => 'int',
		'prevenda' => 'int',
		'pedidoweb' => 'int',
		'ativo' => 'int'
	];

	protected $fillable = [
		'emp_cod',
		'descricao',
		'prevenda',
		'pedidoweb',
		'ativo'
	];

	public function setempresa()
	{
		return $this->belongsTo(Setempresa::class, 'emp_cod');
	}
}
