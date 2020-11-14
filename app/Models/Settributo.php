<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Settributo
 * 
 * @property int $id_tributacao
 * @property int $emp_cod
 * @property string $codigo
 * @property string $descricao
 * @property int $tipo
 * @property string $trib_cst
 * @property int $trib_origem
 * @property int $mod_icms
 * @property int $mod_icms_st
 * @property int $mot_desoneracao
 * @property float $aliq_mva
 * @property float $aliq_mva_simples
 * @property float $aliq_icms
 * @property float $aliq_icms_interno
 * @property float $aliq_icms_st
 * @property float $aliq_red_icms
 * @property float $aliq_red_icms_st
 * @property float $aliq_simples
 * @property string $trib_csosn
 * @property float $aliq_fecp
 * @property int $tipo_riolog
 * @property string|null $benef_fiscal
 * @property float $aliq_diferimento
 * @property float $aliq_red_unitario
 * @property int $ativo
 * 
 * @property Setempresa $setempresa
 *
 * @package App\Models
 */
class Settributo extends Model
{
	protected $table = 'settributos';
	protected $primaryKey = 'id_tributacao';
	public $timestamps = false;

	protected $casts = [
		'emp_cod' => 'int',
		'tipo' => 'int',
		'trib_origem' => 'int',
		'mod_icms' => 'int',
		'mod_icms_st' => 'int',
		'mot_desoneracao' => 'int',
		'aliq_mva' => 'float',
		'aliq_mva_simples' => 'float',
		'aliq_icms' => 'float',
		'aliq_icms_interno' => 'float',
		'aliq_icms_st' => 'float',
		'aliq_red_icms' => 'float',
		'aliq_red_icms_st' => 'float',
		'aliq_simples' => 'float',
		'aliq_fecp' => 'float',
		'tipo_riolog' => 'int',
		'aliq_diferimento' => 'float',
		'aliq_red_unitario' => 'float',
		'ativo' => 'int'
	];

	protected $fillable = [
		'emp_cod',
		'codigo',
		'descricao',
		'tipo',
		'trib_cst',
		'trib_origem',
		'mod_icms',
		'mod_icms_st',
		'mot_desoneracao',
		'aliq_mva',
		'aliq_mva_simples',
		'aliq_icms',
		'aliq_icms_interno',
		'aliq_icms_st',
		'aliq_red_icms',
		'aliq_red_icms_st',
		'aliq_simples',
		'trib_csosn',
		'aliq_fecp',
		'tipo_riolog',
		'benef_fiscal',
		'aliq_diferimento',
		'aliq_red_unitario',
		'ativo'
	];

	public function setempresa()
	{
		return $this->belongsTo(Setempresa::class, 'emp_cod');
	}
}
