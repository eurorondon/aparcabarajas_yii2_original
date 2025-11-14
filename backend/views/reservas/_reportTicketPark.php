<?php

use yii\helpers\Html;

$char_color = strlen($model->coche->color);

if ($char_color < 3 ) {
    $color = 'N/D';
} else {
    $color = $model->coche->color;
}

if (empty($model->coche->matricula)) {
    $model->coche->matricula = 'N/D';
}

if (empty($model->coche->marca)) {
    $model->coche->marca = 'N/D';
}

if (empty($model->coche->modelo)) {
    $model->coche->modelo = 'N/D';
}

if (empty($model->cliente->movil)) {
    $model->cliente->movil = 'N/D';
}

if ($model->medio_reserva === 1) {
	$medio = 'phone.png';
}   
if ($model->medio_reserva === 2) {
	$medio = 'tags.png';
}
if ($model->medio_reserva === 3) {
	$medio = 'globe.png';
}
if ($model->medio_reserva === 4) {
	$medio = 'afiliado.png';
}

?>

<table style="margin-top: 30px; margin-left: -3px;">
	<tr>
		<td align="center" style="width: 7cm; text-transform: uppercase;">
			Matrícula
		</td>
	</tr>
	<tr>
		<td align="center" style="padding-top: 15px;">
			<div style="width: 7cm; font-size: 28px;"><?= $model->coche->matricula ?></div>
		</td>
	</tr>

	<tr>
		<td align="center" style="width: 7cm; text-transform: uppercase; padding-top: 25px;">
			Fecha de Salida
		</td>
	</tr>

	<tr>
		<td align="center" style="width: 7cm; text-transform: uppercase; padding-top: 15px;">
			<span style="font-size: 30px"><?= date('d/m/Y', strtotime($model->fecha_salida)) ?></span>
		</td>		
	</tr>

	<tr>
		<td align="center" style="width: 7cm; text-transform: uppercase;">
			<span style="font-size: 30px"><?= $model->hora_salida ?></span>
		</td>
	</tr>				
</table>


