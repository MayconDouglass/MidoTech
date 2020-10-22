<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Modocobranca
 * 
 * @property int $id_modocob
 * @property int $emp_cod
 * @property string $descricao
 * @property int $situacao
 * @property string|null $observacao
 * @property int|null $natureza
 * @property int $lib_credito
 * @property int $pag_nfe
 * @property int $ativo
 * @property Carbon $dataCad
 * @property Carbon|null $dataAlt
 * @property int $usuCad
 * @property int|null $usuAlt
 * 
 * @property Situacaomodcob $situacaomodcob
 * @property Usuario $usuario
 * @property Natoperacao $natoperacao
 * @property Setempresa $setempresa
 * @property Collection|Cliente[] $clientes
 * @property Collection|Venmodcobranca[] $venmodcobrancas
 *
 * @package App\Models
 */
class Modocobranca extends Model
{
	protected $table = 'modocobranca';
	protected $primaryKey = 'id_modocob';
	public $timestamps = false;

	protected $casts = [
		'emp_cod' => 'int',
		'situacao' => 'int',
		'natureza' => 'int',
		'lib_credito' => 'int',
		'pag_nfe' => 'int',
		'ativo' => 'int',
		'usuCad' => 'int',
		'usuAlt' => 'int'
	];

	protected $dates = [
		'dataCad',
		'dataAlt'
	];

	protected $fillable = [
		'emp_cod',
		'descricao',
		'situacao',
		'observacao',
		'natureza',
		'lib_credito',
		'pag_nfe',
		'ativo',
		'dataCad',
		'dataAlt',
		'usuCad',
		'usuAlt'
	];

	public function situacaomodcob()
	{
		return $this->belongsTo(Situacaomodcob::class, 'situacao');
	}

	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'usuCad');
	}

	public function natoperacao()
	{
		return $this->belongsTo(Natoperacao::class, 'natureza');
	}

	public function setempresa()
	{
		return $this->belongsTo(Setempresa::class, 'emp_cod');
	}

	public function clientes()
	{
		return $this->hasMany(Cliente::class, 'modo_cobranca');
	}

	public function venmodcobrancas()
	{
		return $this->hasMany(Venmodcobranca::class, 'modocobranca');
	}
}
