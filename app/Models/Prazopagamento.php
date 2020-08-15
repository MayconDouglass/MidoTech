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
 * @property float $multa_atraso
 * @property float $acressimo_financeiro
 * @property int $desc_prazo
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
		'multa_atraso' => 'float',
		'acressimo_financeiro' => 'float',
		'desc_prazo' => 'int',
		'tipo_prazo' => 'int',
		'num_parcelas' => 'int',
		'ativo' => 'int'
	];

	protected $fillable = [
		'descricao',
		'taxa_diario',
		'multa_atraso',
		'acressimo_financeiro',
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
