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
 * @property Collection|ParcelaPrazo[] $parcela_prazos
 *
 * @package App\Models
 */
class Prazopagamento extends Model
{
	protected $table = 'prazopagamento';
	protected $primaryKey = 'id_prazo';
	public $timestamps = false;

	protected $casts = [
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

	public function parcela_prazos()
	{
		return $this->hasMany(ParcelaPrazo::class, 'prazopag');
	}
}
