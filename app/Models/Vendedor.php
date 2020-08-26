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
 * @property float $comissao
 * @property float $pago_emissao
 * @property float $pago_baixa
 * @property float $desconto_max
 * @property float $pedido_min
 * @property int $setor
 * 
 * @property Setempresa $setempresa
 * @property Vendedor $vendedor
 * @property Collection|Vendedor[] $vendedors
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
		'setor' => 'int'
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
		'comissao',
		'pago_emissao',
		'pago_baixa',
		'desconto_max',
		'pedido_min',
		'setor'
	];

	public function setempresa()
	{
		return $this->belongsTo(Setempresa::class, 'emp_cod');
	}

	public function vendedor()
	{
		return $this->belongsTo(Vendedor::class, 'gerente');
	}

	public function setor()
	{
		return $this->belongsTo(Setor::class, 'setor');
	}

	public function vendedors()
	{
		return $this->hasMany(Vendedor::class, 'gerente');
	}
}
