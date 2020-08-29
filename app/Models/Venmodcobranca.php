<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Venmodcobranca
 * 
 * @property int $id_venmod
 * @property int $vendedor
 * @property int $modocobranca
 * 
 *
 * @package App\Models
 */
class Venmodcobranca extends Model
{
	protected $table = 'venmodcobranca';
	protected $primaryKey = 'id_venmod';
	public $timestamps = false;

	protected $casts = [
		'vendedor' => 'int',
		'modocobranca' => 'int'
	];

	protected $fillable = [
		'vendedor',
		'modocobranca'
	];

	public function modocobranca()
	{
		return $this->belongsTo(Modocobranca::class, 'modocobranca');
	}

	public function vendedor()
	{
		return $this->belongsTo(Vendedor::class, 'vendedor');
	}
}
