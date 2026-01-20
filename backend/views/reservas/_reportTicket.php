<?php

use yii\helpers\Html;

$char_color = strlen($model->coche->color);

if ($char_color < 3) {
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

if (!empty($model->coche->modelo)) {
	$model->coche->modelo = substr($model->coche->modelo, 0, 7);
}

if (empty($model->cliente->movil)) {
	$model->cliente->movil = 'N/D';
}

if ($model->medio_reserva === 1) {
	$medio = 'phone-24.png';
}
if ($model->medio_reserva === 2) {
	$medio = 'tags.png';
}
if ($model->medio_reserva === 3) {
	$medio = 'browser.svg';
}
if ($model->medio_reserva === 4) {
	$medio = 'afiliado.png';
}

?>

<div style="margin-top: 1cm;font-size: 17px; font-weight: bolder; font-family: sans-serif;"><b><?= $model->nro_reserva ?></b></div>

<div style="margin-top: 0.5cm;">
	<?= Html::img('@web/images/' . $medio, ['style' => ['width' => '20px']]); ?>
</div>

<div style="margin-top: -1.6cm; font-size: 17px; font-weight: bolder; font-family: sans-serif;">
</div>

<div align="right" style="text-transform: uppercase; font-size: 12px">Importe : <b><?= $model->monto_total ?> €</b></div>
<div align="right" style="text-transform: uppercase; font-size: 12px">Teléfono : <b><?= $model->cliente->movil ?></b></div>

<div align="center">
	<?= Html::img('@backend/web/images/ticket_logo.png', ['style' => ['width' => '4cm', 'height' => '3.3cm', 'margin' => '30px 0']]); ?>
</div>

<div align="right" style="font-size: 8px; margin-right: .7cm; margin-top: -0.8cm;">
	CIF. B88537345
</div>

<hr style="margin: 15px 0px 0px 0px">

<table style="margin-top: 15px; margin-left: -3px;">
	<tr>
		<td colspan="2" align="center" style="width: 7cm; text-transform: uppercase;">
			Matrícula
			<div align="center" style="width: 7cm; font-size: 36px"><?= $model->coche->matricula ?></div>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center" style="width: 3.5cm; text-transform: uppercase; padding-top: 10px">
			Marca - Modelo
			<div align="center" style="width: 3.5cm; font-size: 20px"><?= $model->coche->marca . " " . $model->coche->modelo ?></div>
		</td>
	</tr>

	<tr>
		<td colspan="2" align="center" style="width: 7cm; text-transform: uppercase; padding-top: 15px">
			Fecha de Entrada
		</td>
	</tr>

	<tr>
		<td colspan="2" align="center" style="width: 7cm; text-transform: uppercase;">
			<div align="center" style="font-size: 22px"><?= $model->hora_entrada ?></div>
		</td>
	</tr>

	<tr>
		<td colspan="2" align="center" style="width: 7cm; text-transform: uppercase;">
			<div align="center" style="font-size: 22px"><?= date('d/m/Y', strtotime($model->fecha_entrada)) ?></div>
		</td>
	</tr>

	<tr>
		<td colspan="2" align="center" style="width: 7cm; text-transform: uppercase; padding-top: 15px">
			Fecha de Salida
		</td>
	</tr>

	<tr>
		<td colspan="2" align="center" style="width: 7cm; text-transform: uppercase;">
			<div align="center" style="font-size: 22px"><?= $model->hora_salida ?></div>
		</td>
	</tr>

	<tr>
		<td colspan="2" align="center" style="width: 7cm; text-transform: uppercase;">
			<div align="center" style="font-size: 22px"><?= date('d/m/Y', strtotime($model->fecha_salida)) ?></div>
		</td>
	</tr>

</table>

<hr style="margin: 6px 0px">
<?php if ($contS > 0) { ?>
	<div style="height: 3cm">
		<b>INCLUYE:</b><br />
		<?php for ($i = 0; $i < count($servicios); $i++) {
			if ($servicios[$i]->servicios->fijo == 2) { ?>
				<?= strtoupper($servicios[$i]->servicios->nombre_servicio) ?><br />
		<?php }
		} ?>
	</div>
<?php } else { ?>
	<div style="height: 3cm">
	</div>
<?php } ?>

<div>
	<?php if ($model['id_tipo_pago'] == 5) { ?>
		NOTA: LA RESERVA FUÉ PAGADA ONLINE
	<?php } ?>
	<hr style="margin: 0% 0% 2% 0%">
	<div style="font-size: 10px; text-transform: uppercase;">
		Asistencia en el Aeropuerto: <b>+34 604194861</b>
	</div>
	<div style="margin-top: 5px; text-transform: uppercase; text-align: justify; font-size: 8px"><b>El parking no se hace responsable de la rotura de cristales. Daños mecanicos y objetos no declarados.</b></div>
	<div style="margin-top: 5px; text-transform: uppercase; text-align: justify; font-size: 8px">
		<b>El cliente debe tomar fotos/videos de su vehículo en la entrega del mismo en la terminal del aeropuerto para poder reclamar cualquier desperfecto en la recogida a su regreso.</b>
	</div>
	<div style="margin-top: 5px; text-align: center; font-size: 12px"><b>Gracias por Preferirnos</b></div>
</div>
