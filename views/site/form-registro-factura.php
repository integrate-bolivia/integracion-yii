<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Registrar Factura';
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'codigoCliente')->textInput() ?>
<?= $form->field($model, 'email')->textInput() ?>
<?= $form->field($model, 'actividadEconomica')->textInput() ?>
<?= $form->field($model, 'codigoMetodoPago')->textInput() ?>
<?= $form->field($model, 'descuentoAdicional')->textInput() ?>
<?= $form->field($model, 'nombreEstudiante')->textInput() ?>
<?= $form->field($model, 'periodoFacturado')->textInput() ?>
<?= $form->field($model, 'detalle')->textarea(['rows' => 6, 'placeholder' => '[{"codigoProducto":"1010","descripcionProducto":"Pago Mensualidad","cantidad":10,"unidadMedida":58,"precioUnitario":50.52,"montoDescuento":0}]']) ?>

<div class="form-group">
    <?= Html::submitButton('Registrar Factura', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
