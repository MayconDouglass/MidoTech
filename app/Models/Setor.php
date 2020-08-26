<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Setor
 * 
 * @property int $id_setor
 * @property int $emp_cod
 * @property string $setor
 * @property string $uf
 * @property int $ativo
 * 
 * @property Setempresa $setempresa
 * @property Collection|Vendedor[] $vendedors
 *
 * @package App\Models
 */
class Setor extends Model
{
	protected $table = 'setor';
	protected $primaryKey = 'id_setor';
	public $timestamps = false;

	protected $casts = [
		'emp_cod' => 'int',
		'ativo' => 'int'
	];

	protected $fillable = [
		'emp_cod',
		'setor',
		'uf',
		'ativo'
	];

	public function setempresa()
	{
		return $this->belongsTo(Setempresa::class, 'emp_cod');
	}

	public function vendedors()
	{
		return $this->hasMany(Vendedor::class, 'setor');
	}
}
