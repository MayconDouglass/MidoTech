<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Contrato
 * 
 * @property int $id_contrato
 * @property string $razao_social
 * @property int $cli_cod
 * @property string $proposta
 * @property int $pessoa
 * @property string $cgc
 * @property int $status
 * @property float $valor
 * @property float $desconto
 * @property Carbon $data_cad
 * @property Carbon|null $data_alt
 * @property Carbon|null $data_fechamento
 * @property int $basico
 * @property int $nfs
 * @property int $nfe
 * @property int $nfce
 * @property int $cfe_sat
 * @property int $mfe
 * @property int $mde
 * @property int $mdfe
 * @property int $cte
 * @property int $contratos
 * @property int $servicos
 * 
 * @property Cliente $cliente
 * @property Collection|ContratoArquivo[] $contrato_arquivos
 * @property Collection|ContratosEmpresa[] $contratos_empresas
 *
 * @package App\Models
 */
class Contrato extends Model
{
	protected $table = 'contratos';
	protected $primaryKey = 'id_contrato';
	public $timestamps = false;

	protected $casts = [
		'cli_cod' => 'int',
		'pessoa' => 'int',
		'status' => 'int',
		'valor' => 'float',
		'desconto' => 'float',
		'basico' => 'int',
		'nfs' => 'int',
		'nfe' => 'int',
		'nfce' => 'int',
		'cfe_sat' => 'int',
		'mfe' => 'int',
		'mde' => 'int',
		'mdfe' => 'int',
		'cte' => 'int',
		'contratos' => 'int',
		'servicos' => 'int'
	];

	protected $dates = [
		'data_cad',
		'data_alt',
		'data_fechamento'
	];

	protected $fillable = [
		'razao_social',
		'cli_cod',
		'proposta',
		'pessoa',
		'cgc',
		'status',
		'valor',
		'desconto',
		'data_cad',
		'data_alt',
		'data_fechamento',
		'basico',
		'nfs',
		'nfe',
		'nfce',
		'cfe_sat',
		'mfe',
		'mde',
		'mdfe',
		'cte',
		'contratos',
		'servicos'
	];

	public function cliente()
	{
		return $this->belongsTo(Cliente::class, 'cli_cod');
	}

	public function contrato_arquivos()
	{
		return $this->hasMany(ContratoArquivo::class, 'contrato');
	}

	public function contratos_empresas()
	{
		return $this->hasMany(ContratosEmpresa::class, 'contrato');
	}
}
