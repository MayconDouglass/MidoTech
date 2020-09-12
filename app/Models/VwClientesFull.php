<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VwClientesFull
 * 
 * @property int $id_cliente
 * @property int $emp_cod
 * @property string $razao_social
 * @property string|null $nome_fantasia
 * @property int $tipo_pessoa
 * @property int $grupo
 * @property string $cpf_cnpj
 * @property int $status
 * @property string $insc_estadual
 * @property string|null $email
 * @property string|null $cnpj_sefaz
 * @property float $limite_cred
 * @property Carbon $venc_limite_cred
 * @property int $cModCob
 * @property int $modo_cobranca
 * @property int $cPrazoPag
 * @property int $prazo_pagamento
 * @property int $cTabPreco
 * @property int $tab_cod
 * @property int $tipo_contribuinte
 * @property int $transp_cod
 * @property int $flag_orc
 * @property string|null $observacoes
 * @property int $tes_cod
 * @property int $ven_cod
 * @property int $tipo
 * @property string $cep
 * @property string $endereco
 * @property string $bairro
 * @property string $cidade
 * @property string|null $complemento
 * @property string|null $IBGE
 * @property string $numero
 * @property string|null $referencia
 * @property string $UF
 *
 * @package App\Models
 */
class VwClientesFull extends Model
{
	protected $table = 'vw_clientes_full';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_cliente' => 'int',
		'emp_cod' => 'int',
		'tipo_pessoa' => 'int',
		'grupo' => 'int',
		'status' => 'int',
		'limite_cred' => 'float',
		'cModCob' => 'int',
		'modo_cobranca' => 'int',
		'cPrazoPag' => 'int',
		'prazo_pagamento' => 'int',
		'cTabPreco' => 'int',
		'tab_cod' => 'int',
		'tipo_contribuinte' => 'int',
		'transp_cod' => 'int',
		'flag_orc' => 'int',
		'tes_cod' => 'int',
		'ven_cod' => 'int',
		'tipo' => 'int'
	];

	protected $dates = [
		'venc_limite_cred'
	];

	protected $fillable = [
		'id_cliente',
		'emp_cod',
		'razao_social',
		'nome_fantasia',
		'tipo_pessoa',
		'grupo',
		'cpf_cnpj',
		'status',
		'insc_estadual',
		'email',
		'cnpj_sefaz',
		'limite_cred',
		'venc_limite_cred',
		'cModCob',
		'modo_cobranca',
		'cPrazoPag',
		'prazo_pagamento',
		'cTabPreco',
		'tab_cod',
		'tipo_contribuinte',
		'transp_cod',
		'flag_orc',
		'observacoes',
		'tes_cod',
		'ven_cod',
		'tipo',
		'cep',
		'endereco',
		'bairro',
		'cidade',
		'complemento',
		'IBGE',
		'numero',
		'referencia',
		'UF'
	];
}
