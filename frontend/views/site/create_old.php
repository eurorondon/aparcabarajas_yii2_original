<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use kartik\depdrop\DepDrop;
use common\models\Coches;
use kartik\color\ColorInput;

/* @var $this yii\web\View */
/* @var $model common\models\Reservas */
/* @var $form yii\widgets\ActiveForm */

$Url = Url::to(['site/modifica']);
$UrlAnu = Url::to(['site/anulacion']);

$model->fecha_entrada = $entrada;
$model->hora_entrada = $hora_e;

$model->fecha_salida = $salida;
$model->hora_salida = $hora_s;

$this->title = Yii::$app->name . ' | Nueva Reserva';

$cant = count($precio_diario);
$num = 1;
for ($i = 0; $i < $cant; $i++) { ?>
  <input class="form-control" style="margin-bottom: 20px" type="hidden" id="precio-diario<?= $num ?>"
    value="<?= $precio_diario[$i]['precio'] ?>">

  <?php $num++;
}

$formato = new IntlDateFormatter(
  'es-ES',
  IntlDateFormatter::FULL,
  IntlDateFormatter::FULL,
  'Europe/Madrid',
  IntlDateFormatter::GREGORIAN,
  "eeee d 'de' LLLL 'de' yyyy"
);

?>

<main class="container_fluid">
  <section class="row">
    <?php $form = ActiveForm::begin(); ?>
    <div class="reserva__container flex-md-column flex-lg-row col-12 d-flex" style="margin-top: 15px">

      <?= $form->field($model, 'iva')->hiddenInput(['value' => $iva])->label(false) ?>
      <?= $form->field($model, 'dias')->hiddenInput(['value' => $cant_dias])->label(false) ?>
      <?= $form->field($model, 'monto_impuestos')->hiddenInput()->label(false) ?>
      <?= $form->field($model, 'monto_total')->hiddenInput()->label(false) ?>
      <?= $form->field($model, 'type')->hiddenInput(['id' => 'type_reserva', 'value' => $type_reserva, 'name' => 'type'])->label(false) ?>

      <?= $form->field($model, 'costo_servicios')->hiddenInput(['value' => '0.00'])->label(false) ?>
      <?= $form->field($model, 'total_seguro')->hiddenInput(['value' => $seguro[0]->costo])->label(false) ?>
      <?= $form->field($model, 'costo_servicios_extra')->hiddenInput(['value' => '0.00'])->label(false) ?>
      <input type="hidden" id="precio_dia" name="precio_dia" value="<?= $precio_dia ?>">

      <input type="hidden" name="servicio_noc_id" value="<?= !is_null($nocturno) ? $nocturno[0]['id'] : 0 ?>">
      <input type="hidden" id="servicio_noc" name="servicio_noc_costo"
        value="<?= !is_null($nocturno) ? $nocturno[0]['costo'] : 0 ?>">

      <input type="hidden" id="url" value="<?= $Url ?>">
      <input type="hidden" id="urlAnu" value="<?= $UrlAnu ?>">
      <input type="hidden" id="reserva" value="<?= $model->nro_reserva ?>">
      <input type="hidden" name="solicitud_factura" value="<?= $solicitud_factura ?>">

      <div class="reserva__ini col-sm-12 col-md-8 col-lg-8">
        <div class="col-12 d-flex">
          <div class="col-md-3 col-lg-3 reserva__ini__picture  d-sm-flex justify-content-center align-items-center">
            <?= Html::img('@web/images/logo_apv.png'); ?>
          </div>
          <div class="col-md-9 col-lg-9">
            <h2>Aparcabarajas</h2>
            <p>
              <?= Html::img('@web/images/map-pin.svg'); ?>
              7 minutos de distancia de Madrid-Barajas
            </p>
            <p>
              <?= Html::img('@web/images/time.svg'); ?>
              Abierto 24/7
              <?= Html::img('@web/images/car.svg'); ?>
              Entrega de su vehiculo
            </p>
            <h4 class="mt-4 mb-2">Tu reserva</h4>
            <p class="lh-base">
              <strong><?= $cant_dias ?></strong> días
              <strong> parking con servicio de recogina del vehiculo </strong>
              desde
              <strong class="arrivalDate"><?= $formato->format(new DateTime($model->fecha_entrada))
                ?></strong>
              hasta
              <strong class="arrivalDate"><?= $formato->format(new DateTime($model->fecha_salida))
                ?></strong>
            </p>
          </div>
        </div>

        <div class="col-md-12 col-lg-12 d-md-block d-lg-none reserva__price__movil">
          <div class="col-12 p-3" style="border: 1px solid #cccfcf">
            <div class="fs-4 pb-2" style="border-bottom: 1px solid #cccfcf">
              Precio
            </div>
            <div class="col-12 pt-2" style="border-bottom: 1px solid #cccfcf; color: #8fa501">
              <strong>Tu reserva incluye</strong>
              <p class="pb-3">
                - Explicación detallada y descripción de los servicios.
              </p>
            </div>

            <div class="col-md-12 col-lg-12 d-fle_x py-3">
              <p>
                Parking - Plan Premiun
              </p>
              <p>
                Recogida y entrega de Vehiculo
              </p>
              <?php if (!is_null($nocturno)) { ?>
                <p>
                  Servicio de Nocturnidad
                </p>
              <?php } ?>

              <?php if ($type_reserva == 9) { ?>
                <p>
                  Techado
                </p>
                <p>
                  Lavado Exterior Cortesia
                </p>
              <?php } ?>

              <?php if ($type_reserva == 12) { ?>
                <p>
                  Lavado Interior/Exterior
                </p>
                <p>
                  Parking Interior
                </p>
              <?php } ?>
            </div>
          </div>
          <div class="col-12 text-white p-3 mb-3 fs-4 d-flex justify-content-between align-items-center"
            style="background-color: #000000">
            <strong>Total a cancelar</strong>

            <span class=""><strong class="reserva__detail__monto">0</strong>€</span>
          </div>
        </div>

        <div class="col-md-12 col-lg-12 mt-4 p-2" style="background-color: #fcfcfc">
          <form>
            <h3 class="mb-4 pb-3" style="border-bottom: 1px solid #e7eaed">
              Información de la reserva
            </h3>
            <div class="form-group d-flex mt-1 flex-sm-column flex-md-row reserva__form__item">
              <label for="" class="col-md-6 col-lg-5 control-label">
                Fecha de entrada al parking *
              </label>
              <div class="col-md-6 col-lg-5">
                <?=
                  $form->field($model, 'fecha_entrada')->textInput([
                    'readonly' => true,
                    'style' => 'border-radius: 6px !important;',
                    'class' => 'form-control'
                  ])->label(false) ?>
              </div>
            </div>

            <div class="form-group mt-2 d-flex flex-sm-column flex-md-row reserva__form__item">
              <label for="" class="control-label col-md-6 col-lg-5 time">
                Hora de entrada al parking *
              </label>
              <div class="col-md-6 col-lg-5 checkmark-placement contains-select time">

                <?= $form->field($model, 'hora_entrada')->textInput([
                  'readonly' => true,
                  'style' => 'border-radius: 6px !important;',
                  'class' => 'form-control'
                ])->label(false) ?>
              </div>
            </div>

            <div class="form-group mt-2 d-flex flex-sm-column flex-md-row reserva__form__item">
              <label for="" class="col-md-6 col-lg-5 control-label">
                Fecha de salida del parking *
              </label>
              <div class="col-md-6 col-lg-5">
                <?=
                  $form->field($model, 'fecha_salida')->textInput([
                    'readonly' => true,
                    'style' => 'border-radius: 6px !important;',
                    'class' => 'form-control'
                  ])->label(false) ?>
              </div>
            </div>

            <div class="form-group mt-2 d-flex flex-sm-column flex-md-row reserva__form__item">
              <label for="" class="control-label col-md-6 col-lg-5 time">
                Hora de salida del parking *
              </label>
              <div class="col-md-6 col-lg-5 checkmark-placement contains-select time">
                <?= $form->field($model, 'hora_salida')->textInput([
                  'readonly' => true,
                  'style' => 'border-radius: 6px !important;',
                  'class' => 'form-control'
                ])->label(false) ?>
              </div>
            </div>

            <div class="form-group mt-2 d-flex flex-sm-column flex-md-row reserva__form__item">
              <label for="" class="control-label col-md-6 col-lg-5 time">
                Terminal de entrada
              </label>
              <div class="col-md-6 col-lg-5">
                <?= $form->field($model, 'terminal_entrada')->widget(Select2::classname(), [
                  'data' => $terminales,
                  'class' => 'form-control',
                  'options' => ['placeholder' => 'Selecccione'],
                  'pluginOptions' => [
                    'allowClear' => true
                  ],
                ])->label(false); ?>
              </div>
            </div>

            <div class="form-group mt-2 d-flex flex-sm-column flex-md-row reserva__form__item">
              <label for="" class="control-label col-md-6 col-lg-5 time">
                Terminal de salida
                <span class="tooltipcurved-content">Terminal en donde te entregaremos tu coche. En caso de no saber la
                  terminal sugerimos seleccionar "AUN NO CONOZCO LA TERMINAL"</span>
                </span>
              </label>
              <div class="col-md-6 col-lg-5">
                <?= $form->field($model, 'terminal_salida')->widget(Select2::classname(), [
                  'data' => $terminales,
                  'class' => 'form-control',
                  'options' => ['placeholder' => 'Selecccione'],
                  'pluginOptions' => [
                    'allowClear' => true
                  ],
                ])->label(false); ?>
              </div>
            </div>

            <div class="form-group mt-2 d-flex flex-sm-column flex-md-row reserva__form__item">
              <label for="" class="control-label col-md-6 col-lg-5 time">
                Ciudad de procedencia
              </label>
              <div class="col-md-6 col-lg-5">
                <?= $form->field($model, 'ciudad_procedencia')->textInput(['maxlength' => true, 'class' => 'form-control'])->label(false); ?>
              </div>
            </div>

            <div class="form-group mt-2 d-flex flex-sm-column flex-md-row reserva__form__item">
              <label for="" class="control-label col-md-6 col-lg-5 time">
                Observación
              </label>
              <div class="col-md-6 col-lg-5">
                <?= $form->field($model, 'observaciones')->textarea(['rows' => '5', 'class' => 'form-control'])->label(false) ?>
              </div>
            </div>

            <h3 class="pb-3" style="border-bottom: 1px solid #e7eaed; margin: 32px 0">
              Información personal
            </h3>

            <div class="form-group d-flex mt-4 flex-sm-column flex-md-row reserva__form__item">
              <label for="" class="col-md-6 col-lg-5 control-label">
                Nombres y apellidos *
              </label>
              <div class="col-md-6 col-lg-5">
                <?= $form->field($modelC, 'nombre_completo')->textInput(['maxlength' => true, 'autocomplete' => 'off', 'class' => 'form-control'])->label(false) ?>
              </div>
            </div>

            <div class="form-group mt-2 d-flex flex-sm-column flex-md-row reserva__form__item">
              <label for="" class="control-label col-md-6 col-lg-5 time">
                Correo Electrónico *
              </label>
              <div class="col-md-6 col-lg-5">
                <?= $form->field($modelC, 'correo')->textInput(['maxlength' => true, 'autocomplete' => 'off', 'class' => 'form-control'])->label(false) ?>
              </div>
            </div>

            <div class="form-group mt-2 d-flex flex-sm-column flex-md-row reserva__form__item">
              <label for="" class="col-md-6 col-lg-5 control-label">
                N° de Móvil *
              </label>
              <div class="col-md-6 col-lg-5">
                <?= $form->field($modelC, 'movil')->textInput(['maxlength' => true, 'autocomplete' => 'off', 'class' => 'form-control'])->label(false) ?>
              </div>
            </div>

            <div class="form-group mt-2 d-flex flex-sm-column flex-md-row reserva__form__item">
              <label for="" class="control-label col-md-6 col-lg-5">
                Marca y Modelo *
              </label>
              <div class="col-md-6 col-lg-5">
                <?= $form->field($modelV, 'marca')->textInput(['maxlength' => true, 'autocomplete' => 'off', 'class' => 'form-control'])->label(false) ?>
              </div>
            </div>

            <div class="form-group mt-2 d-flex flex-sm-column flex-md-row reserva__form__item">
              <label for="" class="control-label col-md-6 col-lg-5">
                Matricula
              </label>
              <div class="col-md-6 col-lg-5">
                <?= $form->field($modelV, 'matricula')->textInput(['maxlength' => true, 'autocomplete' => 'off', 'class' => 'form-control'])->label(false) ?>
              </div>
            </div>

            <div class="form-group mt-2 d-flex flex-sm-column flex-md-row reserva__form__item">
              <label for="" class="control-label col-md-6 col-lg-5"></label>
              <div class="col-md-6 col-lg-5">
                <?= $form->field($model, 'factura')->checkbox(['onclick' => 'muestra("facturacion")', 'uncheck' => '0', 'value' => '1'])->label(false) ?>
              </div>
            </div>

            <div class="reserva__factura" id="facturacion">
              <h3 class="pb-3" style="border-bottom: 1px solid #e7eaed; margin: 32px 0">
                Información de la factura
              </h3>
              <div class="form-group mt-2 d-flex flex-sm-column flex-md-row reserva__form__item">
                <label for="" class="control-label col-md-6 col-lg-5">NIF</label>
                <div class="col-md-6 col-lg-5">
                  <?= $form->field($model, 'nif')->textInput(['maxlength' => true])->label(false) ?>
                </div>
              </div>

              <div class="form-group mt-2 d-flex flex-sm-column flex-md-row reserva__form__item">
                <label for="" class="control-label col-md-6 col-lg-5">Razón social</label>
                <div class="col-md-6 col-lg-5">
                  <?= $form->field($model, 'razon_social')->textInput(['maxlength' => true])->label(false) ?>
                </div>
              </div>

              <div class="form-group mt-2 d-flex flex-sm-column flex-md-row reserva__form__item">
                <label for="" class="control-label col-md-6 col-lg-5">Dirección</label>
                <div class="col-md-6 col-lg-5">
                  <?= $form->field($model, 'direccion')->textInput(['maxlength' => true])->label(false) ?>
                </div>
              </div>

              <div class="form-group mt-2 d-flex flex-sm-column flex-md-row reserva__form__item">
                <label for="" class="control-label col-md-6 col-lg-5">Código Postal</label>
                <div class="col-md-6 col-lg-5">
                  <?= $form->field($model, 'cod_postal')->textInput(['maxlength' => true])->label(false) ?>
                </div>
              </div>

              <div class="form-group mt-2 d-flex flex-sm-column flex-md-row reserva__form__item">
                <label for="" class="control-label col-md-6 col-lg-5">Ciudad</label>
                <div class="col-md-6 col-lg-5">
                  <?= $form->field($model, 'ciudad')->textInput(['maxlength' => true])->label(false) ?>
                </div>
              </div>

              <div class="form-group mt-2 d-flex flex-sm-column flex-md-row reserva__form__item">
                <label for="" class="control-label col-md-6 col-lg-5">Provincia</label>
                <div class="col-md-6 col-lg-5">
                  <?= $form->field($model, 'provincia')->textInput(['maxlength' => true])->label(false) ?>
                </div>
              </div>

              <div class="form-group mt-2 d-flex flex-sm-column flex-md-row reserva__form__item">
                <label for="" class="control-label col-md-6 col-lg-5">País</label>
                <div class="col-md-6 col-lg-5">
                  <?= $form->field($model, 'pais')->textInput(['maxlength' => true])->label(false) ?>
                </div>
              </div>

            </div>
            <h3 class="pb-3" style="border-bottom: 1px solid #e7eaed; margin: 32px 0">
              Servicios Extras Disponibles
            </h3>
            <?php
            foreach ($servicios as $s) {
              $service = array($s->id => $s->nombre_servicio);
              ?>



              <div class="form-group mt-2"
                style="<?= (((in_array($s->id, [7, 9])) && $type_reserva == 9) || (in_array($s->id, [2, 12]) && $type_reserva == 12) || ($s->id == 7 && $type_reserva != 9)) ? 'display:none' : '' ?>">
                <?= $form->field($model, 'tipo_servicio')->hiddenInput(['id' => 'tipo_servicio' . $s->id, 'value' => $s->fijo, 'name' => 'tipo_servicio' . $s->id])->label(false) ?>

                <?= $form->field($model, 'cantidad')->hiddenInput(['id' => 'cantidad' . $s->id, 'value' => 0, 'min' => 1, 'name' => 'cantidad' . $s->id])->label(false) ?>

                <div class="col-12 d-flex ser__extra_item">
                  <div class="col-sm-9 col-md-9 col-lg-9 d-flex flex-column reserva__ser__extra">
                    <?= $form->field($model, 'servicios')->checkboxList($service, [
                      'separator' => '<br>',
                      'itemOptions' => [
                        'class' => 'servicios form-check-input servi' . $s->id,
                        'precio' => $s->costo,
                        'labelOptions' => ['class' => 'services']
                      ]
                    ])->label(false); ?>
                    <span class="des-reserva-ind"><?= $s->descripcion; ?></span>
                  </div>
                  <div class="col-sm-3 col-md-3 col-lg-3 text-end">
                    <?= $form->field($model, 'precio_unitario', [
                      'template' => '<div class="input-group costos-facturas">{input}
                    <span class="input-group-addon eu">€</span></div>{error}{hint}'
                    ])->textInput(['id' => 'precio_unitario' . $s->id, 'readonly' => true, 'value' => $s->costo, 'class' => 'form-control cantidad', 'name' => 'precio_unitario' . $s->id]) ?>
                  </div>
                </div>
              </div>
            <?php } ?>



            <div class="hide">
              <div class="col-lg-2" style="margin-top:-8px">
                <?= $form->field($model, 'servicio_basico', [
                  'template' => '<div class="input-group costos-facturas">{input}
              <span class="input-group-addon eu">€</span></div>{error}{hint}'
                ])->textInput(['id' => 'servicio_basico', 'readonly' => true, 'value' => $precio_diario[0]['costo'], 'class' => 'form-control cantidad', 'name' => 'servicio_basico']) ?>
              </div>

              <div class="col-lg-1" style="margin-top:-8px">
                <?= $form->field($model, 'cant_basico', [
                  'template' => '<div class="input-group costos-facturas">{input}
              </div>{error}{hint}'
                ])->textInput(['id' => 'cant_basico', 'type' => 'number', 'readonly' => true, 'class' => 'form-control cantidad', 'name' => 'cant_basico', 'value' => $cant_dias]) ?>
              </div>


              <div class="col-lg-2" style="margin-top:-8px">
                <?= $form->field($model, 'seguro')->hiddenInput(['id' => 'seguro', 'readonly' => true, 'value' => $seguro[0]->costo, 'class' => 'form-control cantidad', 'name' => 'seguro'])->label(false) ?>
              </div>

              <div class="col-lg-1" style="margin-top:-8px">
                <?= $form->field($model, 'cant_seguro', [
                  'template' => '<div class="input-group costos-facturas">{input}
              </div>{error}{hint}'
                ])->hiddenInput(['id' => 'cant_seguro', 'readonly' => true, 'class' => 'form-control cantidad', 'name' => 'cant_seguro', 'value' => 1]) ?>
              </div>
            </div>


            <h3 class="pb-3" style="border-bottom: 1px solid #e7eaed; margin: 32px 0">
              Forma de pago
            </h3>

            <div class="form-group mt-2 col-12 d-flex flex-column">
              <div class="col-lg-5 col-xs-12">
                <?= $form->field($model, 'id_tipo_pago')->widget(Select2::classname(), [
                  'data' => $tipos_pago,
                  'options' => ['placeholder' => 'Selecccione forma de pago'],
                  'pluginOptions' => [
                    'allowClear' => true
                  ],
                ]); ?>
              </div>

              <div class="col-lg-7 col-xs-10" style="margin-top: 32px; padding-left: 25px">
                <?= $form->field($model, 'condiciones')->checkbox(['uncheck' => ' ', 'value' => '1'])->label(false) ?>
              </div>
            </div>

            <div class="col-12 mt-4 d-flex justify-content-sm-end reserva__total__pagar">
              <div
                class="col-md-7 col-lg-9 fs-4 text-end mx-2 d-flex justify-content-end align-items-center totales-facturas"
                id="subtotal-factura">
                Total a Pagar
              </div>
              <div class="col-md-3 col-lg-3 d-flex fs-3 justify-content-center align-items-center fw-bold">
                <?= $form->field($model, 'monto_factura', [
                  'template' => '<div class="input-group costos-facturas">{input}
                  <span class="input-group-addon eu">€</span></div>{error}{hint}'
                ])->textInput(['maxlength' => true, 'readonly' => true, 'value' => '0.00']) ?>
              </div>
            </div>


            <div class="col-12 d-flex align-items-center justify-content-end my-4">
              <?= Html::a('Cancelar', ['/site/index'], ['class' => 'btn text-white fs-6 mx-4', 'style' => 'background-color: #000']) ?>
              <?= Html::submitButton('Procesar Reserva', ['class' => 'btn text-white p-2', 'id' => 'finalizar', 'style' => 'background-color: #8fa501']) ?>

            </div>
          </form>
        </div>
      </div>


      <!-- Inicio segunda columna -->

      <div class="reserva_form col-sm-12 col-md-4 col-lg-4 p-4">
        <div class="col-sm-12 col-md-12 col-lg-12 p-3 reserva__price d-sm-none d-lg-block"
          style="border: 1px solid #cccfcf">
          <div class="fs-4 pb-2" style="border-bottom: 1px solid #cccfcf">
            Precio
          </div>
          <div class="col-12 pt-2" style="border-bottom: 1px solid #cccfcf; color: #8fa501">
            <strong>Tu reserva incluye</strong>
            <p class="pb-3">
              - Explicación detallada y descripción de los servicios.
            </p>
          </div>

          <div class="col-md-12 col-lg-12 d-flex flex-column pt-3">
            <p>Parking - Plan Premiun</p>
            <p>Recogida y entrega de Vehiculo</p>
            <?php if ($type_reserva == 9) { ?>
              <p>Techado</p>
              <p>Lavado Exterior Cortesia</p>
            <?php } ?>

            <?php if ($type_reserva == 12) { ?>
              <p>Lavado Interior/Exterior</p>
              <p>Parking Interior</p>
            <?php } ?>
          </div>
        </div>

        <div
          class="col-12 text-white p-3 mb-3 fs-4 d-flex justify-content-between align-items-center d-sm-none d-lg-flex reserva__price"
          style="background-color: #000000">
          <strong>Total a cancelar</strong>

          <span class="">
            <strong class="reserva__detail__monto">0</strong>€
          </span>
        </div>


        <div class="col-12">
          <h4 style="border-bottom: 1px solid #cccfcf; color: #8fa501" class="pb-2 mt-4">
            ¿Qué pasa después de esto?
          </h4>
          <ol class="stepper">
            <li>Recibiras una factura en tu correo.</li>
            <li>Puedes cambiar tu reserva 24 hrs antes.</li>
            <li>El día del viaje se recoge el vehiculo en el sitio.</li>
            <li class="active">
              El día de llegada se entrega el vehiculo en el sitio.
            </li>
          </ol>
        </div>

        <div class="col-12 mt-4">
          <h4 style="border-bottom: 1px solid #cccfcf; color: #8fa501" class="pb-2">
            ¿Tiene alguna pregunta?
          </h4>
          <p class="pt-2">
            Nuestro servicio de atención al cliente está abierto los 7 días de la
            semana. Llámanos o escribenos a
            <b>CONTACTO@APARCABARAJAS.ES</b>
          </p>
        </div>
      </div>

    </div>
    <?php ActiveForm::end(); ?>
  </section>
</main>

<!--div class="reservas-form" style="margin-top: 70px">

  <div class="col-lg-12">
    <div class="title-top">Formulario de Reserva - Solicitud de Servicio</div>
  </div>

  <div class="text-index" style="padding: 10px 15px 0px 15px">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">

      <?= $form->field($model, 'iva')->hiddenInput(['value' => $iva])->label(false) ?>
      <?= $form->field($model, 'dias')->hiddenInput(['value' => $cant_dias])->label(false) ?>

      <div class="col-lg-6">
        <div class="panel panel-default panel-d">
          <div class="panel-body panel-datos pnel">
            <div class="col-lg-12">
              <div class="subtitulo-reserva" style="margin-bottom: 20px;">Información de Reserva</div>
            </div>
            <div class="form-group">
              <div class="col-lg-4">
                <?php $recogida = '<span>Recogida &nbsp;</span><span class="tooltipcurved tooltipcurved-west">
                  <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                      <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                    </svg></span>
                  <span class="tooltipcurved-content">Día y Hora que dejarás el coche con uno de nuestros conductores calificados.</span>
                </span>'; ?>
                <?=
                  $form->field($model, 'fecha_entrada')->textInput([
                    'readonly' => true,
                    'style' => 'border-radius: 6px !important;'
                  ])->label($recogida) ?>
              </div>
              <div class="col-lg-2">
                <?= $form->field($model, 'hora_entrada')->textInput([
                  'readonly' => true,
                  'style' => 'border-radius: 6px !important;'
                ]) ?>
              </div>

              <div class="col-lg-4">
                <?php $devolucion = '<span>Devolución &nbsp;</span><span class="tooltipcurved tooltipcurved-west">
                  <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                      <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                    </svg></span>
                  <span class="tooltipcurved-content">Día y Hora en el que te devolveremos tu coche.</span>
                </span>'; ?>
                <?= $form->field($model, 'fecha_salida')->textInput([
                  'readonly' => true,
                  'style' => 'border-radius: 6px !important;'
                ])->label($devolucion); ?>
              </div>
              <div class="col-lg-2">
                <?= $form->field($model, 'hora_salida')->textInput([
                  'readonly' => true,
                  'style' => 'border-top-right-radius: 6px !important;border-bottom-right-radius: 8px !important;'
                ]) ?>
              </div>
            </div>
            <div class="col-lg-12"><br></div>

            <div class="col-lg-6">
              <?php $terminal_entrada = '<span>Terminal de Entrada &nbsp;</span><span class="tooltipcurved tooltipcurved-west">
                  <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                      <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                    </svg></span>
                  <span class="tooltipcurved-content">Terminal en donde nos dejarás tu coche. En caso de no saber la terminal sugerimos seleccionar "AUN NO CONOZCO LA TERMINAL"</span>
                </span>'; ?>
              <?= $form->field($model, 'terminal_entrada')->widget(Select2::classname(), [
                'data' => $terminales,
                'options' => ['placeholder' => 'Selecccione'],
                'pluginOptions' => [
                  'allowClear' => true
                ],
              ])->label($terminal_entrada); ?>
            </div>

            <div class="col-lg-6">
              <?php $terminal_salida = '<span>Terminal de Salida &nbsp;</span><span class="tooltipcurved tooltipcurved-west">
                  <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                      <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                    </svg></span>
                  <span class="tooltipcurved-content">Terminal en donde te entregaremos tu coche. En caso de no saber la terminal sugerimos seleccionar "AUN NO CONOZCO LA TERMINAL"</span>
                </span>'; ?>
              <?= $form->field($model, 'terminal_salida')->widget(Select2::classname(), [
                'data' => $terminales,
                'options' => ['placeholder' => 'Selecccione'],
                'pluginOptions' => [
                  'allowClear' => true
                ],
              ])->label($terminal_salida); ?>
            </div>

            <div class="col-lg-12"><br></div>

            <div class="col-lg-5">
              <?php $ciudad_procedencia = '<span>Ciudad de Procedencia &nbsp;</span><span class="tooltipcurved tooltipcurved-west">
                  <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                      <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                    </svg></span>
                  <span class="tooltipcurved-content">Rellena con el nombre de la ciudad de salida de tu viaje de regreso. ¿Haces escala? En ese caso, completa la ultima ciudad de la que salgas.</span>
                </span>'; ?>
              <?= $form->field($model, 'ciudad_procedencia')->textInput(['maxlength' => true])->label($ciudad_procedencia); ?>
            </div>

            <div class="col-lg-7">
              <?= $form->field($model, 'observaciones')->textarea(['rows' => '2']) ?>
            </div>
          </div>
        </div>
      </div>


      <div class="col-lg-6">
        <div class="panel panel-default panel-d">
          <div class="panel-body panel-datos">
            <div class="col-lg-12">
              <div class="subtitulo-reserva" style="margin-bottom: 20px">Datos del Cliente</div>
            </div>

            <div class="form-group">
              <div class="col-lg-6">
                <?= $form->field($modelC, 'nombre_completo')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>
              </div>

              <div class="col-lg-6">
                <?= $form->field($modelC, 'correo')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>
              </div>
            </div>

            <div class="form-group">
              <div class="col-lg-6">
                <?= $form->field($modelC, 'movil')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>
              </div>

              <div class="col-lg-6">
                <label class="control-label" for="coches-marca">Marca - Modelo</label>
                <?= $form->field($modelV, 'marca')->textInput(['maxlength' => true])->label(false) ?>
              </div>
            </div>

            <div class="col-lg-6">
              <?= $form->field($modelV, 'matricula')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-lg-12" style="margin-top: 23px; margin-bottom: 5px">
              <?= $form->field($model, 'factura')->checkbox(['onclick' => 'muestra("facturacion")', 'uncheck' => '0', 'value' => '1'])->label(false) ?>
            </div>


          </div>
        </div>
      </div>

      <div class="col-lg-12" id="marine"></div>

      <div id="facturacion1">
        <div class="col-lg-12">
          <div class="panel panel-default panel-d">
            <div class="panel-body panel-datos">

              <div class="col-lg-12" id="factura_cliente">
                <div class="subtitulo-reserva" style="margin-bottom: 20px">Información de Facturación</div>
              </div>

              <div class="col-lg-2">
                <?= $form->field($model, 'nif')->textInput(['maxlength' => true]) ?>
              </div>
              <div class="col-lg-4">
                <?= $form->field($model, 'razon_social')->textInput(['maxlength' => true]) ?>
              </div>
              <div class="col-lg-6">
                <?= $form->field($model, 'direccion')->textInput(['maxlength' => true]) ?>
              </div>

              <div class="col-lg-12"><br></div>

              <div class="col-lg-3">
                <?= $form->field($model, 'cod_postal')->textInput(['maxlength' => true]) ?>
              </div>
              <div class="col-lg-3">
                <?= $form->field($model, 'ciudad')->textInput(['maxlength' => true]) ?>
              </div>
              <div class="col-lg-3">
                <?= $form->field($model, 'provincia')->textInput(['maxlength' => true]) ?>
              </div>
              <div class="col-lg-3">
                <?= $form->field($model, 'pais')->textInput(['maxlength' => true]) ?>
              </div>

            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-12">
        <div class="panel panel-default panel-d">
          <div class="panel-body panel-datos">

            <div class="col-lg-12">
              <div class="subtitulo-reserva" style="margin-bottom: 20px">Servicios Extras Disponibles</div>
            </div>
            <div class="col-lg-8 col-xs-8">
              <div align="center" class="subtitulo-reserva sub-reserva">Descripción</div>
            </div>
            <div class="col-lg-2 col-xs-4">
              <div align="center" class="subtitulo-reserva sub-reserva">Precio</div>
            </div>
            <div class="col-lg-2">
              <div align="center" class="subtitulo-reserva sub-reserva na">Total</div>
            </div>

        <?= $form->field($model, 'type')->hiddenInput(['id' => 'type_reserva', 'value' => $type_reserva, 'name' => 'type'])->label(false) ?>
            <?php
            foreach ($servicios as $s) {
              $service = array($s->id => $s->nombre_servicio);
              ?>
  
        
        
              <?= $form->field($model, 'tipo_servicio')->hiddenInput(['id' => 'tipo_servicio' . $s->id, 'value' => $s->fijo, 'name' => 'tipo_servicio' . $s->id])->label(false) ?>

              <?= $form->field($model, 'cantidad')->hiddenInput(['id' => 'cantidad' . $s->id, 'min' => 1, 'value' => 0, 'name' => 'cantidad' . $s->id])->label(false) ?>

              <div id="mobile" style="<?= $s->id == 7 && $type_reserva != 9 ? 'display:none' : '' ?>">

                <div class="col-lg-8 col-xs-8">
                  <?= $form->field($model, 'servicios')->checkboxList($service, [
                    'separator' => '<br>',
                    'itemOptions' => [
                      'class' => 'servicios servi' . $s->id,
                      'precio' => $s->costo,
                      'labelOptions' => ['class' => 'services']
                    ]
                  ])->label(false);

                  ?>
                  <div class="des-reserva-ind"><?= $s->descripcion; ?></div><br>
                </div>

                <div class="col-lg-2 col-xs-4" style="margin-top:-8px">
                  <?= $form->field($model, 'precio_unitario', [
                    'template' => '<div class="input-group costos-facturas">{input}
                    <span class="input-group-addon eu">€</span></div>{error}{hint}'
                  ])->textInput(['id' => 'precio_unitario' . $s->id, 'readonly' => true, 'value' => $s->costo, 'class' => 'form-control cantidad', 'name' => 'precio_unitario' . $s->id]) ?>
                </div>

                <div class="col-lg-2 na" style="margin-top:-8px">
                  <?= $form->field($model, 'precio_total', [
                    'template' => '<div class="input-group costos-facturas">{input}
                    <span class="input-group-addon eu">€</span></div>{error}{hint}'
                  ])->textInput(['id' => 'precio_total' . $s->id, 'readonly' => true, 'class' => 'form-control cantidad', 'name' => 'precio_total' . $s->id]) ?>
                </div>

              </div>

            <?php } ?>

          </div>
        </div>
      </div>


      <div class="col-lg-12">
        <div class="panel panel-default panel-d">
          <div class="panel-body panel-datos">

            <div class="col-lg-12">
              <div class="subtitulo-reserva" style="margin-bottom: 20px">Total Costos de Reserva</div>
            </div>
            <div class="col-lg-1 col-xs-1 s">
              <div align="center" class="subtitulo-reserva sub-reserva">Items</div>
            </div>
            <div class="col-lg-9 col-xs-8">
              <div align="center" class="subtitulo-reserva sub-reserva">Descripción</div>
            </div>
            <div class="col-lg-2 col-xs-4">
              <div align="center" class="subtitulo-reserva sub-reserva">Total</div>
            </div>

            <div id="mobile">

            <input type="hidden"  name="servicio_noc_id" value="<?= !is_null($nocturno) ? $nocturno[0]['id'] : 0 ?>">
            <input type="hidden" id="servicio_noc" name="servicio_noc_costo" value="<?= !is_null($nocturno) ? $nocturno[0]['costo'] : 0 ?>">
            <?php if (!is_null($nocturno)) { ?>
              <div class="col-lg-1 col-xs-1 s">
                <label class="num">SN</label>
              </div>

              <div class="col-lg-9 col-xs-8">
                <label class="service-reserva"><?= $nocturno[0]['nombre_servicio'] ?></label>
                <div class="des-reserva-ind mb" style="margin-left: 0px"><?= $nocturno[0]['descripcion'] ?></div>
              </div>

              <div class="col-lg-2 col-xs-4" style="margin-top:-8px">
                <?= $form->field($model, 'servicio_nocturno', [
                  'template' => '<div class="input-group costos-facturas">{input}
                    <span class="input-group-addon eu">€</span></div>{error}{hint}'
                ])->textInput(['readonly' => true, 'class' => 'form-control cantidad', 'value' => $nocturno[0]['costo']]) ?>
              </div>

              <div class="col-lg-12 col-xs-12">
                <hr style="margin-top: 20px; margin-bottom: 15px">
              </div>
              <?php } ?>

              <div class="col-lg-1 col-xs-1 s">
                <label class="num">1</label>
              </div>

              <div class="col-lg-9 col-xs-8">
                <label class="service-reserva"><?= $precio_diario[0]['nombre_servicio'] ?></label>
                <div class="des-reserva-ind mb" style="margin-left: 0px"><?= $precio_diario[0]['descripcion'] ?></div>
              </div>

              <div class="col-lg-2 col-xs-4" style="margin-top:-8px">
                <?= $form->field($model, 'costo_servicios', [
                  'template' => '<div class="input-group costos-facturas">{input}
                    <span class="input-group-addon eu">€</span></div>{error}{hint}'
                ])->textInput(['readonly' => true, 'class' => 'form-control cantidad', 'value' => '0.00']) ?>
              </div>

              <div class="col-lg-12 col-xs-12">
                <hr style="margin-top: 20px; margin-bottom: 15px">
              </div>

              <div class="col-lg-1 col-xs-1 s">
                <label class="num">2</label>
              </div>

              <div class="col-lg-9 col-xs-8">
                <label class="service-reserva"><?= $seguro[0]->nombre_servicio ?></label>
                <div class="des-reserva-ind mb" style="margin-left: 0px"><?= $seguro[0]->descripcion ?></div>
              </div>

              <div class="col-lg-2 col-xs-4">
                <?= $form->field($model, 'total_seguro', [
                  'template' => '<div class="input-group costos-facturas">{input}
                    <span class="input-group-addon eu">€</span></div>{error}{hint}'
                ])->textInput(['id' => 'total_seguro', 'readonly' => true, 'class' => 'form-control cantidad', 'name' => 'total_seguro', 'value' => $seguro[0]->costo]) ?>
              </div>

              <div class="col-lg-12 col-xs-12">
                <hr style="margin-top: 20px; margin-bottom: 15px">
              </div>

              <div class="col-lg-1 col-xs-1 s">
                <label class="num">3</label>
              </div>

              <div class="col-lg-9 col-xs-8">
                <label class="service-reserva">Servicios Extras Seleccionados</label>
                <div class="des-reserva-ind mb" style="margin-left: 0px">Otros servicios extras</div>
              </div>

              <div class="col-lg-2 col-xs-4">
                <?= $form->field($model, 'costo_servicios_extra', [
                  'template' => '<div class="input-group costos-facturas">{input}
                    <span class="input-group-addon eu">€</span></div>{error}{hint}'
                ])->textInput(['readonly' => true, 'class' => 'form-control cantidad', 'value' => '0.00']) ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="hide">
        <div class="col-lg-2" style="margin-top:-8px">
          <?= $form->field($model, 'servicio_basico', [
            'template' => '<div class="input-group costos-facturas">{input}
              <span class="input-group-addon eu">€</span></div>{error}{hint}'
          ])->textInput(['id' => 'servicio_basico', 'readonly' => true, 'value' => $precio_diario[0]['costo'], 'class' => 'form-control cantidad', 'name' => 'servicio_basico']) ?>
        </div>

        <div class="col-lg-1" style="margin-top:-8px">
          <?= $form->field($model, 'cant_basico', [
            'template' => '<div class="input-group costos-facturas">{input}
              </div>{error}{hint}'
          ])->textInput(['id' => 'cant_basico', 'type' => 'number', 'readonly' => true, 'class' => 'form-control cantidad', 'name' => 'cant_basico', 'value' => $cant_dias]) ?>
        </div>


        <div class="col-lg-2" style="margin-top:-8px">
          <?= $form->field($model, 'seguro')->hiddenInput(['id' => 'seguro', 'readonly' => true, 'value' => $seguro[0]->costo, 'class' => 'form-control cantidad', 'name' => 'seguro'])->label(false) ?>
        </div>

        <div class="col-lg-1" style="margin-top:-8px">
          <?= $form->field($model, 'cant_seguro', [
            'template' => '<div class="input-group costos-facturas">{input}
              </div>{error}{hint}'
          ])->hiddenInput(['id' => 'cant_seguro', 'readonly' => true, 'class' => 'form-control cantidad', 'name' => 'cant_seguro', 'value' => 1]) ?>
        </div>
      </div>

      <div class="col-lg-12 col-xs-12">
        <div class="panel panel-default panel-d d2" style="margin-bottom: 0px">
          <div class="panel-body panel-datos otherp">

            <div class="col-lg-3 col-xs-12">
              <?= $form->field($model, 'id_tipo_pago')->widget(Select2::classname(), [
                'data' => $tipos_pago,
                'options' => ['placeholder' => 'Selecccione forma de pago'],
                'pluginOptions' => [
                  'allowClear' => true
                ],
              ]); ?>
            </div>

            <div class="col-lg-5 col-xs-10" style="margin-top: 32px; padding-left: 25px">
              <?= $form->field($model, 'condiciones')->checkbox(['uncheck' => ' ', 'value' => '1'])->label(false) ?>
            </div>

            <div class="col-lg-2 col-xs-7" style="margin-top: 10px">
              <div id="subtotal-factura" class="totales-facturas">Total a Pagar</div>
            </div>

            <div class="col-lg-2 col-xs-5" style="margin-top: 10px">
              <?= $form->field($model, 'monto_factura', [
                'template' => '<div class="input-group costos-facturas">{input}
                  <span class="input-group-addon eu">€</span></div>{error}{hint}'
              ])->textInput(['maxlength' => true, 'readonly' => true, 'value' => '0.00']) ?>
            </div>

            <?= $form->field($model, 'monto_impuestos')->hiddenInput()->label(false) ?>
            <?= $form->field($model, 'monto_total')->hiddenInput()->label(false) ?>

            <div class="col-lg-12">
              <hr style="border-top: 2px dashed #ccc">
            </div>

            <div class="col-lg-8">
              <div class="hide" style="text-transform: uppercase; color: red; font-size: 0.8em">Estimado Usuario la forma de pago Online se encuentra en periodo de pruebas. <br>NO seleccione este medio de pago</div>
            </div>

            <div id="cancelar" align="right" class="col-lg-2 col-xs-12" style="margin-top: 5px; margin-bottom: 25px">
              <?= Html::a('Cancelar', ['/site/index'], ['class' => 'btn btn-warning btn-block']) ?>
            </div>

            <div id="guardar" align="right" class="col-lg-2 col-xs-12" style="margin-top: 5px; margin-bottom: 25px">
              <div class="form-group">
                <?= Html::submitButton('Finalizar Reserva', ['class' => 'btn btn-success btn-block', 'id' => 'finalizar']) ?>
              </div>
            </div>



          </div>
        </div>
      </div>

    </div>
    <?php ActiveForm::end(); ?>
  </div>
</div-->

<?php
$this->registerJs(" 

    $( document ).ready(function() {
	
	$('.servicios').each(function() {
	
			if($(this).val() == $('#type_reserva').val()){
				$(this).prop('checked',true);
				$(this).prop('disabled',true);
				
				var id = $(this).val();
                var tipo_servicio = $('#tipo_servicio'+ id).val();
                var precio = $('#precio_unitario'+ id).val();
                $('#cantidad'+ id).prop('readonly',false);
                cant = $('#cantidad'+ id).val();               
                if (cant == 0) {
                  $('#cantidad'+ id).val(1);
                  /*$('#precio_total'+ id).val(precio);*/
                } 
				
				if($('#type_reserva').val() == 12){
					$('.servi2').prop('checked',true);
					$('.servi2').prop('disabled',true);
					var tipo_servicio = $('#tipo_servicio2').val();
					var precio = $('#precio_unitario2').val();
					$('#cantidad2').prop('readonly',false);
					cant = $('#cantidad2').val();               
					if (cant == 0) {
					  $('#cantidad2').val(1);
					  /*$('#precio_total2').val(precio);*/
					} 
				}
				
				if($('#type_reserva').val() == 9){
					$('.servi7').prop('checked',true);
					$('.servi7').prop('disabled',true);
					var tipo_servicio = $('#tipo_servicio7').val();
					var precio = $('#precio_unitario7').val();
					$('#cantidad7').prop('readonly',false);
					cant = $('#cantidad7').val();               
					if (cant == 0) {
					  $('#cantidad7').val(1);
					  $('#precio_total7').val(precio);
					} 
				}
				
                $('.totales-facturas').click();
			}
	});
			precio_dia = $('#precio_dia').val();
      cant = $('#cant_basico').val();
      precio1 = $('#precio-diario1').val();
      precio2 = $('#precio-diario2').val();
      precio3 = $('#precio-diario3').val();
      precio4 = $('#precio-diario4').val();
      precio5 = $('#precio-diario5').val();
      precio6 = $('#precio-diario6').val();
      precio7 = $('#precio-diario7').val();
      precio8 = $('#precio-diario8').val();
      precio9 = $('#precio-diario9').val();
      precio10 = $('#precio-diario10').val();

      precio11 = $('#precio-diario11').val();
      precio12 = $('#precio-diario12').val();
      precio13 = $('#precio-diario13').val();
      precio14 = $('#precio-diario14').val();
      precio15 = $('#precio-diario15').val();
      precio16 = $('#precio-diario16').val();
      precio17 = $('#precio-diario17').val();
      precio18 = $('#precio-diario18').val();
      precio19 = $('#precio-diario19').val();
      precio20 = $('#precio-diario20').val();

      precio21 = $('#precio-diario21').val();
      precio22 = $('#precio-diario22').val(); 
      precio23 = $('#precio-diario23').val(); 
      precio24 = $('#precio-diario24').val(); 
      precio25 = $('#precio-diario25').val(); 
      precio26 = $('#precio-diario26').val(); 
      precio27 = $('#precio-diario27').val(); 
      precio28 = $('#precio-diario28').val(); 
      precio29 = $('#precio-diario29').val(); 
      precio30 = $('#precio-diario30').val(); 

      var total = 0;
      if (cant == 1) { total = parseFloat(precio1); }                     
      if (cant == 2) { total = parseFloat(precio2); }
      if (cant == 3) { total = parseFloat(precio3); }
      if (cant == 4) { total = parseFloat(precio4); }
      if (cant == 5) { total = parseFloat(precio5); }
      if (cant == 6) { total = parseFloat(precio6); }
      if (cant == 7) { total = parseFloat(precio7); }
      if (cant == 8) { total = parseFloat(precio8); }
      if (cant == 9) { total = parseFloat(precio9); }
      if (cant == 10) { total = parseFloat(precio10); }

      if (cant == 11) { total = parseFloat(precio11); }                     
      if (cant == 12) { total = parseFloat(precio12); }
      if (cant == 13) { total = parseFloat(precio13); }
      if (cant == 14) { total = parseFloat(precio14); }
      if (cant == 15) { total = parseFloat(precio15); }
      if (cant == 16) { total = parseFloat(precio16); }
      if (cant == 17) { total = parseFloat(precio17); }
      if (cant == 18) { total = parseFloat(precio18); }
      if (cant == 19) { total = parseFloat(precio19); }
      if (cant == 20) { total = parseFloat(precio20); }

      if (cant == 21) { total = parseFloat(precio21); }                     
      if (cant == 22) { total = parseFloat(precio22); }
      if (cant == 23) { total = parseFloat(precio23); }
      if (cant == 24) { total = parseFloat(precio24); }
      if (cant == 25) { total = parseFloat(precio25); }
      if (cant == 26) { total = parseFloat(precio26); }
      if (cant == 27) { total = parseFloat(precio27); }
      if (cant == 28) { total = parseFloat(precio28); }
      if (cant == 29) { total = parseFloat(precio29); }
      if (cant == 30) { total = parseFloat(precio30); }       
	  

     /* if (cant > 30) { 
        var cant_dias = cant - 30;
        var precio_relativo = parseFloat(precio30);
        var total = precio_relativo + (cant_dias * parseFloat(precio_dia)); 
      }*/

      if(cant > 30){
        while (cant > 30) {
          total +=  parseFloat(precio30);
          cant =  cant - 30;

          /*console.log(cant);
          console.log(total);*/
        }

        if(cant >= 18){
          total +=  parseFloat(precio30);
          //console.log(total);
        }else {
          total += (cant * parseFloat(precio_dia));
          //console.log(total);
        }
      }

      $('#reservas-costo_servicios').val(total.toFixed(2));
      $('.totales-facturas').click();
      });      
	  
  
		$('#finalizar').on('click', function(){
			if($('#reservas-factura').is(':checked') && $('#reservas-nif').val() === '' || $('#reservas-razon_social').val() === '' || $('#reservas-direccion').val() === '' || $('#reservas-ciudad').val() === '' || $('#reservas-provincias').val() === '' || $('#reservas-pais').val() === ''){
				$('#factura_cliente').text('').append('<div class=\"subtitulo-reserva\" style=\"text-decoration: none;padding: 12px 0;\">* Debe llenar los campos de facturación</div>')
				$('html, body').animate({ scrollTop: $('#facturacion').offset().top }, 1000);
			}else if($('#reservas-id_tipo_pago').val() !== '' && $('#reservas-condiciones').is(':checked') && $('#reservas-id_tipo_pago').val() !== '' && $('#clientes-correo').val() !== '' && $('#clientes-movil').val() !== ''){
			  $(this)
				.text('')
				.removeClass('btn-success')
				.addClass('btn-primary')
				.html('<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Espere...')
				.attr('disabled', 'disabled')
				.trigger('submit');
			}  
		  });
		  
      $('#checkAll').change(function() {
        $('.select:checked').each(function() {
          $('.servicios').click();
          }); 
          $('.select:checkbox:not(:checked)').each(function() { 
            $('.servicios').click();           
            });
            })
			
			
            
			$('.servicios').change(function() {

              $('.servicios:checked').each(function() {
			  
					var id = $(this).val();
					var tipo_servicio = $('#tipo_servicio'+ id).val();
					var precio = $('#precio_unitario'+ id).val();
					$('#cantidad'+ id).prop('readonly',false);
					cant = $('#cantidad'+ id).val();        
					if (tipo_servicio == 1) {
					  $('#cantidad'+ id).prop('readonly',true);
					}

					if (cant == 0) {
					  $('#cantidad'+ id).val(1);
					  $('#precio_total'+ id).val(precio).css('background','blue');
					} 
					$('.totales-facturas').click();
                });

                var id = $(this).val();
                var tipo_servicio = $('#tipo_servicio'+ id).val();

                $('#cantidad'+ id).change(function() {

                  var cant = $('#cantidad'+ id).val(); 
                  var precio = $('#precio_unitario'+ id).val();
                  var precio_new = parseFloat(precio) * cant;
                  $('#precio_total'+ id).val(precio_new.toFixed(2)); 
                  $('.totales-facturas').click();                

                  })           

                  $('.servicios:checkbox:not(:checked)').each(function() {
                    var id = $(this).val();
                    $('#cantidad'+ id).val(0);
                    $('#cantidad'+ id).prop('readonly',true);
                    $('#precio_total'+ id).val(0);
                    $('.totales-facturas').click();
                    });           

                    }) 

                    $('#subtotal-factura').click(function() {
                      var monto_subtotal = 0;
                      var imp = $('#reservas-iva').val();
                      $('.servicios:checked').each(function() {
                        var id = $(this).val();
                        //var precio = $('#precio_total'+ id).val();
						var precio = $('#precio_unitario'+ id).val();
                        monto_subtotal = parseFloat(monto_subtotal) + parseFloat(precio);
						
                      });             

                        $('#reservas-costo_servicios_extra').val(monto_subtotal.toFixed(2));
                        var total_seguro = $('#reservas-total_seguro').val();
                        var costo_servicios = $('#reservas-costo_servicios').val();
                        var stotal_reserva = monto_subtotal + parseFloat(total_seguro) + parseFloat(costo_servicios);


                        $('#reservas-monto_factura').val(stotal_reserva.toFixed(2));
                        var impuestos = 0;
                        $('#reservas-monto_impuestos').val(impuestos.toFixed(2));
                        var total_monto = parseFloat(stotal_reserva) + parseFloat(impuestos);
                        $('#reservas-monto_total').val(total_monto.toFixed(2));
						$('.reserva__detail__monto').html('').append(total_monto.toFixed(2));
                        }); 
                        
                        $('#reservas-factura').click(function(){ 
                            if( $('#reservas-factura').prop('checked') ) {
                                $('#reservas-nif').prop('required', true);
                                $('#reservas-razon_social').prop('required', true);
                                $('#reservas-direccion').prop('required', true);
                                $('#reservas-cod_postal').prop('required', true);
                                $('#reservas-ciudad').prop('required', true);
                                $('#reservas-provincias').prop('required', true);
                                $('#reservas-pais').prop('required', true);
                                console.log('si')
                            }else{
                                $('#reservas-nif').removeAttr('required');
                                $('#reservas-razon_social').removeAttr('required');
                                $('#reservas-direccion').removeAttr('required');
                                $('#reservas-cod_postal').removeAttr('required');
                                $('#reservas-ciudad').removeAttr('required');
                                $('#reservas-provincias').removeAttr('required');
                                $('#reservas-pais').removeAttr('required');
                                console.log('no')
                            } 
                        });

                        ");
?>

<script>
  function muestra(id) {
    if (document.getElementById) {
      var contenido = document.getElementById(id);
      contenido.style.display = (contenido.style.display == 'none') ? 'block' : 'none';
    }
  }

  window.onload = function () {
    muestra('facturacion');
  }

  function buscarCliente() {
    $('#reservas-correo').prop('readonly', false);
    $('#reservas-tipo_documento').prop('readonly', false);
    $('#reservas-nro_documento').prop('readonly', false);
    $('#reservas-movil').prop('readonly', false);
    var id_cliente = $("#reservas-id_cliente").val()

    $.ajax({
      url: '<?php echo \Yii::$app->getUrlManager()->createUrl('reservas/clientes') ?>',
      type: 'post',
      data: {
        id: id_cliente
      },
      success: function (data) {
        correo = data.datos['correo'];
        tipo_documento = data.datos['tipo_documento'];
        nro_documento = data.datos['nro_documento'];
        movil = data.datos['movil'];
        $("#reservas-correo").val(correo);
        $("#reservas-tipo_documento").val(tipo_documento);
        $("#reservas-nro_documento").val(nro_documento);
        $("#reservas-movil").val(movil);
      },
      error: function () {
        console.log("failure");
      }
    });
  }

  function buscarCoche() {

    $("#reservas-color").css("background-color", '#eeeeee');
    var id_coche = $("#reservas-id_coche").val()

    $.ajax({
      url: '<?php echo \Yii::$app->getUrlManager()->createUrl('reservas/vehiculos') ?>',
      type: 'post',
      data: {
        id: id_coche
      },
      success: function (data) {
        matricula = data.datos['matricula'];
        color = data.datos['color'];
        $("#reservas-matricula").val(matricula);
        $("#reservas-color").css("background-color", color);
      },
      error: function () {
        console.log("failure");
      }
    });
  }
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })

  setTimeout(() => {
    var extraNocturno = $('#servicio_noc').val();

    if (extraNocturno !== 0) {
      var total = $('#reservas-monto_total').val();
      total = parseFloat(total) + parseFloat(extraNocturno);

      $('#reservas-monto_factura').val(total.toFixed(2));
      $('.reserva__detail__monto').html('').append(total.toFixed(2));
    }
  }, 1000);



</script>