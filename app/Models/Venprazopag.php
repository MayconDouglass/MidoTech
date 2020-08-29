<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Venprazopag
 * 
 * @property int $id_venprazo
 * @property int $vendedor
 * @property int $prazopag
 * 
 * @property Prazopagamento $prazopagamento
 *
 * @package App\Models
 */
class Venprazopag extends Model
{
	protected $table = 'venprazopag';
	protected $primaryKey = 'id_venprazo';
	public $timestamps = false;

	protected $casts = [
		'vendedor' => 'int',
		'prazopag' => 'int'
	];

	protected $fillable = [
		'vendedor',
		'prazopag'
	];

	public function prazopagamento()
	{
		return $this->belongsTo(Prazopagamento::class, 'prazopag');
	}

	public function vendedor()
	{
		return $this->belongsTo(Vendedor::class, 'vendedor');
	}
}
