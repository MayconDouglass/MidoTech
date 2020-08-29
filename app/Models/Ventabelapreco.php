<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Ventabelapreco
 * 
 * @property int $id_ventab
 * @property int $vendedor
 * @property int $tabpreco
 * 
 * @property Tabelapreco $tabelapreco
 *
 * @package App\Models
 */
class Ventabelapreco extends Model
{
	protected $table = 'ventabelapreco';
	protected $primaryKey = 'id_ventab';
	public $timestamps = false;

	protected $casts = [
		'vendedor' => 'int',
		'tabpreco' => 'int'
	];

	protected $fillable = [
		'vendedor',
		'tabpreco'
	];

	public function tabelapreco()
	{
		return $this->belongsTo(Tabelapreco::class, 'tabpreco');
	}

	public function vendedor()
	{
		return $this->belongsTo(Vendedor::class, 'vendedor');
	}
}
