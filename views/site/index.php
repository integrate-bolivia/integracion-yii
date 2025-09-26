<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Sectores Educativos';

$session = Yii::$app->session;
$loginResult = $session->getFlash('loginResult');
$productosResult = $session->getFlash('productosResult');
$facturasResult = $session->getFlash('facturasResult');
$parametrosResult = $session->getFlash('parametrosResult');
$registrarFacturaResult = $session->getFlash('registrarFacturaResult');
?>

<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Panel GraphQL Educativo</h1>
        <p class="lead">Consultas y operaciones con el servicio ISIPASS</p>
    </div>

    <div class="body-content">

        <div class="row mb-4 text-center">

            <!-- Login -->
            <div class="col-md-2">
                <?= Html::beginForm(['graphql-educativo/login'], 'post') ?>
                <?= Html::submitButton('Login', ['class' => 'btn btn-success w-100']) ?>
                <?= Html::endForm() ?>
            </div>

            <!-- Productos -->
            <div class="col-md-2">
                <?= Html::beginForm(['graphql-educativo/productos'], 'post') ?>
                <?= Html::submitButton('Productos', ['class' => 'btn btn-primary w-100']) ?>
                <?= Html::endForm() ?>
            </div>

            <!-- Facturas -->
            <div class="col-md-2">
                <?= Html::beginForm(['graphql-educativo/facturas-lista'], 'post') ?>
                <?= Html::submitButton('Facturas', ['class' => 'btn btn-info w-100']) ?>
                <?= Html::endForm() ?>
            </div>

            <!-- Clientes -->
            <div class="col-md-2">
                <?= Html::beginForm(['graphql-educativo/clientes-lista'], 'post') ?>
                <?= Html::submitButton('Clientes', ['class' => 'btn btn-warning w-100']) ?>
                <?= Html::endForm() ?>
            </div>


            <!-- Registrar factura -->
            <div class="col-md-2">
                <?= Html::beginForm(['graphql-educativo/registrar-factura'], 'post') ?>
                <?= Html::submitButton('Registrar Factura', ['class' => 'btn btn-outline-success w-100']) ?>
                <?= Html::endForm() ?>
            </div>
        </div>

        <!-- Resultados -->
        <?php if ($loginResult): ?>
            <div class="alert alert-success">
                <h5>Login</h5>
                <pre><?= $loginResult ?></pre>
            </div>
        <?php endif; ?>

        <?php if ($productosResult): ?>
            <div class="alert alert-primary">
                <h5>Productos</h5>
                <pre><?= $productosResult ?></pre>
            </div>
        <?php endif; ?>

        <?php if ($facturasResult): ?>
            <div class="alert alert-info">
                <h5>Facturas</h5>
                <pre><?= $facturasResult ?></pre>
            </div>
        <?php endif; ?>

        <?php if ($registrarFacturaResult): ?>
            <div class="alert alert-success">
                <h5>Factura registrada</h5>
                <pre><?= $registrarFacturaResult ?></pre>
            </div>
        <?php endif; ?>
    </div>
</div>