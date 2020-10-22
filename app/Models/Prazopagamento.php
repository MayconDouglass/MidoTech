<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Prazopagamento
 * 
 * @property int $id_prazo
 * @property int $emp_cod
 * @property string $descricao
 * @property float $taxa_diario
 * @property int $intervalodias
 * @property float $multa_atraso
 * @property float $acrescimo_financeiro
 * @property float $desc_prazo
 * @property int $tipo_prazo
 * @property int $num_parcelas
 * @property int $ativo
 * 
 * @property Setempresa $setempresa
 * @property Collection|ParcelaPrazo[] $parcela_prazos
 * @property Collection|Venprazopag[] $venprazopags
 *
 * @package App\Models
 */
class Prazopagamento extends Model
{
	protected $table = 'prazopagamento';
	protected $primaryKey = 'id_prazo';
	public $timestamps = false;

	protected $casts = [
		'emp_cod' => 'int',
		'taxa_diario' => 'float',
		'intervalodias' => 'int',
		'multa_atraso' => 'float',
		'acrescimo_financeiro' => 'float',
		'desc_prazo' => 'float',
		'tipo_prazo' => 'int',
		'num_parcelas' => 'int',
		'ativo' => 'int'
	];

	protected $fillable = [
		'emp_cod',
		'descricao',
		'taxa_diario',
		'intervalodias',
		'multa_atraso',
		'acrescimo_financeiro',
		'desc_prazo',
		'tipo_prazo',
		'num_parcelas',
		'ativo'
	];

	public function setempresa()
	{
		return $this->belongsTo(Setempresa::class, 'emp_cod');
	}

	public function parcela_prazos()
	{
		return $this->hasMany(ParcelaPrazo::class, 'prazopag');
	}

	public function venprazopags()
	{
		return $this->hasMany(Venprazopag::class, 'prazopag');
	}
}
