<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Vendedor
 * 
 * @property int $id_vendedor
 * @property int $emp_cod
 * @property string $nome
 * @property string|null $logradouro
 * @property string|null $complemento
 * @property string|null $numero
 * @property string|null $bairro
 * @property string|null $cidade
 * @property string|null $uf
 * @property string|null $cep
 * @property int $pessoa
 * @property string $cnpjcpf
 * @property int $tipo
 * @property int $supervisor
 * @property int $gerente
 * @property string|null $telefone
 * @property string|null $email
 * @property string $senha
 * @property float $comissao
 * @property float $pago_emissao
 * @property float $pago_baixa
 * @property float $desconto_max
 * @property float $pedido_min
 * @property int $setor
 * @property int $ativo
 * 
 * @property Setempresa $setempresa
 * @property Collection|Venmodcobranca[] $venmodcobrancas
 * @property Collection|Venprazopag[] $venprazopags
 * @property Collection|Ventabelapreco[] $ventabelaprecos
 *
 * @package App\Models
 */
class Vendedor extends Model
{
	protected $table = 'vendedor';
	protected $primaryKey = 'id_vendedor';
	public $timestamps = false;

	protected $casts = [
		'emp_cod' => 'int',
		'pessoa' => 'int',
		'tipo' => 'int',
		'supervisor' => 'int',
		'gerente' => 'int',
		'comissao' => 'float',
		'pago_emissao' => 'float',
		'pago_baixa' => 'float',
		'desconto_max' => 'float',
		'pedido_min' => 'float',
		'setor' => 'int',
		'ativo' => 'int'
	];

	protected $fillable = [
		'emp_cod',
		'nome',
		'logradouro',
		'complemento',
		'numero',
		'bairro',
		'cidade',
		'uf',
		'cep',
		'pessoa',
		'cnpjcpf',
		'tipo',
		'supervisor',
		'gerente',
		'telefone',
		'email',
		'senha',
		'comissao',
		'pago_emissao',
		'pago_baixa',
		'desconto_max',
		'pedido_min',
		'setor',
		'ativo'
	];

	public function setempresa()
	{
		return $this->belongsTo(Setempresa::class, 'emp_cod');
	}

	public function venmodcobrancas()
	{
		return $this->hasMany(Venmodcobranca::class, 'vendedor');
	}

	public function venprazopags()
	{
		return $this->hasMany(Venprazopag::class, 'vendedor');
	}

	public function ventabelaprecos()
	{
		return $this->hasMany(Ventabelapreco::class, 'vendedor');
	}
}
