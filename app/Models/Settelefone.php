<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Settelefone
 * 
 * @property int $id_tipo
 * @property int $emp_cod
 * @property string $nome
 *
 * @package App\Models
 */
class Settelefone extends Model
{
	protected $table = 'settelefone';
	protected $primaryKey = 'id_tipo';
	public $timestamps = false;

	protected $casts = [
		'emp_cod' => 'int'
	];

	protected $fillable = [
		'emp_cod',
		'nome'
	];
}
