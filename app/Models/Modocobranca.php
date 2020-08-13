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
 * @property string $descricao
 * @property int $situacao
 * @property string|null $observacao
 * @property int|null $natureza
 * @property int $lib_credito
 * @property int $pag_nfe
 * @property int $ativo
 * @property Carbon $dataCad
 * @property Carbon $dataAlt
 * @property int $usuCad
 * @property int $usuAlt
 * 
 * @property Situacaomodcob $situacaomodcob
 * @property Usuario $usuario
 * @property Natoperacao $natoperacao
 * @property Collection|Cliente[] $clientes
 *
 * @package App\Models
 */
class Modocobranca extends Model
{
	protected $table = 'modocobranca';
	protected $primaryKey = 'id_modocob';
	public $timestamps = false;

	protected $casts = [
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

	public function clientes()
	{
		return $this->hasMany(Cliente::class, 'modo_cobranca');
	}
}
