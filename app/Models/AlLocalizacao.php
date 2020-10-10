<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AlLocalizacao
 * 
 * @property int $id_localizacao
 * @property int $al_cod
 * @property string $localiza_fisica
 * @property string $ean
 * @property int $tipo
 * @property float $capacidade
 * @property Carbon $data_cad
 * @property Carbon|null $data_alt
 * 
 * @property Almoxarifado $almoxarifado
 *
 * @package App\Models
 */
class AlLocalizacao extends Model
{
	protected $table = 'al_localizacao';
	protected $primaryKey = 'id_localizacao';
	public $timestamps = false;

	protected $casts = [
		'al_cod' => 'int',
		'tipo' => 'int',
		'capacidade' => 'float'
	];

	protected $dates = [
		'data_cad',
		'data_alt'
	];

	protected $fillable = [
		'al_cod',
		'localiza_fisica',
		'ean',
		'tipo',
		'capacidade',
		'data_cad',
		'data_alt'
	];

	public function almoxarifado()
	{
		return $this->belongsTo(Almoxarifado::class, 'al_cod');
	}
}
