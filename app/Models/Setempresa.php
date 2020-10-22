<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Setempresa
 * 
 * @property int $id_empresa
 * @property string $razao_social
 * @property string|null $nome_fantasia
 * @property string $Logradouro
 * @property int|null $Numero
 * @property string|null $Complemento
 * @property string $Bairro
 * @property string $Cidade
 * @property string $Estado
 * @property string $CEP
 * @property string|null $ibge
 * @property string $CNPJ
 * @property string $IE
 * @property string|null $IM
 * @property string|null $Telefone
 * @property int $ativo
 * @property string|null $Pag_web
 * @property string|null $email
 * @property string $Sigla
 * @property Carbon $DataCad
 * @property Carbon|null $DataAlt
 * @property int $regimetrib
 * @property int $atividade
 * @property int $saldo_cliente
 * @property Carbon $data_processamento
 * @property int $Licenca
 * 
 * @property Setatividade $setatividade
 * @property Collection|Almoxarifado[] $almoxarifados
 * @property Collection|Cliente[] $clientes
 * @property Collection|Clilogradouro[] $clilogradouros
 * @property Collection|Climov[] $climovs
 * @property Collection|ContratosEmpresa[] $contratos_empresas
 * @property Collection|Modocobranca[] $modocobrancas
 * @property Collection|Natoperacao[] $natoperacaos
 * @property Collection|Perfil[] $perfils
 * @property Collection|Prazopagamento[] $prazopagamentos
 * @property Collection|Setor[] $setors
 * @property Collection|Settributo[] $settributos
 * @property Collection|Tabelapreco[] $tabelaprecos
 * @property Collection|Te[] $tes
 * @property Collection|Transportadora[] $transportadoras
 * @property Collection|Usuario[] $usuarios
 * @property Collection|Vendedor[] $vendedors
 *
 * @package App\Models
 */
class Setempresa extends Model
{
	protected $table = 'setempresa';
	protected $primaryKey = 'id_empresa';
	public $timestamps = false;

	protected $casts = [
		'Numero' => 'int',
		'ativo' => 'int',
		'regimetrib' => 'int',
		'atividade' => 'int',
		'saldo_cliente' => 'int',
		'Licenca' => 'int'
	];

	protected $dates = [
		'DataCad',
		'DataAlt',
		'data_processamento'
	];

	protected $fillable = [
		'razao_social',
		'nome_fantasia',
		'Logradouro',
		'Numero',
		'Complemento',
		'Bairro',
		'Cidade',
		'Estado',
		'CEP',
		'ibge',
		'CNPJ',
		'IE',
		'IM',
		'Telefone',
		'ativo',
		'Pag_web',
		'email',
		'Sigla',
		'DataCad',
		'DataAlt',
		'regimetrib',
		'atividade',
		'saldo_cliente',
		'data_processamento',
		'Licenca'
	];

	public function setatividade()
	{
		return $this->belongsTo(Setatividade::class, 'atividade');
	}

	public function regimetrib()
	{
		return $this->belongsTo(Regimetrib::class, 'regimetrib');
	}

	public function almoxarifados()
	{
		return $this->hasMany(Almoxarifado::class, 'emp_cod');
	}

	public function clientes()
	{
		return $this->hasMany(Cliente::class, 'emp_cod');
	}

	public function clilogradouros()
	{
		return $this->hasMany(Clilogradouro::class, 'emp_cod');
	}

	public function climovs()
	{
		return $this->hasMany(Climov::class, 'emp_cod');
	}

	public function contratos_empresas()
	{
		return $this->hasMany(ContratosEmpresa::class, 'emp_cod');
	}

	public function modocobrancas()
	{
		return $this->hasMany(Modocobranca::class, 'emp_cod');
	}

	public function natoperacaos()
	{
		return $this->hasMany(Natoperacao::class, 'emp_cod');
	}

	public function perfils()
	{
		return $this->hasMany(Perfil::class, 'emp_cod');
	}

	public function prazopagamentos()
	{
		return $this->hasMany(Prazopagamento::class, 'emp_cod');
	}

	public function setors()
	{
		return $this->hasMany(Setor::class, 'emp_cod');
	}

	public function settributos()
	{
		return $this->hasMany(Settributo::class, 'emp_cod');
	}

	public function tabelaprecos()
	{
		return $this->hasMany(Tabelapreco::class, 'emp_cod');
	}

	public function tes()
	{
		return $this->hasMany(Te::class, 'emp_cod');
	}

	public function transportadoras()
	{
		return $this->hasMany(Transportadora::class, 'emp_cod');
	}

	public function usuarios()
	{
		return $this->hasMany(Usuario::class, 'empresa');
	}

	public function vendedors()
	{
		return $this->hasMany(Vendedor::class, 'emp_cod');
	}
}
