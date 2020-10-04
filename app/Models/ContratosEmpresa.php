<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ContratosEmpresa
 * 
 * @property int $id_con_emp
 * @property int $emp_cod
 * @property int $contrato
 * 
 * @property Setempresa $setempresa
 *
 * @package App\Models
 */
class ContratosEmpresa extends Model
{
	protected $table = 'contratos_empresa';
	protected $primaryKey = 'id_con_emp';
	public $timestamps = false;

	protected $casts = [
		'emp_cod' => 'int',
		'contrato' => 'int'
	];

	protected $fillable = [
		'emp_cod',
		'contrato'
	];

	public function setempresa()
	{
		return $this->belongsTo(Setempresa::class, 'emp_cod');
	}

	public function contrato()
	{
		return $this->belongsTo(Contrato::class, 'contrato');
	}
}
