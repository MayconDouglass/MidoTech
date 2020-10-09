<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ContratoArquivo
 * 
 * @property int $id_arquivo
 * @property int $contrato
 * @property string $path
 * 
 *
 * @package App\Models
 */
class ContratoArquivo extends Model
{
	protected $table = 'contrato_arquivos';
	protected $primaryKey = 'id_arquivo';
	public $timestamps = false;

	protected $casts = [
		'contrato' => 'int'
	];

	protected $fillable = [
		'contrato',
		'path'
	];

	public function contrato()
	{
		return $this->belongsTo(Contrato::class, 'contrato');
	}
}
