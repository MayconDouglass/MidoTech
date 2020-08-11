<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Cliente
 * 
 * @property int $id_cliente
 * @property int $emp_cod
 * @property string $razao_social
 * @property string|null $nome_fantasia
 * @property int $tipo_pessoa
 * @property string $cpf_cnpj
 * @property int $status
 * @property string $insc_estadual
 * @property string|null $email
 * @property string|null $cnpj_sefaz
 * @property float $limite_cred
 * @property Carbon $venc_limite_cred
 * @property int $modo_cobranca
 * @property int $prazo_pagamento
 * @property int $tipo_contribuinte
 * @property int $transp_cod
 * @property int $flag_orc
 * @property boolean|null $observacoes
 * @property int $tab_cod
 * @property int $tes_cod
 * @property int $ven_cod
 * 
 * @property Setempresa $setempresa
 *
 * @package App\Models
 */
class Cliente extends Model
{
	protected $table = 'cliente';
	protected $primaryKey = 'id_cliente';
	public $timestamps = false;

	protected $casts = [
		'emp_cod' => 'int',
		'tipo_pessoa' => 'int',
		'status' => 'int',
		'limite_cred' => 'float',
		'modo_cobranca' => 'int',
		'prazo_pagamento' => 'int',
		'tipo_contribuinte' => 'int',
		'transp_cod' => 'int',
		'flag_orc' => 'int',
		'observacoes' => 'boolean',
		'tab_cod' => 'int',
		'tes_cod' => 'int',
		'ven_cod' => 'int'
	];

	protected $dates = [
		'venc_limite_cred'
	];

	protected $fillable = [
		'emp_cod',
		'razao_social',
		'nome_fantasia',
		'tipo_pessoa',
		'cpf_cnpj',
		'status',
		'insc_estadual',
		'email',
		'cnpj_sefaz',
		'limite_cred',
		'venc_limite_cred',
		'modo_cobranca',
		'prazo_pagamento',
		'tipo_contribuinte',
		'transp_cod',
		'flag_orc',
		'observacoes',
		'tab_cod',
		'tes_cod',
		'ven_cod'
	];

	public function setempresa()
	{
		return $this->belongsTo(Setempresa::class, 'emp_cod');
	}
}
