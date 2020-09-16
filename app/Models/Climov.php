<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Climov
 * 
 * @property int $id_mov
 * @property int $emp_cod
 * @property int $cli_cod
 * @property string $num_doc
 * @property string $serie_doc
 * @property float $valor_brut
 * @property float $valor_liq
 * @property Carbon $data_mov
 * @property int $tipo
 * @property int $status
 * 
 * @property Cliente $cliente
 * @property Setempresa $setempresa
 *
 * @package App\Models
 */
class Climov extends Model
{
	protected $table = 'climov';
	protected $primaryKey = 'id_mov';
	public $timestamps = false;

	protected $casts = [
		'emp_cod' => 'int',
		'cli_cod' => 'int',
		'valor_brut' => 'float',
		'valor_liq' => 'float',
		'tipo' => 'int',
		'status' => 'int'
	];

	protected $dates = [
		'data_mov'
	];

	protected $fillable = [
		'emp_cod',
		'cli_cod',
		'num_doc',
		'serie_doc',
		'valor_brut',
		'valor_liq',
		'data_mov',
		'tipo',
		'status'
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
