<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Almoxarifado
 * 
 * @property int $id_almoxarifado
 * @property int $emp_cod
 * @property string $codigo
 * @property string $descricao
 * @property int $tipo
 * @property int $status
 * @property int $qtd_estatistica
 * 
 * @property Setempresa $setempresa
 * @property Collection|AlLocalizacao[] $al_localizacaos
 *
 * @package App\Models
 */
class Almoxarifado extends Model
{
	protected $table = 'almoxarifado';
	protected $primaryKey = 'id_almoxarifado';
	public $timestamps = false;

	protected $casts = [
		'emp_cod' => 'int',
		'tipo' => 'int',
		'status' => 'int',
		'qtd_estatistica' => 'int'
	];

	protected $fillable = [
		'emp_cod',
		'codigo',
		'descricao',
		'tipo',
		'status',
		'qtd_estatistica'
	];

	public function setempresa()
	{
		return $this->belongsTo(Setempresa::class, 'emp_cod');
	}

	public function al_localizacao()
	{
		return $this->hasMany(AlLocalizacao::class, 'al_cod');
	}
}
