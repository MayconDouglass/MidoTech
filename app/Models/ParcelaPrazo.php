<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ParcelaPrazo
 * 
 * @property int $id_parcela
 * @property int $prazopag
 * @property int $parcela
 * @property float $porcentagem
 * @property int $prazo
 * @property int $tipo
 * 
 * @property Prazopagamento $prazopagamento
 *
 * @package App\Models
 */
class ParcelaPrazo extends Model
{
	protected $table = 'parcela_prazo';
	protected $primaryKey = 'id_parcela';
	public $timestamps = false;

	protected $casts = [
		'prazopag' => 'int',
		'parcela' => 'int',
		'porcentagem' => 'float',
		'prazo' => 'int',
		'tipo' => 'int'
	];

	protected $fillable = [
		'prazopag',
		'parcela',
		'porcentagem',
		'prazo',
		'tipo'
	];

	public function prazopagamento()
	{
		return $this->belongsTo(Prazopagamento::class, 'prazopag');
	}
}
