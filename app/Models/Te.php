<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Te
 * 
 * @property int $id_tes
 * @property int $emp_cod
 * @property string $descricao
 * @property string $CFOP
 * @property int $tipo
 * @property int $status
 * @property string $serie
 * @property int $calc_icms
 * @property int $calc_ipi
 * @property int $cred_icm
 * @property int $cred_ipi
 * @property int $cred_piscofins
 * @property int $financeiro
 * @property int $nfe
 * @property int $boleto
 * @property int $mov_estoque
 * @property int $dest_ipi
 * @property int $incide_ipi
 * @property int $incide_frete
 * @property int $incide_despesas
 * @property int $incide_base_ipi
 * @property int $calc_iss
 * @property int $at_custo
 * @property int $at_custo_medio
 * @property int $at_custo_aquisicao
 * @property int $at_preco_venda
 * @property int $soma
 * @property int $espelho
 * @property float $aliq_inss
 * @property float $inss_nfsuperior
 * @property float $aliq_iss
 * @property float $aliq_irrf
 * @property float $irrf_nfsuperior
 * @property float $ret_pis
 * @property float $pis_nfsuperior
 * @property float $ret_cofins
 * @property float $ret_csll
 * @property float $abat_suframa_pis
 * @property float $abat_suframa_cofins
 * @property int $comissao
 * @property int $al_padrao
 * @property int $simples
 * @property float $ali_simples
 * @property int $calc_import
 * @property int $soma_import
 * @property int $lancamento_ipi
 * @property int $incide_icms_pci
 * @property int $incide_despesas_pc
 * @property int $ded_icms_pc
 * @property int $calc_difal
 * @property int $calc_fcp
 * @property int $duplicata_st
 * @property int $desc_icms
 * @property int $desc_icms_des
 * @property int $desc_ipi
 * 
 * @property Setempresa $setempresa
 *
 * @package App\Models
 */
class Te extends Model
{
	protected $table = 'tes';
	protected $primaryKey = 'id_tes';
	public $timestamps = false;

	protected $casts = [
		'emp_cod' => 'int',
		'tipo' => 'int',
		'status' => 'int',
		'calc_icms' => 'int',
		'calc_ipi' => 'int',
		'cred_icm' => 'int',
		'cred_ipi' => 'int',
		'cred_piscofins' => 'int',
		'financeiro' => 'int',
		'nfe' => 'int',
		'boleto' => 'int',
		'mov_estoque' => 'int',
		'dest_ipi' => 'int',
		'incide_ipi' => 'int',
		'incide_frete' => 'int',
		'incide_despesas' => 'int',
		'incide_base_ipi' => 'int',
		'calc_iss' => 'int',
		'at_custo' => 'int',
		'at_custo_medio' => 'int',
		'at_custo_aquisicao' => 'int',
		'at_preco_venda' => 'int',
		'soma' => 'int',
		'espelho' => 'int',
		'aliq_inss' => 'float',
		'inss_nfsuperior' => 'float',
		'aliq_iss' => 'float',
		'aliq_irrf' => 'float',
		'irrf_nfsuperior' => 'float',
		'ret_pis' => 'float',
		'pis_nfsuperior' => 'float',
		'ret_cofins' => 'float',
		'ret_csll' => 'float',
		'abat_suframa_pis' => 'float',
		'abat_suframa_cofins' => 'float',
		'comissao' => 'int',
		'al_padrao' => 'int',
		'simples' => 'int',
		'ali_simples' => 'float',
		'calc_import' => 'int',
		'soma_import' => 'int',
		'lancamento_ipi' => 'int',
		'incide_icms_pci' => 'int',
		'incide_despesas_pc' => 'int',
		'ded_icms_pc' => 'int',
		'calc_difal' => 'int',
		'calc_fcp' => 'int',
		'duplicata_st' => 'int',
		'desc_icms' => 'int',
		'desc_icms_des' => 'int',
		'desc_ipi' => 'int'
	];

	protected $fillable = [
		'emp_cod',
		'descricao',
		'CFOP',
		'tipo',
		'status',
		'serie',
		'calc_icms',
		'calc_ipi',
		'cred_icm',
		'cred_ipi',
		'cred_piscofins',
		'financeiro',
		'nfe',
		'boleto',
		'mov_estoque',
		'dest_ipi',
		'incide_ipi',
		'incide_frete',
		'incide_despesas',
		'incide_base_ipi',
		'calc_iss',
		'at_custo',
		'at_custo_medio',
		'at_custo_aquisicao',
		'at_preco_venda',
		'soma',
		'espelho',
		'aliq_inss',
		'inss_nfsuperior',
		'aliq_iss',
		'aliq_irrf',
		'irrf_nfsuperior',
		'ret_pis',
		'pis_nfsuperior',
		'ret_cofins',
		'ret_csll',
		'abat_suframa_pis',
		'abat_suframa_cofins',
		'comissao',
		'al_padrao',
		'simples',
		'ali_simples',
		'calc_import',
		'soma_import',
		'lancamento_ipi',
		'incide_icms_pci',
		'incide_despesas_pc',
		'ded_icms_pc',
		'calc_difal',
		'calc_fcp',
		'duplicata_st',
		'desc_icms',
		'desc_icms_des',
		'desc_ipi'
	];

	public function setempresa()
	{
		return $this->belongsTo(Setempresa::class, 'emp_cod');
	}
}
