<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Transportadora
 * 
 * @property int $id_transp
 * @property int $emp_cod
 * @property string $razao_social
 * @property string|null $nome_fantasia
 * @property string $transp_cgc
 * @property string|null $transp_ie
 * @property string|null $email
 * @property string $cep
 * @property string $logradouro
 * @property string|null $numero
 * @property string|null $complemento
 * @property string $cidade
 * @property string $bairro
 * @property string $uf
 * @property string $ibge
 * @property string|null $telefone
 * @property string|null $car_modelo
 * @property string $car_placa
 * @property string $car_uf
 * @property string $car_cidade
 * @property string|null $site
 * @property string|null $observacao
 * @property int $setor
 * @property Carbon $data_cad
 * @property Carbon|null $data_alt
 * 
 * @property Setempresa $setempresa
 *
 * @package App\Models
 */
class Transportadora extends Model
{
	protected $table = 'transportadora';
	protected $primaryKey = 'id_transp';
	public $timestamps = false;

	protected $casts = [
		'emp_cod' => 'int',
		'setor' => 'int'
	];

	protected $dates = [
		'data_cad',
		'data_alt'
	];

	protected $fillable = [
		'emp_cod',
		'razao_social',
		'nome_fantasia',
		'transp_cgc',
		'transp_ie',
		'email',
		'cep',
		'logradouro',
		'numero',
		'complemento',
		'cidade',
		'bairro',
		'uf',
		'ibge',
		'telefone',
		'car_modelo',
		'car_placa',
		'car_uf',
		'car_cidade',
		'site',
		'observacao',
		'setor',
		'data_cad',
		'data_alt'
	];

	public function setempresa()
	{
		return $this->belongsTo(Setempresa::class, 'emp_cod');
	}

	public function setor()
	{
		return $this->belongsTo(Setor::class, 'setor');
	}
}
